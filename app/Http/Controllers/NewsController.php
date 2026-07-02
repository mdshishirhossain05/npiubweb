<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $news = News::query()->where('status', 'published')
            ->latest('published_at')->paginate(9);

        return view('pages.news.index', compact('news'));
    }

    public function show(News $news): View
    {
        abort_unless($news->status === 'published', 404);

        $related = News::query()->where('status', 'published')
            ->whereKeyNot($news->getKey())->latest('published_at')->take(3)->get();

        return view('pages.news.show', ['article' => $news, 'related' => $related]);
    }
}
