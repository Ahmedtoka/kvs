<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventAdminController extends Controller
{
    public function index()
    {
        $events = Event::ordered()->get();

        return view('admin.events.index', compact('events'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Event::create([
            'title'       => $data['title'],
            'slug'        => $this->uniqueSlug($data['title']),
            'excerpt'     => $data['excerpt'] ?? null,
            'image'       => $this->handleImage($request) ?? '/img/event-science-fair.jpg',
            'sort_order'  => (int) ($data['sort_order'] ?? 0),
            'is_active'   => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return back()->with('success', 'Event added.');
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validated($request);

        $event->title       = $data['title'];
        $event->excerpt     = $data['excerpt'] ?? null;
        $event->sort_order  = (int) ($data['sort_order'] ?? 0);
        $event->is_active   = $request->boolean('is_active');
        $event->is_featured = $request->boolean('is_featured');
        if ($img = $this->handleImage($request)) {
            $event->image = $img;
        }
        $event->save();

        return back()->with('success', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return back()->with('success', 'Event removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'      => ['required', 'string', 'max:120'],
            'excerpt'    => ['nullable', 'string', 'max:300'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image_file' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function handleImage(Request $request): ?string
    {
        if (! $request->hasFile('image_file')) {
            return null;
        }
        $dir = public_path('img');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $file = $request->file('image_file');
        $name = 'event-' . date('Ymd_His') . '-' . Str::random(5) . '.' . strtolower($file->getClientOriginalExtension());
        $file->move($dir, $name);

        return '/img/' . $name;
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'event';
        $slug = $base;
        $i = 2;
        while (Event::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
