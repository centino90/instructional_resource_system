<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Error;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use NcJoes\OfficeConverter\OfficeConverter;

class ResourceController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        return view('pages.instructor.resource-show')
        ->with('resource', $resource);
    }

    public function preview($id)
    {
        $resource = Resource::with('media', 'user')->findOrFail($id);

        // $this->authorize('view', $resource);

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

                return view('pages.instructor.resource-preview')->with([
                    'resource' => $resource,
                    'message' => 'Resource is previewable',
                    'fileType' => $this->getFileTypeGroup($mediaFileExt),
                    'fileMimeType' => mime_content_type($resource->getFirstMediaPath()),
                    'resourceUrl' => 'data:' . $resource->getFirstMedia()->mime_type . ';base64,' . base64_encode(file_get_contents($resource->getFirstMediaPath()))
                ]);
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

                return view('pages.instructor.resource-preview')->with([
                    'resource' => $resource,
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

    private function getFileTypeGroup($fileExtension)
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
