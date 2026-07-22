@extends('admin.layout')

@section('title', 'Reset Data')

@section('content')
<div>
    <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Reset Data</h1>
    <p class="text-sm text-charcoal-600 mt-1">Clear all test/collected data and start fresh — your accounts, settings and content stay safe.</p>
</div>

@if ($errors->any())
<div class="mt-5 bg-red-50 border border-red-300 text-red-800 text-sm rounded-sm px-4 py-3">
    <ul class="list-disc ms-4 space-y-1">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="mt-6 grid lg:grid-cols-2 gap-6">
    {{-- What gets deleted --}}
    <div class="bg-white rounded-sm shadow-sm border-2 border-red-200 p-6">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            <h2 class="font-display text-lg font-bold text-red-700">Will be permanently deleted</h2>
        </div>
        <div class="mt-4 space-y-2">
            @php $wipeLabels = [
                'leads' => 'Leads (all Book-a-Tour / Call-back / Fees requests)',
                'lead_activities' => 'Lead history, feedback, schedules & tours',
                'tracking_events' => 'Visitors, User Flow & all Analytics data',
                'career_applications' => 'Career applications',
            ]; @endphp
            @foreach ($wipeLabels as $key => $label)
            <div class="flex items-center justify-between gap-3 py-2 border-b border-beige-100 last:border-0">
                <span class="text-sm text-charcoal-800">{{ $label }}</span>
                <span class="text-sm font-semibold text-red-700 tabular-nums shrink-0">{{ number_format($counts[$key] ?? 0) }} rows</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- What stays --}}
    <div class="bg-white rounded-sm shadow-sm border-2 border-green-200 p-6">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h2 class="font-display text-lg font-bold text-green-700">Stays safe (untouched)</h2>
        </div>
        <div class="mt-4 space-y-2">
            @php $keepLabels = [
                'users' => 'Admin accounts & roles',
                'settings' => 'Site settings (contact, social, tracking IDs)',
                'content_items' => 'FAQs & Parent Services',
                'events' => 'Events & gallery',
            ]; @endphp
            @foreach ($keepLabels as $key => $label)
            <div class="flex items-center justify-between gap-3 py-2 border-b border-beige-100 last:border-0">
                <span class="text-sm text-charcoal-800">{{ $label }}</span>
                <span class="text-sm font-semibold text-green-700 tabular-nums shrink-0">{{ number_format($keepCounts[$key] ?? 0) }} kept</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Confirm + action --}}
<div class="mt-6 bg-maroon-950 text-ivory rounded-sm p-6 sm:p-8">
    <h2 class="font-display text-xl font-bold text-gold-400">Confirm reset</h2>
    <p class="mt-2 text-sm text-ivory/80 max-w-2xl">This cannot be undone. Do this once, right before you go live, so you start collecting real visitor and lead data from a clean slate.</p>
    <form method="POST" action="{{ route('admin.reset.perform') }}" class="mt-5 flex flex-col sm:flex-row sm:items-end gap-4"
          onsubmit="return confirm('This will permanently delete all leads, submissions and analytics. Continue?');">
        @csrf
        <div class="grow max-w-xs">
            <label for="confirmation" class="block text-sm font-medium mb-1.5">Type <span class="font-bold text-gold-400">RESET</span> to confirm</label>
            <input type="text" id="confirmation" name="confirmation" autocomplete="off" placeholder="RESET"
                   class="w-full h-12 px-4 rounded-sm border border-maroon-700 bg-maroon-900 text-ivory placeholder:text-ivory/40 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none uppercase tracking-widest">
        </div>
        <button type="submit" class="inline-flex items-center justify-center gap-2 h-12 px-7 rounded-sm bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165"/></svg>
            Clear all data
        </button>
    </form>
</div>
@endsection
