<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function gallery()
    {
        $photos = Photo::latest()->get();

        return view('gallery', compact('photos'));
    }

    public function destroy(Photo $photo)
    {
       
        if (Storage::disk('public')->exists($photo->image)) {
            Storage::disk('public')->delete($photo->image);
        }

       
        $photo->delete();

        return redirect()->route('gallery')
            ->with('success', 'Photo deleted successfully.');
    }
}