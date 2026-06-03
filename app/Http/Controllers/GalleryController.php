<?php

namespace App\Http\Controllers;

use App\Models\Photo;

class GalleryController extends Controller
{
    public function gallery()
    {
        $photos = Photo::latest()->get();

        return view('gallery', compact('photos'));
    }
}