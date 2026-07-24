<?php

namespace App\Http\Controllers;

use App\Models\CareerApplication;
use App\Models\Lead;
use App\Services\MetaConversions;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    /** Public form handler — Book a Tour / Call Back / Fees request. */
    public function store(Request $request)
    {
        // Honeypot: real users never fill this hidden field
        if ($request->filled('website')) {
            return back();
        }

        $type = in_array($request->input('type'), array_keys(Lead::TYPES)) ? $request->input('type') : 'callback';

        $rules = [
            'parent_name' => ['required', 'string', 'max:120'],
            'phone'       => ['required', 'string', 'regex:/^01[0-9]{9}$/'],
            'email'       => ['nullable', 'email', 'max:190'],
            'child_age'   => ['nullable', 'string', 'max:10'],
            'stage'       => ['nullable', 'string', 'max:30'],
            'student_name'   => ['nullable', 'string', 'max:120'],
            'year_group'     => ['nullable', 'string', 'max:20'],
            'preferred_date' => ['nullable', 'date', 'after_or_equal:today'],
            'notes'          => ['nullable', 'string', 'max:2000'],
        ];

        if ($type === 'tour') {
            $rules['student_name'][0] = 'required';
            $rules['year_group'][0] = 'required';
            $rules['preferred_date'][] = function ($attribute, $value, $fail) {
                if ($value && in_array(\Illuminate\Support\Carbon::parse($value)->dayOfWeek, [5, 6], true)) {
                    $fail('Tours are not available on Fridays or Saturdays. Please choose another day.');
                }
            };
        }

        $data = $request->validate($rules, ['phone.regex' => 'Please enter a valid 11-digit mobile number, e.g. 01012345678.']);

        Lead::create([
            'type'           => $type,
            'parent_name'    => $data['parent_name'],
            'student_name'   => $data['student_name'] ?? null,
            'phone'          => $data['phone'],
            'email'          => $data['email'] ?? null,
            'child_age'      => $data['child_age'] ?? null,
            'stage'          => $data['stage'] ?? null,
            'year_group'     => $data['year_group'] ?? null,
            'preferred_date' => $data['preferred_date'] ?? null,
            'message'        => $data['notes'] ?? null,
            'source'         => url()->previous(),
        ]);

        $this->logConversion($request, $type);

        $eventId = (string) Str::uuid();
        MetaConversions::sendLead($request, $eventId, [
            'email'            => $data['email'] ?? null,
            'phone'            => $data['phone'] ?? null,
            'name'             => $data['parent_name'] ?? null,
            'content_name'     => $type,
            'content_category' => 'lead',
        ]);

        // A tour booking is also a genuine "Schedule" (appointment booked).
        if ($type === 'tour') {
            MetaConversions::send($request, 'Schedule', $eventId . '-s', [
                'email'            => $data['email'] ?? null,
                'phone'            => $data['phone'] ?? null,
                'name'             => $data['parent_name'] ?? null,
                'content_name'     => 'Book a Tour',
                'content_category' => 'tour',
            ]);
        }

        return redirect()->route('thank-you', ['type' => $type])
            ->with('just_converted', true)
            ->with('meta_event_id', $eventId);
    }

    /** Public careers form handler. */
    public function storeCareer(Request $request)
    {
        if ($request->filled('website')) {
            return back();
        }

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'phone'    => ['required', 'string', 'regex:/^01[0-9]{9}$/'],
            'email'    => ['required', 'email', 'max:190'],
            'position' => ['required', 'string', 'max:120'],
            'cv'       => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ], ['phone.regex' => 'Please enter a valid 11-digit mobile number, e.g. 01012345678.']);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $dir = public_path('uploads/cvs');
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $file = $request->file('cv');
            $name = date('Ymd_His') . '_' . preg_replace('/[^A-Za-z0-9._-]/', '', $file->getClientOriginalName());
            $file->move($dir, $name);
            $cvPath = 'uploads/cvs/' . $name;
        }

        CareerApplication::create([
            'name'     => $data['name'],
            'phone'    => $data['phone'],
            'email'    => $data['email'],
            'position' => $data['position'],
            'cv_path'  => $cvPath,
        ]);

        $this->logConversion($request, 'career');

        $eventId = (string) Str::uuid();
        MetaConversions::sendLead($request, $eventId, [
            'email'            => $data['email'] ?? null,
            'phone'            => $data['phone'] ?? null,
            'name'             => $data['name'] ?? null,
            'content_name'     => 'career',
            'content_category' => 'career',
        ]);

        return redirect()->route('thank-you', ['type' => 'career'])
            ->with('just_converted', true)
            ->with('meta_event_id', $eventId);
    }

    /**
     * Record an internal first-party conversion event with first-touch UTM
     * attribution, so the User-Flow report can show which ad / campaign drove it.
     */
    private function logConversion(Request $request, string $type): void
    {
        $vid = $request->cookie('kvs_vid');
        if (! is_string($vid) || strlen($vid) !== 36) {
            $vid = (string) \Illuminate\Support\Str::uuid();
        }

        $firstTouch = \App\Models\TrackingEvent::where('visitor_id', $vid)
            ->where('event', 'pageview')
            ->where(fn ($q) => $q->whereNotNull('utm_source')->orWhereNotNull('utm_campaign'))
            ->orderBy('id')
            ->first();

        try {
            \App\Models\TrackingEvent::create([
                'visitor_id'   => $vid,
                'session_id'   => $request->hasSession() ? $request->session()->getId() : null,
                'event'        => 'conversion',
                'page'         => '/thank-you/' . $type,
                'label'        => $type,
                'referrer'     => \Illuminate\Support\Str::limit((string) url()->previous(), 180, ''),
                'utm_source'   => $firstTouch->utm_source ?? null,
                'utm_medium'   => $firstTouch->utm_medium ?? null,
                'utm_campaign' => $firstTouch->utm_campaign ?? null,
                'device'       => \App\Models\TrackingEvent::deviceFrom($request->userAgent()),
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
