<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoticeController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Notice::query()->where('status', 'published')
            ->select('category')->distinct()->orderBy('category')->pluck('category');

        $notices = Notice::query()
            ->where('status', 'published')
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->string('category')))
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->orderByDesc('is_important')
            ->orderByDesc('notice_date')
            ->paginate(12)
            ->withQueryString();

        return view('pages.notices.index', compact('notices', 'categories'));
    }

    public function show(Notice $notice): View
    {
        abort_unless($notice->status === 'published', 404);
        $notice->increment('views');

        $related = Notice::query()->where('status', 'published')
            ->whereKeyNot($notice->getKey())->latest('notice_date')->take(5)->get();

        return view('pages.notices.show', compact('notice', 'related'));
    }
}
