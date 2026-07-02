<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $albums = GalleryAlbum::query()->where('is_active', true)
            ->withCount('images')->orderBy('priority')->orderByDesc('id')->paginate(12);

        return view('pages.gallery.index', compact('albums'));
    }

    public function show(GalleryAlbum $album): View
    {
        abort_unless($album->is_active, 404);
        $album->load('images.media');

        return view('pages.gallery.show', compact('album'));
    }
}
