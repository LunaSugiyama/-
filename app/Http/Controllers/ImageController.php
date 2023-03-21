<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    //
    public function upload(Request $request)
    {
        //name of the directory
        $dir='sample';

        //name of the file
        $file_name=$request->file('image')->store('public/'.$dir);
        return "image saved";
    }
}
