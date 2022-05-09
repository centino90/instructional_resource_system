<?php

namespace App\Http\Controllers;

use App\DataTables\View\ResourceActivitiesDataTable;
use App\DataTables\View\ResourceDataTable;
use App\Events\ResourceCreated;
use App\HelperClass\OfficeToPdfHelper;
use App\HelperClass\PdfToHtmlHelper;
use App\Http\Requests\StoreResourceByUrlRequest;
use App\Http\Requests\StoreResourceRequest;
use App\Imports\ResourceImport;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Media;
use App\Models\Resource;
use App\Models\TemporaryUpload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use NcJoes\OfficeConverter\OfficeConverter;
use Spatie\MediaLibrary\Support\MediaStream;
use PhpOffice\PhpWord\IOFactory;
use Error;
use Illuminate\Http\Response;
use setasign\Fpdi\Tcpdf\Fpdi;

class ResourceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourceDataTable $dataTable)
    {
        return $dataTable->render('pages.resources');
    }

    public function viewVersions(Resource $resource)
    {
        $this->authorize('view', $resource);

        return view('pages.resource-versions', compact('resource'));
    }

    public function create(Lesson $lesson)
    {
        $this->authorize('create', Resource::class);

        $resourceActivities = $lesson->resources()->with('activityLogs')->where('is_syllabus', false)->get()->map(function ($item, $key) {
            return $item->activityLogs->filter(function ($value, $key) {
                return Str::contains($value->log_name, ['resource-created', 'resource-versioned']);
            });
        })->flatten()->sortByDesc('created_at');

        return view('pages.course-resource-create', compact('lesson', 'resourceActivities'));
    }

    public function createNewVersion(Resource $resource)
    {
        $this->authorize('update', $resource);

        return view('pages.resource-show-create-version', compact('resource'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResourceRequest $request)
    {
        $this->authorize('create', Resource::class);

        try {
            $batchId = Str::uuid();
            $index = 0;
            $resources = collect();
            $failes = collect();
            foreach ($request->file as $file) {
                $temporaryFile = TemporaryUpload::firstWhere('folder_name', $file);

                if ($temporaryFile) {
                    // exclude unexecutable files
                    if (empty(pathinfo($temporaryFile->file_name, PATHINFO_EXTENSION))) {
                        $temporaryFile->delete();
                        $failes->push($temporaryFile->file_name);
                        continue;
                    }

                    $r = Resource::create([
                        'course_id' => $request->course_id,
                        'lesson_id' => $request->lesson_id,
                        'user_id' => auth()->id(),
                        // 'resource_type_id' => ResourceType::TYPE_REGULAR,
                        'batch_id' => $batchId,
                        'description' => $request->description[$index],
                        'title' => $request->title[$index],
                        'approved_at' => now()
                    ]);

                    $tmpPath = storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name);

                    $newFilePath = $this->filenameFormatter('users/' . auth()->id() . '/submissions/' . $temporaryFile->file_name);
                    $newFilename = pathinfo($newFilePath, PATHINFO_FILENAME) . '.' . pathinfo($newFilePath, PATHINFO_EXTENSION);

                    $randName = pathinfo($tmpPath, PATHINFO_BASENAME) . time();
                    if (!auth()->user()->isStorageFull()) {
                        Storage::disk('public')->putFileAs('users/' . auth()->id() . '/submissions', $tmpPath, $randName);
                    }

                    $r->addMedia($tmpPath)->toMediaCollection();

                    rmdir(storage_path('app/public/resource/tmp/' . $file));

                    event(new ResourceCreated($r));
                    $temporaryFile->delete();

                    $r = Resource::with('media', 'user', 'lesson')->findOrFail($r->id);
                    $r->mimetype = $r->getFirstMedia() ? $r->getFirstMedia()->mime_type : null;

                    $resources->push($r);

                    $index++;
                }
            }

            return redirect()
                ->route('resource.create', $request->lesson_id)
                ->with([
                    'status' => 'success',
                    'message' => sizeof($resources) . ' resource(s) were successfully uploaded and ' . sizeof($failes) . ' failed.',
                    'resources' => $resources
                ]);
        } catch (\Throwable $th) {
            $statusCode = in_array($th->getCode(), array_keys(Response::$statusTexts)) ? $th->getCode() : 500;

            return redirect()
                ->back()
                ->withErrors([
                    'message' => $th->getMessage()
                ]);
        }
    }
    public function storeByUrl(StoreResourceByUrlRequest $request)
    {
        $this->authorize('create', Resource::class);

        abort_if(
            $request->user()->cannot('create', Resource::class),
            403
        );

        $filePath = str_replace(url('storage') . '/', "", $request->fileUrl);
        $fileExt = pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);
        if (empty($fileExt)) {
            return redirect()->back()->withErrors([
                'message' => 'Error! Files without extension are not allowed'
            ]);
        }

        $filename = pathinfo($this->filenameFormatter($filePath), PATHINFO_FILENAME) . '.' . $fileExt;
        $model = Resource::create([
            'course_id' => $request->course_id,
            'lesson_id' => $request->lesson_id,
            'user_id' => auth()->id(),
            'description' => $request->description,
            'title' => $request->title,
            'approved_at' => now()
        ]);

        // Storage::disk('public')->put('users/' . auth()->id() . '/resources/' . $filename, storage_path('app/public/' . $filePath));
        $model->addMediaFromDisk($filePath, 'public')->preservingOriginal()->toMediaCollection();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', $model->title . ' was uploaded successfully.');

        return redirect()->route('resource.create', $request->lesson_id);
    }

    public function storeNewVersion(Request $request, Resource $resource)
    {
        $this->authorize('update', $resource);

        $temporaryFile = TemporaryUpload::firstWhere('folder_name', $request->file);

        if ($temporaryFile) {
            if (empty(pathinfo($temporaryFile->file_name, PATHINFO_EXTENSION))) {
                $temporaryFile->delete();
                dd('file not exceutable');
            }

            $tmpPath = storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name);
            $newFilePath = $this->filenameFormatter('users/' . auth()->id() . '/resources/' . $temporaryFile->file_name);
            $newFilename = pathinfo($newFilePath, PATHINFO_FILENAME) . '.' . pathinfo($newFilePath, PATHINFO_EXTENSION);

            Storage::disk('public')->putFileAs('users/' . auth()->id() . '/resources', $tmpPath, $newFilename);
            $resource->addMedia($tmpPath)->toMediaCollection();

            rmdir(storage_path('app/public/resource/tmp/' . $request->file));

            // event(new ResourceCreated($r)); // ResourceVersionCreated
            $temporaryFile->delete();
        }

        if ($resource->hasMultipleMedia) {
            activity()
                ->causedBy($resource->user)
                ->useLog('resource-versioned')
                ->performedOn($resource)
                ->withProperties($resource->toArray())
                ->log("{$resource->user->nameTag} created a new version of {$resource->title} (id: {$resource->id})");
        }

        if ($resource->resourceType == 'syllabus') {
        } else if ($resource->resourceType == 'presentation') {
            return redirect()->route('presentations.storeNewVersion', $resource);
        }

        return redirect()->route('resource.viewVersions', $resource)->with([
            'status' => 'success',
            'message' => "{$resource->currentMediaVersion->file_name} was added as the new version successfully"
        ]);
    }

    public function storeNewVersionByUrl(StoreResourceByUrlRequest $request, Resource $resource)
    {
        $this->authorize('update', $resource);

        $filePath = str_replace(url('storage') . '/', "", $request->fileUrl);
        $filename = pathinfo($this->filenameFormatter($filePath), PATHINFO_FILENAME) . '.' . pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);

        if (empty(pathinfo($filename, PATHINFO_EXTENSION))) {
            dd('file not exceutable');
        }

        Storage::disk('public')->put('users/' . auth()->id() . '/resources/' . $filename, storage_path('app/public/' . $filePath));
        $resource->addMediaFromDisk($filePath, 'public')->preservingOriginal()->toMediaCollection();

        // event(new ResourceCreated($r)); // ResourceVersionCreated

        return redirect()->route('resource.createNewVersion', compact('resource'))->with([
            'status' => 'success',
            'message' => $resource->currentMediaVersion->file_name . ' was added as the new version successfully.'
        ]);
    }

    public function confirm(Request $request)
    {
        $this->authorize('create', Resource::class);

        $resourceIds = $request->resources;
        $resource = Resource::whereIn('id', [$resourceIds])->update([
            'approved_at' => now()
        ]);

        return redirect()
            ->route('resource.createOld', $request->lesson_id)
            ->with([
                'status' => 'success',
                'message' => sizeof($resourceIds) . ' old resource(s) were successfully imported and 0 failed.',
                'resources' => $resourceIds
            ]);
    }

    private function filenameFormatter($filePath)
    {
        if (Storage::exists($filePath)) {
            // Split filename into parts
            $pathInfo = pathinfo($filePath);
            $extension = isset($pathInfo['extension']) ? ('.' . $pathInfo['extension']) : '';

            // Look for a number before the extension; add one if there isn't already
            if (preg_match('/(.*?)(\d+)$/', $pathInfo['filename'], $match)) {
                // Have a number; get it
                $base = $match[1];
                $number = intVal($match[2]);
            } else {
                // No number; pretend we found a zero
                $base = $pathInfo['filename'];
                $number = 0;
            }

            // Choose a name with an incremented number until a file with that name
            // doesn't exist
            do {
                $filePath = $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $base . '(' . ++$number . ')' . $extension;
            } while (Storage::exists($filePath));
        }

        return $filePath;
    }

    public function show(ResourceActivitiesDataTable $dataTable, Resource $resource)
    {
        $this->authorize('view', $resource);

        $resource = Resource::whereHas('course')->findOrFail($resource->id);

        foreach (auth()->user()->notifications as $notification) {
            if (isset($notification->data) && isset($notification->data['subject'])) {
                if ($notification->data['subject']['id'] == $resource->id) {
                    $notification->markAsRead();
                }
            }
        }

        return $dataTable->render('pages.resource-show', compact('resource'));
    }

    public function preview(Request $request, Resource $resource)
    {
        $this->authorize('view', $resource);

        $resource->with('media', 'user');

        try {
            if (!empty($request->mediaId)) {
                if (!$specifiedMedia = $resource->getMedia()->firstWhere('id', $request->mediaId)) {
                    throw new Error('Resource file not found.', 404);
                } else {
                    $mediaFileExt = strtolower(pathinfo($specifiedMedia->getPath(), PATHINFO_EXTENSION));
                }
            } else {
                $specifiedMedia = $resource->getMedia()->sortByDesc('order_column')->first();
                $mediaFileExt = strtolower(pathinfo($specifiedMedia->getPath(), PATHINFO_EXTENSION));
            }

            if (!$mediaFileExt) {
                throw new Error('Resource file not found.', 404);
            }


            $newFilename = auth()->user()->username . '-preview-resource';
            $newFileExt = 'pdf';

            if (
                !in_array($mediaFileExt, array_merge(
                    array_values(config('app.text_filetypes')),
                    array_values(config('app.spreadsheet_convertible_filetypes')),
                    array_values(config('app.pdf_convertible_filetypes')),
                    array_values(config('app.img_filetypes')),
                    array_values(config('app.video_filetypes')),
                    array_values(config('app.audio_filetypes')),
                    ['pdf']
                ))
                || $resource->getMedia()->sortByDesc('order_column')->first()->mime_type == 'application/x-empty'
            ) {
                throw new Error('Resource filetype is not previewable.', 415);
            }

            /* IMAGE, VIDEO, AUDIO */
            if (
                in_array($mediaFileExt, config('app.img_filetypes'))
                || in_array($mediaFileExt, config('app.video_filetypes'))
                || in_array($mediaFileExt, config('app.audio_filetypes'))
            ) {

                return view('pages.resource-preview')->with([
                    'resource' => $resource,
                    'media' => $specifiedMedia,
                    'message' => 'Resource is previewable',
                    'fileType' => $this->getFileTypeGroup($mediaFileExt),
                    'fileMimeType' => mime_content_type($specifiedMedia->getPath()),
                    'resourceUrl' => 'data:' . $specifiedMedia->mime_type . ';base64,' . base64_encode(file_get_contents($specifiedMedia->getPath()))
                ]);
            }

            /* DOC, PPT, ODF */
            if (in_array($mediaFileExt, config('app.pdf_convertible_filetypes'))) {
                if (file_exists(storage_path('app/public/' . $newFilename . '.pdf'))) {
                    unlink(storage_path('app/public/' . $newFilename . '.pdf'));
                }

                $newFileExt = 'pdf';
                $converter = new OfficeToPdfHelper($specifiedMedia->getPath(), storage_path('app/public'));
                $converter->convertTo($newFilename . '.' . $newFileExt);

                $nf = storage_path('app/public/' . $newFilename . '.' . $newFileExt);

                return view('pages.resource-preview')->with([
                    'resource' => $resource,
                    'media' => $specifiedMedia,
                    'message' => 'Resource is previewable',
                    'fileType' => $this->getFileTypeGroup($mediaFileExt),
                    'fileMimeType' => mime_content_type($nf),
                    'resourceUrl' => 'data:' . mime_content_type($nf) . ';base64,' . base64_encode(file_get_contents($nf))
                ]);
            }

            /* PDF */
            if (in_array($mediaFileExt, ['pdf'])) {
                return view('pages.resource-preview')->with([
                    'resource' => $resource,
                    'media' => $specifiedMedia,
                    'message' => 'Resource is previewable',
                    'fileType' => $this->getFileTypeGroup($mediaFileExt),
                    'fileMimeType' => mime_content_type($specifiedMedia->getPath()),
                    'resourceUrl' => 'data:' . $specifiedMedia->mime_type . ';base64,' . base64_encode(file_get_contents($specifiedMedia->getPath()))
                ]);
            }

            /* SPREADSHEET */
            if (in_array($mediaFileExt, config('app.spreadsheet_convertible_filetypes'))) {
                $r = (new ResourceImport)->toCollection($specifiedMedia->getPath(), null);

                return view('pages.resource-preview')->with([
                    'resource' => $resource,
                    'media' => $specifiedMedia,
                    'message' => 'Resource is previewable',
                    'fileType' => $this->getFileTypeGroup($mediaFileExt),
                    'fileMimeType' => null,
                    'resourceUrl' => $r
                ]);
            }

            /* PLAIN TEXTS */
            if (in_array($mediaFileExt, config('app.text_filetypes'))) {

                $resourcePath = $specifiedMedia->getPath();

                $txt = mb_convert_encoding(file_get_contents($resourcePath), 'HTML-ENTITIES', "UTF-8");

                $txt = str_ireplace('`', '\`', $txt); // escape (`) to avoid conflict with javascript template literals

                return view('pages.resource-preview')->with([
                    'resource' => $resource,
                    'media' => $specifiedMedia,
                    'fileType' => $this->getFileTypeGroup($mediaFileExt),
                    'fileExtension' => $mediaFileExt,
                    'resourceText' => $txt
                ]);
            }
        } catch (\Throwable $th) {
            return view('pages.resource-preview')
                ->with([
                    'resource' => $resource,
                    'media' => $specifiedMedia
                ])
                ->withErrors([
                    'message' => $th->getMessage()
                ]);
        }
    }

    private function getFileTypeGroup($fileExtension)
    {
        if (in_array($fileExtension, config('app.pdf_convertible_filetypes'))) {
            return 'pdf_convertible_filetypes';
        } else if (in_array($fileExtension, config('app.spreadsheet_convertible_filetypes'))) {
            return 'spreadsheet_filetypes';
        } else if (in_array($fileExtension, config('app.text_filetypes'))) {
            return 'text_filetypes';
        } else if (in_array($fileExtension, config('app.img_filetypes'))) {
            return 'img_filetypes';
        } else if (in_array($fileExtension, config('app.video_filetypes'))) {
            return 'video_filetypes';
        } else if (in_array($fileExtension, config('app.audio_filetypes'))) {
            return 'audio_filetypes';
        } else if (in_array($fileExtension, ['pdf'])) {
            return 'pdf_filetypes';
        }
        // else if (in_array($fileExtension, ['ppt', 'pptx'])) {
        //     return 'audio_filetypes';
        // }

        return false;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        $this->authorize('update', $resource);

        return view('pages.resource-edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource)
    {
        $this->authorize('update', $resource);

        $resource->title = $request->title;
        $resource->description = $request->description;

        if ($resource->isDirty()) {
            $resource->save();

            return redirect()->back()->with([
                'updatedSubject' => $resource->id,
                'status' => 'success',
                'message' => 'Resource was successfully updated!'
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function toggleCurrentVersion(Request $request, Resource $resource, Media $media)
    {
        $this->authorize('update', $resource);

        $medias = $resource->media;
        $unselectedMedias = $medias->whereNotIn('id', $media->id)->sortBy('order_column')->pluck('id');
        $unselectedMedias->push($media->id);

        Media::setNewOrder($unselectedMedias->toArray());

        activity()
            ->causedBy(auth()->user())
            ->useLog('resource-versioned')
            ->performedOn($resource)
            ->withProperties($resource->getChanges())
            ->log(auth()->user()->nameTag . " created a new version of {$resource->title} (id: {$resource->id})");

        return redirect()->back();
    }
    public function cancelSubmission(Request $request, Resource $resource)
    {
        $this->authorize('update', $resource);

        if ($resource->hasMultipleMedia) {
            // remove current media
            Media::find($resource->currentMediaVersion->id)->delete();
        } else {
            // remove model hence removing media also
            $resource->delete();
        }
        $resource->refresh();

        $resource->update([
            'archived_at' => null,
            'approved_at' => $resource->currentMediaVersion->created_at
        ]);

        return redirect()->route('course.show', $resource->course)->with([
            'status' => 'success',
            'message' => 'Submission was successfully cancelled'
        ]);
    }
    public function toggleApproveState(Request $request, Resource $resource)
    {
        $this->authorize('update', $resource);

        if (empty($resource->approved_at)) {
            $resource->update([
                'approved_at' => now()
            ]);
        } else {
            $resource->update([
                'approved_at' => null
            ]);
        }


        return redirect()->back();
    }
    public function toggleArchiveState(Request $request, Resource $resource)
    {
        $this->authorize('update', $resource);

        $userName = auth()->user()->name;

        if (empty($resource->archived_at)) {
            $resource->update([
                'archived_at' => now()
            ]);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($resource)
                ->useLog('resource-archived')
                ->withProperties($resource->getChanges())
                ->log("{$userName} archived a resource (id: {$resource->id})");

            $message = 'Resource was successfully added in archive';
        } else {
            $resource->update([
                'archived_at' => null
            ]);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($resource)
                ->useLog('resource-unarchived')
                ->withProperties($resource->getChanges())
                ->log("{$userName} removed a resource from archive (id: {$resource->id})");

            $message = 'Resource was successfully removed from archive';
        }

        return redirect()->back()->with([
            'updatedSubject' => $resource->id,
            'status' => 'success',
            'message' => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = Resource::withTrashed()->findOrFail($id);

        $userName = auth()->user()->name;

        if ($resource->trashed()) {
            $this->authorize('delete', $resource);

            $resource->restore();

            activity()
                ->causedBy(auth()->user())
                ->performedOn($resource)
                ->useLog('resource-restored')
                ->withProperties($resource->getChanges())
                ->log("{$userName} restored a resource (id: {$resource->id})");

            $message = 'Resource was successfully restored';
        } else {
            $this->authorize('restore', $resource);

            $resource->delete();

            activity()
                ->causedBy(auth()->user())
                ->performedOn($resource)
                ->useLog('resource-deleted')
                ->withProperties($resource->getChanges())
                ->log("{$userName} deleted a resource (id: {$resource->id})");

            $message = 'Resource was successfully deleted';
        }

        return redirect()->back()->with([
            'updatedSubject' => $resource->id,
            'status' => 'success',
            'message' => $message
        ]);
    }

    public function downloadAsPdf(Media $media)
    {
        if (in_array(pathinfo($media->getPath(), PATHINFO_EXTENSION), config('app.pdf_convertible_filetypes'))) {
            $converter = new OfficeToPdfHelper($media->getPath(), storage_path('app/public'));
            $converter->convertTo($media->name . '.pdf'); //generates pdf file in same directory as test-file.docx

            // Source file and watermark config
            $file = $media->name . '.pdf';
            $text_image = storage_path('app/public/images/word-watermark.png');

            // Set source PDF file
            $pdf = new Fpdi;
            if (file_exists(storage_path('app/public/' . $file))) {
                $pagecount = $pdf->setSourceFile(storage_path('app/public/' . $file));
            } else {
                die('Source PDF not found!');
            }

            // Add watermark image to PDF pages
            for ($i = 1; $i <= $pagecount; $i++) {
                $tpl = $pdf->importPage($i);
                $size = $pdf->getTemplateSize($tpl);
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->addPage($size['width'] > $size['height'] ? 'P' : 'L');
                // $pdf->setPrintHeader(false);
                $pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height'], TRUE);

                //Put the watermark
                $pdf->Image($text_image, 5, 0, 35, 35, 'png');
            }

            // Output PDF with watermark
            unlink(storage_path('app/public/' . $file));
            $pdf->Output($file, 'D');

            $resource = $media->resource;

            if ($resource->update([
                $resource->downloads += 1
            ])) {
                return response()->download(
                    $media->getPath(),
                    $media->file_name
                );
            }
        }
    }

    public function downloadAsHtml(Media $media)
    {
        $filename = "{$media->name}-converted.html";

        if (in_array(pathinfo($media->getPath(), PATHINFO_EXTENSION), ['doc', 'docx'])) {
            $phpWord = IOFactory::load($media->getPath());
            $objWriter = IOFactory::createWriter($phpWord, 'HTML');

            $resource = $media->resource;

            if ($resource->update([
                $resource->downloads += 1
            ])) {
                return response()->streamDownload(function () use ($objWriter) {
                    echo $objWriter->save("php://output");
                }, $filename, [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessing‌​ml.document'
                ]);
            }
        } else if (pathinfo($media->getPath(), PATHINFO_EXTENSION) == 'pdf') {
            $pdftohtml = new PdfToHtmlHelper($media->getPath());
            $pdftohtml->convert();

            $resource = $media->resource;

            if ($resource->update([
                $resource->downloads += 1
            ])) {
                return response()->streamDownload(function () use ($pdftohtml) {
                    echo $pdftohtml->output();
                }, $filename, [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessing‌​ml.document'
                ]);
            }
        } else {
            return redirect()->back()->withErrors([
                'message' => 'Error! HTML download is only available for doc,docx,pdf'
            ]);
        }
    }

    public function downloadOriginal(Media $media)
    {
        $resource = $media->resource;

        try {
            if ($resource->update([
                $resource->downloads += 1
            ])) {
                return response()->download(
                    $media->getPath(),
                    $media->file_name
                );
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function downloadAllByCourse(Request $request, Course $course)
    {
        $zipFileName = $course->code . '-resources-' . time() . '.zip';
        $resources = Resource::where('course_id', $course->id)->get();

        Resource::where('course_id', $course->id)->increment('downloads');

        $resourcesWithinCourse = $resources->map(function ($resource) {
            return $resource->getMedia()[0];
        })->reject(function ($resource) {
            return empty($resource);
        });

        return MediaStream::create($zipFileName)
            ->addMedia($resourcesWithinCourse);
    }

    public function downloadAllByLesson(Request $request, Lesson $lesson)
    {
        $zipFileName = Str::kebab($lesson->title) . '-resources-' . time() . '.zip';
        $resources = $lesson->resources;

        $resourcesWithinLesson = $resources->map(function ($resource) use ($request) {
            return $resource->getFirstMedia();
        })->reject(function ($resource) {
            return empty($resource);
        });

        return MediaStream::create($zipFileName)
            ->addMedia($resourcesWithinLesson);
    }

    public function addViewCountThenRedirectToShow(Resource $resource)
    {
        $resource->increment('views');

        return redirect()->route('resource.show', $resource);
    }

    public function addViewCountThenRedirectToPreview(Resource $resource)
    {
        $resource->increment('views');

        return redirect()->route('resource.preview', $resource);
    }

    public function download(Request $request, Media $media)
    {
        $resource = $media->resource;

        try {
            if ($resource->update([
                $resource->downloads += 1
            ])) {
                return response()->download(
                    $media->getPath(),
                    $media->file_name
                );
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function bulkDownload(Request $request)
    {
        if (!isset($request->resource_no)) {
            return redirect()->route('resources.index');
            // add error alert
        }

        $resources = Resource::withTrashed()->whereIn('id', $request->resource_no)
            ->whereHas('media', function ($query) {
                $query->whereNotNull('file_name');
            })->get();
        $zipFileName = auth()->user()->program->title . '-files-' . time() . '.zip';

        $resourcesWithinCourse = $resources->map(function ($resource) {
            return $resource->getMedia()[0];
        })->reject(function ($resource) {
            return empty($resource);
        });

        return MediaStream::create($zipFileName)
            ->addMedia($resourcesWithinCourse);
    }
}
