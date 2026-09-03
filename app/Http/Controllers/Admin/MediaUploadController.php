<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $path = $request->file('image')
            ->store('uploads','public');

        return back()->with([
            'success'=>'File berhasil diupload',
            'path'=>$path
        ]);
    }
}