<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        return view('public.posts.index', [
            'posts' => Post::query()
                ->published()
                ->with('category')
                ->latest('published_at')
                ->paginate(9),
        ]);
    }

    public function show(Post $post): View
    {
        abort_unless($post->isPublished(), 404);

        return view('public.posts.show', [
            'post' => $post->load('category'),
            'related' => Post::query()
                ->published()
                ->whereKeyNot($post->getKey())
                ->when($post->category_id, fn ($query) => $query->where('category_id', $post->category_id))
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }
}
