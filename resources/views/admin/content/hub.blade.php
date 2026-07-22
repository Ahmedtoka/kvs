@extends('admin.layout')

@section('title', 'Content')

@section('content')
<div>
    <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Content</h1>
    <p class="text-sm text-charcoal-600 mt-1">Edit what parents see on the website. Open any page to preview it live.</p>
</div>


{{-- Quick editors --}}
<h2 class="mt-8 font-display text-lg font-bold text-maroon-900">Quick editors</h2>
<div class="mt-3 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach ($modules as $m)
    <a href="{{ $m['route'] }}" class="block bg-white rounded-sm shadow-sm border border-beige-200 p-5 hover:border-gold-500 hover:shadow-md transition-all">
        <p class="font-semibold text-maroon-900">{{ $m['name'] }}</p>
        <p class="text-xs text-charcoal-600 mt-1.5 leading-relaxed">{{ $m['desc'] }}</p>
        <span class="inline-flex items-center gap-1 text-sm font-semibold text-gold-700 mt-3">Open &rarr;</span>
    </a>
    @endforeach
</div>

{{-- All pages --}}
<h2 class="mt-10 font-display text-lg font-bold text-maroon-900">All website pages</h2>
<p class="text-sm text-charcoal-600 mt-1">Click &ldquo;View&rdquo; to see exactly how a page looks on the live site.</p>
<div class="mt-4 bg-white rounded-sm shadow-sm border border-beige-200 divide-y divide-beige-100">
    @foreach ($pages as $page)
    <div class="flex items-center justify-between gap-4 px-5 py-3.5">
        <div class="min-w-0">
            <p class="font-medium text-charcoal-800">{{ $page['name'] }}</p>
            <p class="text-xs text-charcoal-500 truncate">{{ $page['url'] }}</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            @if ($page['edit'])
            <a href="{{ $page['edit'] }}" class="text-sm font-semibold text-maroon-800 hover:text-maroon-600 px-3 py-2 rounded-sm border border-beige-200">Edit</a>
            @endif
            <a href="{{ $page['url'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-sm font-semibold text-gold-700 hover:text-gold-800 px-3 py-2 rounded-sm border border-beige-200">
                View
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
            </a>
        </div>
    </div>
    @endforeach
</div>

<p class="mt-6 text-xs text-charcoal-500 leading-relaxed">
    Pages without an &ldquo;Edit&rdquo; button are built-in layouts. Their contact details, social links and tracking are edited under
    <a href="{{ route('admin.settings') }}" class="text-maroon-700 font-semibold hover:underline">Site Settings</a>; their photos under
    <a href="{{ route('admin.events.index') }}" class="text-maroon-700 font-semibold hover:underline">Events</a>.
</p>
@endsection
