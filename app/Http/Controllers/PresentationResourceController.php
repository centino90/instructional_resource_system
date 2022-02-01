<?php

namespace App\Http\Controllers;

use App\Events\ResourceCreated;
use App\Http\Requests\StoreResourceRequest;
use App\Models\Course;
use App\Models\Resource;
use App\Models\TemporaryUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use NcJoes\OfficeConverter\OfficeConverter;
// use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
// use PhpOffice\PhpPresentation\Style\Color;
// use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\Common\Drawing as CommonDrawing;
use PhpOffice\Common\XMLReader;
use PhpOffice\PhpPresentation\DocumentProperties;
use PhpOffice\PhpPresentation\Exception\FileNotFoundException;
use PhpOffice\PhpPresentation\Exception\InvalidFileFormatException;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\PresentationProperties;
use PhpOffice\PhpPresentation\Shape\Drawing\Base64;
use PhpOffice\PhpPresentation\Shape\Drawing\Gd;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Shape\RichText\Paragraph;
use PhpOffice\PhpPresentation\Slide\Background\Image;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Bullet;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Fill;
use PhpOffice\PhpPresentation\Style\Font;
use PhpOffice\PhpPresentation\Style\Shadow;
use setasign\Fpdi\Tcpdf\Fpdi;
use ZipArchive;

class PresentationResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            foreach ($request->file as $file) {
                $temporaryFile = TemporaryUpload::firstWhere('folder_name', $file);

                if ($temporaryFile) {
                    $r = Resource::create([
                        'course_id' => $request->course_id,
                        'user_id' => auth()->id(),
                        'batch_id' => $batchId,
                        'description' => $request->description[$index],
                        'title' => $request->title[$index]
                    ]);

                    $r->users()->attach($r->user_id, ['batch_id' => $batchId]);

                    $r->addMedia(storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name))
                        ->toMediaCollection();
                    rmdir(storage_path('app/public/resource/tmp/' . $file));

                    event(new ResourceCreated($r));

                    $temporaryFile->delete();

                    $index++;
                }
            }


            return response()->json([
                'status' => 'ok',
                'message' => sizeof($request->file) . ' resources were successfully uploaded.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'fail',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function upload(Request $request)
    {
        Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))->findOrFail($request->course_id);
        // dd($request);
        $batchId = Str::uuid();
        $index = 0;
        foreach ($request->file as $file) {
            $temporaryFile = TemporaryUpload::firstWhere('folder_name', $file);

            if ($temporaryFile) {
                $tempFilePath = storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name);
                $copiedTempFilePath = storage_path('app/public/resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));
                if(file_exists($copiedTempFilePath)) {
                    Storage::disk('public')->delete('resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));
                }
                Storage::disk('public')->copy('resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name, 'resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));

                $reader = IOFactory::createReader('PowerPoint2007');
                $presentation = $reader->load($copiedTempFilePath);

                $lastSlide = $presentation->getSlide(count($presentation->getAllSlides()) - 1);
                $shapes = $lastSlide->getShapeCollection();
                $texts = collect();
                foreach ($shapes as $key => $value) {
                    $texts->push(trim($value->getParagraph()->getPlainText()));
                }

                $lowercased = $texts->map(function ($item, $key) {
                    return strtolower($item);
                });

                foreach (get_resources() as $key => $value) {
                    if($key == '525') {
                        fclose($value);
                    }
                }

                if ($lowercased->contains('references') || $lowercased->contains('reference')) {
                    $r = Resource::create([
                        'course_id' => $request->course_id,
                        'user_id' => auth()->id(),
                        'batch_id' => $batchId,
                        'description' => $request->description[$index],
                        'title' => $request->title[$index],
                        'is_presentation' => true,
                        'approved_at' => now()
                    ]);

                    $r->users()->attach($r->user_id, ['batch_id' => $batchId]);

                    $r->addMedia($tempFilePath)
                        ->toMediaCollection();
                    rmdir(storage_path('app/public/resource/tmp/' . $file));

                    event(new ResourceCreated($r));

                    $temporaryFile->delete();

                    return response()->json([
                        'status' => 'ok',
                        'message' => 'presentation was successfully uploaded.',
                        'texts' => $texts
                    ]);
                }

                return response()->json([
                    'status' => 'fail',
                    'message' => 'presentation was not successfully uploaded.',
                    'texts' => $texts
                ]);
            }

            $index++;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function preview($id)
    {
        $resource = Resource::where('is_presentation', true)->findOrFail($id);
        Gate::authorize('view', $resource);

        $newFilename = auth()->user()->username . '-preview-resource.pdf';
        if(file_exists(storage_path('app/public/' . $newFilename))) {
            unlink(storage_path('app/public/' . $newFilename));
        }

        $converter = new OfficeConverter($resource->getFirstMediaPath(), storage_path('app/public'));
        $converter->convertTo($newFilename);

        return response()->download(
            storage_path('app/public/' . $newFilename),
            $newFilename
        );
        // $resource = Resource::findOrFail($id);
        // Gate::authorize('view', $resource);

        // $converter = new OfficeConverter($resource->getFirstMediaPath(), storage_path('app/public'));
        // $converter->convertTo($resource->getFirstMedia()->name . '.pdf');

        // // Source file and watermark config
        // $file = $resource->getFirstMedia()->name . '.pdf';
        // $text_image = storage_path('app/public/word-watermark.png');

        // // Set source PDF file
        // $pdf = new Fpdi;
        // if (file_exists(storage_path('app/public/' . $file))) {
        //     $pagecount = $pdf->setSourceFile(storage_path('app/public/' . $file));
        // } else {
        //     die('Source PDF not found!');
        // }

        // // Add watermark image to PDF pages
        // for ($i = 1; $i <= $pagecount; $i++) {
        //     $tpl = $pdf->importPage($i);
        //     $size = $pdf->getTemplateSize($tpl);
        //     $pdf->SetPrintHeader(false);
        //     $pdf->SetPrintFooter(false);
        //     $pdf->addPage($size['width'] > $size['height'] ? 'P' : 'L');
        //     // $pdf->setPrintHeader(false);
        //     $pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height'], TRUE);

        //     //Put the watermark
        //     $pdf->Image($text_image, 5, 0, 35, 35, 'png');
        // }

        // // Output PDF with watermark
        // unlink(storage_path('app/public/' . $file));

        // $pdf->Output();
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
    public function destroy($id)
    {
        //
    }
}
