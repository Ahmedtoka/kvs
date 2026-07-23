<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::active()->ordered()->get();

        return view('events.index', compact('events'));
    }

    public function show(Event $event): View
    {
        abort_unless($event->is_active, 404);

        $ordered = Event::active()->ordered()->get(['slug', 'title', 'image']);
        $pos = $ordered->search(fn ($e) => $e->slug === $event->slug);

        $prev = $pos > 0 ? $ordered[$pos - 1] : null;
        $next = ($pos !== false && $pos < $ordered->count() - 1) ? $ordered[$pos + 1] : null;

        return view('events.show', compact('event', 'prev', 'next'));
    }
}
