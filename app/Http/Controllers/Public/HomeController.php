<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Event;
use App\Models\Notice;
use App\Models\Post;
use App\Models\Slide;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('public.home', [
            'slides' => Slide::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
            'posts' => Post::query()
                ->published()
                ->latest('published_at')
                ->take(6)
                ->get(),
            'notices' => Notice::query()
                ->published()
                ->orderByDesc('is_pinned')
                ->orderByDesc('notice_date')
                ->take(5)
                ->get(),
            'events' => Event::query()
                ->published()
                ->where('starts_at', '>=', now()->startOfDay())
                ->orderBy('starts_at')
                ->take(4)
                ->get(),
            'departments' => Department::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
