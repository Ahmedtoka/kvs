@extends('layouts.site')

@section('title', $event->title . ' | Events — Knowledge Valley')
@section('description', $event->excerpt)

@section('content')

@include('partials.page-hero', [
    'eyebrow' => $event->starts_at->isFuture() ? 'Upcoming Event' : 'Past Event',
    'title'   => $event->title,
    'lead'    => $event->excerpt,
    'crumbs'  => [['label' => 'Events', 'url' => route('events.index')], ['label' => $event->title]],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-3 gap-12 items-start">
        <article class="lg:col-span-2 reveal">
            <img src="{{ $event->image ?: '/images/placeholders/hero-campus.svg' }}" alt="{{ $event->title }}" class="w-full rounded-sm shadow-lg aspect-[16/9] object-cover" width="1600" height="900">
            <div class="mt-8 space-y-5 text-charcoal-700 leading-[1.8]">
                @foreach (preg_split('/\n\n+/', $event->body) as $para)
                <p>{{ $para }}</p>
                @endforeach
            </div>
        </article>

        <aside class="reveal space-y-6">
            <div class="bg-white rounded-sm border border-beige-200 shadow-md p-7">
                <h2 class="font-display text-xl font-semibold text-maroon-900">Event Details</h2>
                <dl class="mt-5 space-y-4 text-sm">
                    <div class="flex gap-3">
                        <dt class="sr-only">Date</dt>
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-gold-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        <dd class="text-charcoal-700">
                            {{ $event->starts_at->format('l, d F Y') }}<br>
                            {{ $event->starts_at->format('h:i A') }}@if($event->ends_at) – {{ $event->ends_at->format('h:i A') }}@endif
                        </dd>
                    </div>
                    @if ($event->location)
                    <div class="flex gap-3">
                        <dt class="sr-only">Location</dt>
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-gold-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <dd class="text-charcoal-700">{{ $event->location }}</dd>
                    </div>
                    @endif
                </dl>
                @if ($event->starts_at->isFuture())
                <a href="{{ route('book-tour') }}" data-track="cta_click" data-label="event-page-book-tour" class="btn-gold w-full mt-6">Visiting? Book a Tour Too</a>
                @endif
            </div>

            @if ($more->isNotEmpty())
            <div class="bg-white rounded-sm border border-beige-200 shadow-md p-7">
                <h2 class="font-display text-xl font-semibold text-maroon-900">More Upcoming</h2>
                <ul class="mt-4 divide-y divide-beige-100">
                    @foreach ($more as $m)
                    <li class="py-3">
                        <a href="{{ route('events.show', $m) }}" class="group block">
                            <span class="block text-xs text-gold-700 font-semibold">{{ $m->starts_at->format('d M Y') }}</span>
                            <span class="block mt-0.5 font-medium text-charcoal-800 group-hover:text-maroon-800 transition-colors">{{ $m->title }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('events.index') }}" data-track="see_all_click" data-label="event-page-see-all" class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-maroon-800 hover:text-maroon-600 transition-colors">
                    See all events
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
            @endif
        </aside>
    </div>
</section>

@endsection
