<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('image')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('gallery.index', compact('galleries'));
    }

    public function show(Gallery $gallery)
    {
        if ($gallery->status !== 'active') {
            abort(404);
        }

        $relatedGalleries = Gallery::with('image')
            ->where('status', 'active')
            ->where('id', '!=', $gallery->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('gallery.show', compact('gallery', 'relatedGalleries'));
    }
}