<?php

namespace App\Http\Controllers;

use App\Models\TrackingEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrackController extends Controller
{
    /**
     * Receive a client-side tracking event from the JS tracker.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'event' => ['required', 'string', 'in:' . implode(',', TrackingEvent::CLIENT_EVENTS)],
            'page'  => ['required', 'string', 'max:191'],
            'label' => ['nullable', 'string', 'max:191'],
        ]);

        $visitorId = $request->cookie('kvs_vid')
            ?? $request->attributes->get('kvs_visitor_id')
            ?? (string) Str::uuid();

        try {
            TrackingEvent::create([
                'visitor_id' => substr((string) $visitorId, 0, 36),
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'event'      => $validated['event'],
                'page'       => $validated['page'],
                'label'      => $validated['label'] ?? null,
                'device'     => TrackingEvent::deviceFrom($request->userAgent()),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }

        return response()->json(['ok' => true]);
    }
}
