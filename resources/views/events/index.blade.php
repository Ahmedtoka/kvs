@extends('layouts.app')

@section('title', 'School Events — Knowledge Valley International School')
@section('meta_description', 'Events at KVS — science fairs, graduations, celebrations and more. Explore the life of Knowledge Valley International School.')

@section('content')
@include('partials.page-hero', [
    'title' => 'School Events',
    'subtitle' => 'Science fairs, graduations, celebrations and more — step inside the life of Knowledge Valley.',
    'crumbs' => [['School Life', '/school-life'], ['Events', null]],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($events as $event)
            <a href="{{ route('events.show', $event->slug) }}" class="reveal group bg-white rounded-sm shadow-md hover:shadow-xl border border-beige-200 overflow-hidden block transition-shadow">
                <div class="relative overflow-hidden aspect-[4/3]">
                    <img src="{{ $event->image ?: '/img/hero-campus.svg' }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.04]" width="1600" height="1000" loading="lazy">
                    @if ($event->gallery && count($event->gallery))
                    <span class="absolute top-3 right-3 inline-flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-full bg-maroon-950/80 text-ivory">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                        {{ count($event->gallery) + 1 }}
                    </span>
                    @endif
                </div>
                <div class="p-5">
                    <h2 class="font-display text-lg font-bold text-maroon-900 group-hover:text-maroon-700 transition-colors">{{ $event->title }}</h2>
                    @if ($event->excerpt)<p class="mt-2 text-sm text-charcoal-600 leading-relaxed line-clamp-3">{{ $event->excerpt }}</p>@endif
                    <span class="inline-flex items-center gap-1.5 mt-4 text-sm font-semibold text-gold-700 group-hover:text-gold-800">Read more
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                    </span>
                </div>
            </a>
            @empty
            <p class="text-charcoal-600 col-span-full text-center py-10">No events published yet.</p>
            @endforelse
        </div>
    </div>
</section>

@include('partials.cta-band')
@endsection
