<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Contracts\View\View;

class NoticeController extends Controller
{
    public function index(): View
    {
        return view('public.notices.index', [
            'notices' => Notice::query()
                ->published()
                ->orderByDesc('is_pinned')
                ->orderByDesc('notice_date')
                ->paginate(15),
        ]);
    }

    public function show(Notice $notice): View
    {
        abort_unless($notice->isPublished(), 404);

        return view('public.notices.show', ['notice' => $notice]);
    }
}
