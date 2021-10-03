<?php

namespace App\Http\Controllers;

use App\Models\TemporaryUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadTemporaryFileController extends Controller
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
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $filename = substr(
                $file->getClientOriginalName(),
                0,
                strrpos($file->getClientOriginalName(), ".")
            );

            // remove any character that is enclosed within a parenthesis e.g. (1), (hello)
            // and remove spaces
            $spacesRemoved = preg_replace(array('/\((.*?)\)/', '/\s/'), '', $filename);
            
            $newFilename = $spacesRemoved . '.' . $file->getClientOriginalExtension();
            $folder = uniqid() . '-' . time();
            $file->storeAs('resource/tmp/' . $folder, $newFilename);

            TemporaryUpload::create([
                'folder_name' => $folder,
                'file_name' => $newFilename
            ]);

            return $folder;
        }

        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
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
        $temp = TemporaryUpload::where('folder_name', $id);
        $file =  $temp->first();

        unlink(storage_path('app/public/resource/tmp/' . $file->folder_name . '/' . $file->file_name));
        rmdir(storage_path('app/public/resource/tmp/' . $file->folder_name));

        $temp->delete();

        return $id;
    }
}
