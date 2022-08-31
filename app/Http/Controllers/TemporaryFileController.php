<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Storage;

class TemporaryFileController extends Controller
{
    public function process(Request $request){

        $file = $request->file('attachment');
        $path = uniqid() . '-' . now()->timestamp;
        $filename = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();

        $file->storeAs('temp/'.$path, $filename);

        TemporaryFile::create([
            'path' => $path,
            'filename' => $filename,
            'extension' => $ext
        ]);

        return $path;

    }

    public function revert(){
        $path = request()->getContent();

        TemporaryFile::where('path', $path)->delete();
        Storage::deleteDirectory('temp/'.$path);

        return '';
    }
}
