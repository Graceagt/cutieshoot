<?php

namespace App\Http\Controllers;

use App\Models\Photo;

class HomeController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->take(5)->get();
        return view('landingpage', compact('photos'));
    }
}

