<?php

namespace App\Http\Controllers;

use App\Models\CareerApplication;
use App\Models\Lead;
use Illuminate\Http\Request;

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
            'phone'       => ['required', 'string', 'max:30', 'regex:/^[0-9+\s\-()]{7,}$/'],
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
            $rules['preferred_date'][0] = 'required';
        }

        $data = $request->validate($rules);

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

        return back()->with('lead_success', __("Thank you! Our admissions team will contact you within 24 hours."));
    }

    /** Public careers form handler. */
    public function storeCareer(Request $request)
    {
        if ($request->filled('website')) {
            return back();
        }

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'phone'    => ['required', 'string', 'max:30'],
            'email'    => ['required', 'email', 'max:190'],
            'position' => ['required', 'string', 'max:120'],
            'cv'       => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

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

        return back()->with('lead_success', __('Thank you! Your application has been received — our HR team will be in touch.'));
    }
}
