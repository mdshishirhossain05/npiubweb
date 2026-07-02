<?php

namespace App\Http\Controllers;

use App\Models\Research;
use Illuminate\View\View;

class ResearchController extends Controller
{
    public function index(): View
    {
        $items = Research::query()->where('status', 'published')
            ->latest('published_at')->paginate(9);

        return view('pages.research.index', compact('items'));
    }

    public function show(Research $research): View
    {
        abort_unless($research->status === 'published', 404);

        return view('pages.research.show', ['article' => $research]);
    }
}
