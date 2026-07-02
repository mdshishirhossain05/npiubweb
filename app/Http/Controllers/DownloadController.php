<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\View\View;

class DownloadController extends Controller
{
    public function index(): View
    {
        $downloads = Download::query()->where('is_active', true)
            ->orderBy('priority')->orderBy('title')->get()
            ->groupBy(fn ($d) => $d->category ?: 'General');

        return view('pages.downloads.index', compact('downloads'));
    }
}
