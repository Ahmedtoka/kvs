<x-mail::message>
# New Admissions Lead

A new "Request a Call Back" was submitted on the website.

**Parent:** {{ $lead->parent_name }}<br>
**Phone:** {{ $lead->phone }}<br>
**Child's age:** {{ $lead->child_age }} years<br>
**Stage of interest:** {{ ['early-years' => 'Early Years (FS1–FS2)', 'primary' => 'Primary (Years 1–6)', 'secondary' => 'Secondary & IGCSE'][$lead->stage] ?? 'Not specified' }}<br>
**Received:** {{ $lead->created_at->format('d M Y, h:i A') }}

<x-mail::button :url="route('admin.leads')">
Open Leads Dashboard
</x-mail::button>

Please contact the parent within 24 hours.

{{ config('app.name') }}
</x-mail::message>
