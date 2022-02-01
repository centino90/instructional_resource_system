<?php

namespace App\Http\Controllers;

use App\Events\ResourceCreated;
use App\Http\Requests\StoreResourceRequest;
use App\Models\Course;
use App\Models\Resource;
use App\Models\TemporaryUpload;
use App\Models\User;
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
use setasign\Fpdi\Tcpdf\Fpdi;
use Throwable;

// use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ResourceController extends Controller
{
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        abort_if(
            $request->user()->cannot('create', Resource::class),
            403
        );

        Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))->findOrFail($request->course_id);
        try {
            $batchId = Str::uuid();
            $index = 0;
            $resources = collect();
            foreach ($request->file as $file) {
                $temporaryFile = TemporaryUpload::firstWhere('folder_name', $file);

                if ($temporaryFile) {
                    $r = Resource::create([
                        'course_id' => $request->course_id,
                        'user_id' => auth()->id(),
                        'batch_id' => $batchId,
                        'description' => $request->description[$index],
                        'title' => $request->title[$index],
                        'approved_at' => now()
                    ]);

                    $r->users()->attach($r->user_id, ['batch_id' => $batchId]);

                    $r->addMedia(storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name))
                        ->toMediaCollection();
                    rmdir(storage_path('app/public/resource/tmp/' . $file));

                    event(new ResourceCreated($r));

                    $temporaryFile->delete();

                    $r = Resource::with('media', 'user')->findOrFail($r->id);
                    $r->mimetype = $r->getFirstMedia() ? $r->getFirstMedia()->mime_type : null;

                    $resources->push($r);

                    $index++;
                }
            }

            return response()->json([
                'status' => 'ok',
                'message' => sizeof($request->file) . ' resource(s) were successfully uploaded.',
                'resources' => $resources
            ]);

            // if ($request->check_stay) {
            //     return redirect()
            //         ->route('resources.create')
            //         ->with('success', 'Resource was created successfully');
            // }

            // return redirect()
            //     ->route('resources.index')
            //     ->with('success', 'Resource was created successfully');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'fail',
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        /* ON DETAILS */
        $resource->filename = $resource->getFirstMedia()->file_name;
        $resource->filetype = $resource->getFirstMedia()->mime_type;
        $resource->filesize = $resource->getFirstMedia()->human_readable_size;
        $resource->uploader = $resource->user->username;

        Gate::authorize('view', $resource);

        return $resource;
    }

    public function preview($id)
    {
        $resource = Resource::findOrFail($id);
        Gate::authorize('view', $resource);

        $newFilename = auth()->user()->username . '-preview-resource';
        $newFileExt = 'pdf';
        if (file_exists(storage_path('app/public/' . $newFilename . '.pdf'))) {
            unlink(storage_path('app/public/' . $newFilename . '.pdf'));
        }
        if (file_exists(storage_path('app/public/' . $newFilename . '.txt'))) {
            unlink(storage_path('app/public/' . $newFilename . '.txt'));
        }

        if ($resource->getFirstMedia()) {
            if(in_array($resource->getFirstMedia()->mime_type, config('app.pdf_convertible_mimetypes'))) {
                $newFileExt = 'pdf';
                $converter = new OfficeConverter($resource->getFirstMediaPath(), storage_path('app/public'));
                $converter->convertTo($newFilename . '.' . $newFileExt);
            } else {
                $newFileExt = 'txt';
                $resourcePath = $resource->getFirstMediaPath();

                $a = getimagesize($resourcePath);

                if($a) {
                    $image_type = $a[2];
                    if(in_array($image_type , config('app.php_imgtype_constants')))
                    {
                        // return an image preview
                        dd('image');
                    }
                }

                if (Storage::disk('public')->exists($newFilename . '.' . $newFileExt)) {
                    Storage::disk('public')->put($newFilename . '.' . $newFileExt, '');
                }
                $outputTxtPath = storage_path('app/public/' . $newFilename . '.' . $newFileExt);
                // $outputTxt = fopen($outputTxtPath, "w") or die("Unable to open file!");
                $txt = nl2br(file_get_contents($resourcePath));
                // fwrite($outputTxt, $txt);

                return response()->json([
                    'status' => 'ok',
                    'resourceText' => $txt
                ]);
                // $newFileExt = 'pdf';
                // $converter = new OfficeConverter($outputTxtPath, storage_path('app/public'));
                // $converter->convertTo($newFilename . '.' . $newFileExt);
            }

            return response()->download(
                storage_path('app/public/' . $newFilename . '.' . $newFileExt),
                $newFilename . $newFileExt
            );
        } else {
            return response()->json(
                [
                    'status' => 'fail',
                    'message' => 'File does not exist.'
                ]
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
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
            Gate::authorize('delete', $resource);

            $resource->delete();
            $fileName = $resource->getMedia()[0]->file_name ?? 'unknown file';

            return response()->json([
                'status' => 'ok',
                'message' => $fileName . 'was deleted sucessfully!',
                'resource' => $resource
            ]);
        } catch (Throwable $th) {

            return response()->json([
                'status' => 'fail',
                'message' => $th->getMessage()
            ]);
        }


        // $fileName = $resource->getMedia()[0]->file_name ?? 'unknown file';
        // return redirect()->back()
        //     ->with([
        //         'status' => 'success-destroy-resource',
        //         'message' => $fileName . ' was deleted sucessfully!',
        //         'resource_id' => $resource->id
        //     ]);
    }

    /**
     * Download the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($mediaItem, Request $request)
    {
        // if ($mediaItem == 'all') {
        //     $zipFileName = Course::findOrFail($request->course_id)->title . '-files-' . time() . '.zip';
        //     $resources = Resource::withTrashed()->get();

        //     $resourcesWithinCourse = $resources->map(function ($resource) use ($request) {
        //         return $resource->course_id == $request->course_id ? $resource->getMedia()[0] : null;
        //     })->reject(function ($resource) {
        //         return empty($resource);
        //     });

        //     return MediaStream::create($zipFileName)
        //         ->addMedia($resourcesWithinCourse);
        // }
        // $resource = Resource::withTrashed()->find($mediaItem);
        // $phpWord = IOFactory::load($resource->getFirstMediaPath());
        // $section = $phpWord->addSection();
        // $header = $section->addHeader();
        // $header->addWatermark(storage_path('app/public/word-watermark.jpg'), array('marginTop' => 200, 'marginLeft' => 55));
        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        // $t = time();
        // $objWriter->save('helloWorld-' . $t . '-.docx');

        // $converter = new OfficeConverter($resource->getFirstMediaPath(), storage_path('app/public'));
        // $converter->convertTo('output-file.pdf'); //generates pdf file in same directory as test-file.docx
        // $converter->convertTo('output-file.html'); //generates html file in same directory as test-file.docx

        //to specify output directory, specify it as the second argument to the constructor
        // $converter = new OfficeConverter('test-file.docx', 'path-to-outdir');

        $resource = Resource::withTrashed()->find($mediaItem);

        if(in_array($resource->getFirstMedia()->mime_type, config('app.pdf_convertible_mimetypes'))) {
            $converter = new OfficeConverter($resource->getFirstMediaPath(), storage_path('app/public'));
            $converter->convertTo($resource->getFirstMedia()->name . '.pdf'); //generates pdf file in same directory as test-file.docx

            // Source file and watermark config
            $file = $resource->getFirstMedia()->name . '.pdf';
            $text_image = storage_path('app/public/word-watermark.png');

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
        }

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
