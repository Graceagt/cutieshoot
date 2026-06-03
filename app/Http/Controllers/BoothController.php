<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class BoothController extends Controller
{
    // halaman booth
    public function index()
    {
        $photos = Photo::latest()->get();

        return view('booth', compact('photos'));
    }

    // simpan foto
    public function store(Request $request)
    {
        $image = $request->image;

        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        $imageName = time() . '.png';

        Storage::disk('public')->put(
            'photos/' . $imageName,
            base64_decode($image)
        );

        Photo::create([
            'image' => 'photos/' . $imageName,
            'filter' => $request->filter,
            'frame' => $request->frame
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}