<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $upcoming = Event::query()->where('status', 'published')
            ->where('starts_at', '>=', now()->startOfDay())->orderBy('starts_at')->get();

        $past = Event::query()->where('status', 'published')
            ->where('starts_at', '<', now()->startOfDay())->orderByDesc('starts_at')->paginate(9);

        return view('pages.events.index', compact('upcoming', 'past'));
    }

    public function show(Event $event): View
    {
        abort_unless($event->status === 'published', 404);

        return view('pages.events.show', compact('event'));
    }
}
