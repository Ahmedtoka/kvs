<?php

namespace App\Http\Controllers;

use App\Mail\NewLeadReceived;
use App\Models\Lead;
use App\Models\TrackingEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    /**
     * Store a new admissions lead from the "Request a Call Back" form.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'parent_name' => ['required', 'string', 'max:120'],
            'phone'       => ['required', 'string', 'regex:/^(\+?2)?01[0-9]{9}$/'],
            'child_age'   => ['required', 'integer', 'between:3,17'],
            'stage'       => ['nullable', 'in:early-years,primary,secondary'],
        ], [
            'parent_name.required' => 'Please enter your full name.',
            'phone.required'       => 'Please enter your mobile number.',
            'phone.regex'          => 'Please enter a valid Egyptian mobile number (e.g. 01X XXXX XXXX).',
            'child_age.required'   => "Please select your child's age.",
        ]);

        $lead = Lead::create($validated);

        // Server-side funnel event (reliable even if the JS tracker is blocked).
        try {
            TrackingEvent::create([
                'visitor_id' => substr((string) ($request->cookie('kvs_vid') ?? 'unknown'), 0, 36),
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'event'      => 'form_submit',
                'page'       => '/' . ltrim($request->path(), '/'),
                'label'      => 'lead#' . $lead->id,
                'device'     => preg_match('/Mobile|Android|iPhone/i', (string) $request->userAgent()) ? 'mobile' : 'desktop',
            ]);
        } catch (\Throwable $e) {
            report($e);
        }

        // Notify the admissions team. With MAIL_MAILER=log this is written to
        // storage/logs/laravel.log — set real SMTP credentials in .env to send.
        try {
            Mail::to('admission@kvs.edu.eg')->send(new NewLeadReceived($lead));
        } catch (\Throwable $e) {
            report($e); // Never let a mail failure block the lead from being saved.
        }

        return redirect()->back(fallback: route('book-tour'))
            ->withFragment('lead-form')
            ->with('success', "Thank you! Your request has been received — our admissions team will contact you within 24 hours.");
    }
}
