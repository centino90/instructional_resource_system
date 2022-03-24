<?php

namespace App\Http\Controllers;

use App\Events\ResourceCreated;
use App\Http\Requests\StoreNewResourceVersionRequest;
use App\Http\Requests\StoreResourceByUrlRequest;
use App\Http\Requests\StoreResourceRequest;
use App\Imports\ResourceImport;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Resource;
use App\Models\TemporaryUpload;
use App\Models\User;
use App\Policies\ResourcePolicy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use NcJoes\OfficeConverter\OfficeConverter;
use Spatie\Activitylog\Models\Activity;
use Spatie\MediaLibrary\Support\MediaStream;
use ZipStream\Option\Archive as ArchiveOptions;

use PhpOffice\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Reference the Dompdf namespace
use Dompdf\Dompdf;
// Reference the Options namespace
use Dompdf\Options;

use Elibyy\TCPDF\Facades\TCPDF;
use Error;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\File;
use Illuminate\Http\Response;
use LDAP\Result;
use Maatwebsite\Excel\Facades\Excel;
use setasign\Fpdi\Tcpdf\Fpdi;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

// use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ResourceController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Resource::class, 'resource');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Resource::with(['activities', 'media', 'users', 'auth', 'course'])
            // ->whereNotNull('approved_at')
            // ->whereRelation('course', 'program_id', '=', auth()->user()->program_id)
            ->orderByDesc('created_at')
            ->get();

        $activities = Activity::with('subject', 'causer', 'subject.media')->where('subject_type', 'App\Models\Resource')->orderByDesc('created_at')->limit(5)->get();

        return view('resources', compact(['resources', 'activities']));
    }

    public function viewVersions(Resource $resource)
    {
        return view('pages.resource-versions', compact('resource'));
    }

    public function create(Lesson $lesson)
    {
        return view('pages.course-resource-create')->with([
            'lesson' => $lesson
        ]);
    }

    public function createNewVersion(Resource $resource)
    {
        return view('pages.resource-show-create-version', compact('resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create2(Request $request)
    {
        if ($request->user()->cannot('create', Resource::class)) {
            abort(403);
        }

        // dd(auth()->user()->belongsToProgram(1));

        $courses = Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))->get();

        return view('create-resource')->with([
            'resourceLists' => $request->resourceLists ?? 1,
            'notifications' => auth()->user()->unreadNotifications,
            'courses' => $courses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResourceRequest $request)
    {

        // Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))->findOrFail($request->course_id);

        try {
            $batchId = Str::uuid();
            $index = 0;
            $resources = collect();
            $failes = collect();
            foreach ($request->file as $file) {
                $temporaryFile = TemporaryUpload::firstWhere('folder_name', $file);

                if ($temporaryFile) {
                    //exclude first item because its from the template
                    if ($index == 0) {
                        $index++;
                        continue;
                    }
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
                        'batch_id' => $batchId,
                        'description' => $request->description[$index],
                        'title' => $request->title[$index],
                        'approved_at' => now()
                    ]);
                    $r->users()->attach($r->user_id, ['batch_id' => $batchId]);

                    $tmpPath = storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name);

                    $newFilePath = $this->filenameFormatter('users/' . auth()->id() . '/resources/' . $temporaryFile->file_name);
                    $newFilename = pathinfo($newFilePath, PATHINFO_FILENAME) . '.' . pathinfo($newFilePath, PATHINFO_EXTENSION);

                    Storage::disk('public')->putFileAs('users/' . auth()->id() . '/resources', $tmpPath, $newFilename);
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
                    'message' => sizeof($resources) . ' resource(s) were successfully uploaded and ' . sizeof($failes) . ' failed.',
                    'resources' => $resources
                ]);
        } catch (\Throwable $th) {
            $statusCode = in_array($th->getCode(), array_keys(Response::$statusTexts)) ? $th->getCode() : 500;

            return redirect()
                ->route('resource.create', $request->lesson_id)
                ->withErrors([
                    'message' => $th->getMessage()
                ]);
        }
    }

    public function storeNewVersion(StoreNewResourceVersionRequest $request, Resource $resource)
    {
        $temporaryFile = TemporaryUpload::firstWhere('folder_name', $request->file);

        if (!$temporaryFile) {
            dd('no file');
        }

        // exclude unexecutable files
        if (empty(pathinfo($temporaryFile->file_name, PATHINFO_EXTENSION))) {
            $temporaryFile->delete();
            // $failes->push($temporaryFile->file_name);
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

        $resource = Resource::with('media', 'user', 'lesson')->findOrFail($resource->id);
        $resource->mimetype = $resource->getFirstMedia() ? $resource->getFirstMedia()->mime_type : null;

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', $resource->getMedia()->last()->file_name . ' was added as the new version successfully.');

        return redirect()->route('resource.createNewVersion', compact('resource'));
    }
    public function storeNewVersionByUrl(StoreResourceByUrlRequest $request)
    {
        $filePath = str_replace(url('storage') . '/', "", $request->fileUrl);
        $filename = pathinfo($this->filenameFormatter($filePath), PATHINFO_FILENAME) . '.' . pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);
        $model = Resource::create($request->validated() + [
            'user_id' => auth()->id(),
            'batch_id' => Str::random(5),
            'approved_at' => now()
        ]);

        Storage::disk('public')->put('users/' . auth()->id() . '/resources/' . $filename, storage_path('app/public/' . $filePath));
        $model->addMediaFromDisk($filePath, 'public')->preservingOriginal()->toMediaCollection();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', $model->title . ' was uploaded successfully.');

        return redirect()->route('resource.createNewVersion', $request->lesson_id);
    }
    public function storeByUrl(StoreResourceByUrlRequest $request)
    {
        abort_if(
            $request->user()->cannot('create', Resource::class),
            403
        );

        $filePath = str_replace(url('storage') . '/', "", $request->fileUrl);
        $filename = pathinfo($this->filenameFormatter($filePath), PATHINFO_FILENAME) . '.' . pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);
        $model = Resource::create($request->validated() + [
            'user_id' => auth()->id(),
            'batch_id' => Str::random(5),
            'approved_at' => now()
        ]);

        Storage::disk('public')->put('users/' . auth()->id() . '/resources/' . $filename, storage_path('app/public/' . $filePath));
        $model->addMediaFromDisk($filePath, 'public')->preservingOriginal()->toMediaCollection();

        $request->session()->flash('status', 'success');
        $request->session()->flash('message', $model->title . ' was uploaded successfully.');

        return redirect()->route('resource.create', $request->lesson_id);
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

    public function show(Resource $resource)
    {
        return view('pages.resource-show')
            ->with('resource', $resource);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show2(Resource $resource)
    {
        /* ON DETAILS */
        $resource->filename = $resource->getFirstMedia()->file_name;
        $resource->filetype = $resource->getFirstMedia()->mime_type;
        $resource->filesize = $resource->getFirstMedia()->human_readable_size;
        $resource->uploader = $resource->user->username;

        $this->authorize('view', $resource);

        return $resource;
    }

    public function preview(Request $request, Resource $resource)
    {
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
                    array_values(config('app.audio_filetypes'))
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

            if (in_array($mediaFileExt, config('app.pdf_convertible_filetypes'))) {
                if (file_exists(storage_path('app/public/' . $newFilename . '.pdf'))) {
                    unlink(storage_path('app/public/' . $newFilename . '.pdf'));
                }

                $newFileExt = 'pdf';
                $converter = new OfficeConverter($specifiedMedia->getPath(), storage_path('app/public'));
                $converter->convertTo($newFilename . '.' . $newFileExt);

                $nf = storage_path('app/public/' . $newFilename . '.' . $newFileExt);

                return view('pages.resource-preview')->with([
                    'resource' => $resource,
                    'media' => $specifiedMedia,
                    'message' => 'Resource is previewable',
                    'fileType' => $this->getFileTypeGroup(pathinfo($nf, PATHINFO_EXTENSION)),
                    'fileMimeType' => mime_content_type($nf),
                    'resourceUrl' => 'data:' . mime_content_type($nf) . ';base64,' . base64_encode(file_get_contents($nf))
                ]);
            }

            /* PDF */
            // if (in_array($mediaFileExt, ['pdf'])) {

            //     return view('pages.resource-preview')->with([
            //         'resource' => $resource,
            //         'message' => 'Resource is previewable',
            //         'fileType' => $this->getFileTypeGroup($mediaFileExt),
            //         'fileMimeType' => mime_content_type($specifiedMedia->getPath()),
            //         'resourceUrl' => 'data:' . $specifiedMedia->mime_type . ';base64,' . base64_encode(file_get_contents($specifiedMedia->getPath()))
            //     ]);
            // }

            /* DOC */
            // if (in_array($mediaFileExt, ['doc', 'docx', 'odt'])) {
            //     $temporaryFile = $specifiedMedia;
            //     $filePath = $temporaryFile->getPath();

            //     $phpWord = IOFactory::load($filePath);
            //     $section = $phpWord->addSection();

            //     $origname = pathinfo($temporaryFile->file_name, PATHINFO_FILENAME);
            //     $source = storage_path('app/public/') . $origname . '.html';

            //     // Saving the doc as html
            //     $objWriter = IOFactory::createWriter($phpWord, 'HTML');
            //     $html = $objWriter->getContent($source);


            //     return view('pages.resource-preview')->with([
            //         'resource' => $resource,
            //         'message' => 'Resource is previewable',
            //         'fileType' => $this->getFileTypeGroup($mediaFileExt),
            //         'fileMimeType' => mime_content_type($specifiedMedia->getPath()),
            //         // 'resourceUrl' => $html
            //         'resourceUrl' => 'data:' . 'text/html' . ';base64,' . base64_encode($html)
            //     ]);
            // }

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

            // /* PPT */
            // if (in_array($mediaFileExt, ['ppt', 'pptx', 'odp'])) {

            //     return view('pages.resource-preview')->with([
            //         'resource' => $resource,
            //         'message' => 'Resource is previewable',
            //         'fileType' => $this->getFileTypeGroup($mediaFileExt),
            //         'fileMimeType' => mime_content_type($specifiedMedia->getPath()),
            //         'resourceUrl' => 'data:' . $specifiedMedia->mime_type . ';base64,' . base64_encode(file_get_contents($specifiedMedia->getPath()))
            //     ]);
            // }

            /* PLAIN TEXTS */
            if (in_array($mediaFileExt, config('app.text_filetypes'))) {

                $resourcePath = $specifiedMedia->getPath();

                $txt = mb_convert_encoding(file_get_contents($resourcePath), 'HTML-ENTITIES', "UTF-8");

                $txt = str_ireplace('`', '\`', $txt); // escape (`) to avoid conflict with javascript template literals

                return view('pages.resource-preview')->with([
                    'resource' => $resource,
                    'media' => $specifiedMedia,
                    'fileType' => $this->getFileTypeGroup($mediaFileExt),
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

    public function preview2($id)
    {
        $resource = Resource::with('media', 'user')->findOrFail($id);

        $this->authorize('view', $resource);

        $mediaFileExt = strtolower(pathinfo($resource->getFirstMediaPath(), PATHINFO_EXTENSION));
        try {
            if (!$mediaFileExt) {
                throw new Error('Resource file not found.', 404);
            }

            if (
                !in_array($mediaFileExt, array_merge(
                    array_values(config('app.pdf_convertible_filetypes')),
                    array_values(config('app.img_filetypes')),
                    array_values(config('app.video_filetypes')),
                    array_values(config('app.audio_filetypes'))
                )) && $resource->getFirstMedia()->mime_type !== 'text/plain'
                || $resource->getFirstMedia()->mime_type == 'application/x-empty'
            ) {
                throw new Error('Resource filetype is not previewable.', 415);
            }

            /* IMAGE, VIDEO, AUDIO */
            if (
                in_array($mediaFileExt, config('app.img_filetypes'))
                || in_array($mediaFileExt, config('app.video_filetypes'))
                || in_array($mediaFileExt, config('app.audio_filetypes'))
            ) {
                return response()->json(
                    [
                        'message' => 'Resource is previewable',
                        'fileType' => $this->getFileTypeGroup($mediaFileExt),
                        'fileMimeType' => mime_content_type($resource->getFirstMediaPath()),
                        'resourceUrl' => 'data:' . $resource->getFirstMedia()->mime_type . ';base64,' . base64_encode(file_get_contents($resource->getFirstMediaPath()))
                    ]
                );
            }

            $newFilename = auth()->user()->username . '-preview-resource';
            $newFileExt = 'pdf';

            /* PDF CONVERTIBLES */
            if (in_array($mediaFileExt, config('app.pdf_convertible_filetypes'))) {
                if (file_exists(storage_path('app/public/' . $newFilename . '.pdf'))) {
                    unlink(storage_path('app/public/' . $newFilename . '.pdf'));
                }

                $newFileExt = 'pdf';
                $converter = new OfficeConverter($resource->getFirstMediaPath(), storage_path('app/public'));
                $converter->convertTo($newFilename . '.' . $newFileExt);

                return response()->download(
                    storage_path('app/public/' . $newFilename . '.' . $newFileExt),
                    $newFilename . $newFileExt
                );
            }

            /* PLAIN TEXTS */
            if ($resource->getFirstMedia()->mime_type === 'text/plain') {
                if (file_exists(storage_path('app/public/' . $newFilename . '.txt'))) {
                    unlink(storage_path('app/public/' . $newFilename . '.txt'));
                }

                $newFileExt = 'txt';
                $resourcePath = $resource->getFirstMediaPath();

                if (Storage::disk('public')->exists($newFilename . '.' . $newFileExt)) {
                    Storage::disk('public')->put($newFilename . '.' . $newFileExt, '');
                }

                $txt = nl2br(file_get_contents($resourcePath));

                return response()->json([
                    'status' => 'ok',
                    'fileType' => 'text_filetypes',
                    'resourceText' => $txt
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => $th->getMessage()
                ],
                in_array($th->getCode(), array_keys(Response::$statusTexts)) ? $th->getCode() : 500
            );
        }
    }

    private function getFileTypeGroup2($fileExtension)
    {
        if (in_array($fileExtension, config('app.pdf_convertible_filetypes'))) {
            return 'pdf_convertible_filetypes';
        } else if (in_array($fileExtension, config('app.img_filetypes'))) {
            return 'img_filetypes';
        } else if (in_array($fileExtension, config('app.video_filetypes'))) {
            return 'video_filetypes';
        } else if (in_array($fileExtension, config('app.audio_filetypes'))) {
            return 'audio_filetypes';
        }

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
        //
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
        //
    }

    public function toggleCurrentVersion(Request $request, Resource $resource, Media $media)
    {
        $medias = $resource->media;
        $unselectedMedias = $medias->whereNotIn('id', $media->id)->sortBy('order_column')->pluck('id');
        $unselectedMedias->push($media->id);

        Media::setNewOrder($unselectedMedias->toArray());

        // dd($resource->media);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        try {
            $resource->with('media', 'user');

            $resource->delete();
            $fileName = $resource->getMedia()[0]->file_name ?? 'unknown file';

            return response()->json([
                'status' => 'ok',
                'message' => $fileName . 'was deleted sucessfully!',
                'resource' => $resource
            ]);
        } catch (Throwable $th) {
            $statusCode = in_array($th->getCode(), array_keys(Response::$statusTexts)) ? $th->getCode() : 500;
            return response()->json(
                [
                    'status' => 'fail',
                    'message' => $th->getMessage(),
                    'code' => $statusCode
                ],
                $statusCode
            );
        }
    }

    /**
     * Download the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, Resource $resource)
    {
        // if (in_array(pathinfo($mediaFileExt, PATHINFO_EXTENSION), config('app.pdf_convertible_filetypes'))) {
        //     $converter = new OfficeConverter($resource->getFirstMediaPath(), storage_path('app/public'));
        //     $converter->convertTo($resource->getFirstMedia()->name . '.pdf'); //generates pdf file in same directory as test-file.docx

        //     // Source file and watermark config
        //     $file = $resource->getFirstMedia()->name . '.pdf';
        //     $text_image = storage_path('app/public/images/word-watermark.png');

        //     // Set source PDF file
        //     $pdf = new Fpdi;
        //     if (file_exists(storage_path('app/public/' . $file))) {
        //         $pagecount = $pdf->setSourceFile(storage_path('app/public/' . $file));
        //     } else {
        //         die('Source PDF not found!');
        //     }

        //     // Add watermark image to PDF pages
        //     for ($i = 1; $i <= $pagecount; $i++) {
        //         $tpl = $pdf->importPage($i);
        //         $size = $pdf->getTemplateSize($tpl);
        //         $pdf->SetPrintHeader(false);
        //         $pdf->SetPrintFooter(false);
        //         $pdf->addPage($size['width'] > $size['height'] ? 'P' : 'L');
        //         // $pdf->setPrintHeader(false);
        //         $pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height'], TRUE);

        //         //Put the watermark
        //         $pdf->Image($text_image, 5, 0, 35, 35, 'png');
        //     }

        //     // Output PDF with watermark
        //     unlink(storage_path('app/public/' . $file));
        //     $pdf->Output($file, 'D');
        // }

        try {
            if (!empty($request->mediaId)) {
                if (!$mediaFile = $resource->getMedia()->firstWhere('id', $request->mediaId)) {
                    throw new FileNotFoundException();
                } else {
                }
            } else {
                $mediaFile = $resource->media->sortByDesc('order_column')->first();
            }

            return response()->download(
                $mediaFile->getPath(),
                $mediaFile->getCustomName()
            );
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function downloadAsPdf(Request $request, Resource $resource)
    {
        if (in_array(pathinfo($resource->getFirstMediaPath(), PATHINFO_EXTENSION), config('app.pdf_convertible_filetypes'))) {
            $converter = new OfficeConverter($resource->getFirstMediaPath(), storage_path('app/public'));
            $converter->convertTo($resource->getFirstMedia()->name . '.pdf'); //generates pdf file in same directory as test-file.docx

            // Source file and watermark config
            $file = $resource->getFirstMedia()->name . '.pdf';
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

            $resource->downloads = $resource->downloads + 1;
            $resource->save();

            return response()->download(
                $resource->getFirstMediaPath(),
                $resource->getFirstMedia()->file_name
            );
        }
    }

    public function downloadOriginal($mediaItem, Request $request)
    {
        $resource = Resource::withTrashed()->find($mediaItem);

        $resource->downloads = $resource->downloads + 1;
        $resource->save();

        return response()->download(
            $resource->getFirstMediaPath(),
            $resource->getFirstMedia()->file_name
        );
    }

    public function downloadAllByCourse(Request $request)
    {
        $zipFileName = Course::findOrFail($request->course_id)->title . '-files-' . time() . '.zip';
        $resources = Resource::where('course_id', $request->course_id)->get();

        $resourcesWithinCourse = $resources->map(function ($resource) use ($request) {
            return $resource->getMedia()[0];
        })->reject(function ($resource) {
            return empty($resource);
        });

        return MediaStream::create($zipFileName)
            ->addMedia($resourcesWithinCourse);
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

    public function getResourcesJson(Request $request)
    {
        $resources = Resource::where('course_id', $request->course_id)->get();
        $resourceMedia = $resources->map(function ($resource) {
            return $resource->getMedia()[0];
        })->reject(function ($resource) {
            return empty($resource);
        });

        return response()->json(['resources' => $resourceMedia]);
    }
}
