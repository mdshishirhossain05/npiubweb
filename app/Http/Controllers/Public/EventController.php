<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Contracts\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        return view('public.events.index', [
            'upcoming' => Event::query()
                ->published()
                ->where('starts_at', '>=', now()->startOfDay())
                ->orderBy('starts_at')
                ->get(),
            'past' => Event::query()
                ->published()
                ->where('starts_at', '<', now()->startOfDay())
                ->orderByDesc('starts_at')
                ->take(10)
                ->get(),
        ]);
    }

    public function show(Event $event): View
    {
        abort_unless($event->isPublished(), 404);

        return view('public.events.show', ['event' => $event]);
    }
}
