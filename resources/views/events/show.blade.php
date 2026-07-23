@extends('layouts.app')

@section('title', $event->title . ' — Knowledge Valley International School')
@section('meta_description', $event->excerpt)

@section('content')
@include('partials.page-hero', [
    'title' => $event->title,
    'subtitle' => $event->excerpt,
    'crumbs' => [['Events', route('events.index')], [$event->title, null]],
])

@php $images = array_values(array_filter(array_merge([$event->image], $event->gallery ?? []))); @endphp

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site max-w-4xl">
        {{-- Gallery slider --}}
        @if (count($images))
        <div class="reveal" data-gallery>
            <div class="relative rounded-sm overflow-hidden shadow-xl bg-maroon-950">
                <img data-gallery-main src="{{ $images[0] }}" alt="{{ $event->title }}" class="w-full aspect-[16/9] object-cover" width="1600" height="900">
                @if (count($images) > 1)
                <button type="button" data-gallery-prev aria-label="Previous photo" class="absolute left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/90 shadow-lg flex items-center justify-center text-maroon-800 hover:bg-gold-500 hover:text-maroon-950 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                </button>
                <button type="button" data-gallery-next aria-label="Next photo" class="absolute right-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/90 shadow-lg flex items-center justify-center text-maroon-800 hover:bg-gold-500 hover:text-maroon-950 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </button>
                <span data-gallery-counter class="absolute bottom-3 right-3 text-xs px-2.5 py-1 rounded-full bg-maroon-950/70 text-ivory tabular-nums">1 / {{ count($images) }}</span>
                @endif
            </div>
            @if (count($images) > 1)
            <div class="mt-3 flex gap-2 overflow-x-auto pb-1">
                @foreach ($images as $i => $img)
                <button type="button" data-gallery-thumb="{{ $i }}" class="shrink-0 w-20 h-16 rounded-sm overflow-hidden border-2 {{ $i === 0 ? 'border-gold-500' : 'border-transparent' }} hover:border-gold-400 transition-colors cursor-pointer">
                    <img src="{{ $img }}" alt="" class="w-full h-full object-cover" loading="lazy">
                </button>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        {{-- Meta --}}
        <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-charcoal-600">
            @if ($event->starts_at)
            <span class="inline-flex items-center gap-2"><svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>{{ $event->starts_at->format('D, d M Y') }}</span>
            @endif
            @if ($event->location)
            <span class="inline-flex items-center gap-2"><svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>{{ $event->location }}</span>
            @endif
        </div>

        {{-- Body --}}
        @if ($event->body)
        <div class="mt-6 space-y-5 text-charcoal-700 leading-[1.85] text-[17px]">
            @foreach (preg_split('/\n\n+/', trim($event->body)) as $para)
            <p>{{ $para }}</p>
            @endforeach
        </div>
        @else
        <p class="mt-6 text-charcoal-600 leading-relaxed">{{ $event->excerpt }}</p>
        @endif

        {{-- Prev / Next --}}
        <div class="mt-14 grid sm:grid-cols-2 gap-4 border-t border-beige-200 pt-8">
            @if ($prev)
            <a href="{{ route('events.show', $prev->slug) }}" class="group flex items-center gap-4 bg-white rounded-sm border border-beige-200 p-4 hover:border-gold-500 hover:shadow-sm transition-all">
                <svg class="w-6 h-6 text-maroon-700 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                <span class="min-w-0"><span class="block text-xs text-charcoal-500 uppercase tracking-wide">Previous</span><span class="block font-semibold text-maroon-900 truncate">{{ $prev->title }}</span></span>
            </a>
            @else
            <span class="hidden sm:block"></span>
            @endif
            @if ($next)
            <a href="{{ route('events.show', $next->slug) }}" class="group flex items-center justify-end gap-4 bg-white rounded-sm border border-beige-200 p-4 hover:border-gold-500 hover:shadow-sm transition-all text-right">
                <span class="min-w-0"><span class="block text-xs text-charcoal-500 uppercase tracking-wide">Next</span><span class="block font-semibold text-maroon-900 truncate">{{ $next->title }}</span></span>
                <svg class="w-6 h-6 text-maroon-700 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>
            @endif
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-maroon-800 hover:text-maroon-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                All events
            </a>
        </div>
    </div>
</section>

@if (count($images) > 1)
<script>
    (function () {
        var root = document.querySelector('[data-gallery]');
        if (!root) return;
        var imgs = @json($images);
        var main = root.querySelector('[data-gallery-main]');
        var counter = root.querySelector('[data-gallery-counter]');
        var thumbs = root.querySelectorAll('[data-gallery-thumb]');
        var idx = 0;
        function show(i) {
            idx = (i + imgs.length) % imgs.length;
            main.src = imgs[idx];
            if (counter) counter.textContent = (idx + 1) + ' / ' + imgs.length;
            thumbs.forEach(function (t, j) {
                t.classList.toggle('border-gold-500', j === idx);
                t.classList.toggle('border-transparent', j !== idx);
            });
        }
        var p = root.querySelector('[data-gallery-prev]'), n = root.querySelector('[data-gallery-next]');
        if (p) p.addEventListener('click', function () { show(idx - 1); });
        if (n) n.addEventListener('click', function () { show(idx + 1); });
        thumbs.forEach(function (t) { t.addEventListener('click', function () { show(parseInt(t.getAttribute('data-gallery-thumb'), 10)); }); });
    })();
</script>
@endif

@include('partials.cta-band')
@endsection
