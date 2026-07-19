<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        return view('events.index', [
            'upcoming' => Event::upcoming()->get(),
            'past'     => Event::past()->paginate(9, ['*'], 'past_page'),
        ]);
    }

    public function show(Event $event): View
    {
        return view('events.show', [
            'event' => $event,
            'more'  => Event::upcoming()->where('id', '!=', $event->id)->limit(3)->get(),
        ]);
    }
}
