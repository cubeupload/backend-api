<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    // The UploadController has the UploadCheck middleware sat in front of it.
    // If we get this far, the uploaded file has been validated. All we have to do is save it to the image repo,
    // create a DB entry and return the info to the uploader.
    public function postUploadGuest(Request $request)
    {
        $file = $request->file('img');
        return $file;
    }

    public function postUploadAuthed(Request $request)
    {

    }

}
