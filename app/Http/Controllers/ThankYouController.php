<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThankYouController extends Controller
{
    /**
     * Post-submission Thank-You page. Fires conversion pixels only when the
     * visitor genuinely just submitted a form (guarded by a session flag),
     * so refreshes and direct visits never inflate ad conversions.
     */
    public function show(Request $request, string $type = 'callback'): View
    {
        $labels = Lead::TYPES + ['career' => 'Career Application'];

        if (! array_key_exists($type, $labels)) {
            $type = 'callback';
        }

        // Human sentence shown on the page, per form type.
        $messages = [
            'callback' => 'Our admissions team will call you back within 24 hours.',
            'tour'     => 'Your school tour request is in. We will confirm your visit shortly.',
            'fees'     => 'Your fees request is received. We will send the full fee structure within 24 hours.',
            'career'   => 'Your application has been received. Our HR team will be in touch.',
        ];

        return view('thank-you', [
            'type'      => $type,
            'label'     => $labels[$type],
            'message'   => $messages[$type] ?? $messages['callback'],
            'converted' => (bool) $request->session()->get('just_converted', false),
        ]);
    }
}
