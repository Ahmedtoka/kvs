{{-- Usage: @include('partials.event-card', ['event' => $event]) --}}
<article class="reveal group bg-white rounded-sm shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-beige-200 flex flex-col">
    <a href="{{ route('events.show', $event) }}" class="block overflow-hidden relative">
        <img src="{{ $event->image ?: '/images/placeholders/hero-campus.svg' }}" alt="{{ $event->title }}"
             class="w-full aspect-[16/10] object-cover transition-transform duration-500 group-hover:scale-[1.03]" width="1600" height="1000" loading="lazy">
        <span class="absolute top-4 left-4 bg-maroon-900 text-ivory rounded-sm px-3 py-2 text-center leading-none shadow-md">
            <span class="block font-display text-xl font-bold text-gold-400">{{ $event->starts_at->format('d') }}</span>
            <span class="block text-[10px] uppercase tracking-wider mt-1">{{ $event->starts_at->format('M Y') }}</span>
        </span>
    </a>
    <div class="p-6 flex flex-col grow">
        <div class="flex items-center gap-2 text-xs text-charcoal-600">
            <svg class="w-3.5 h-3.5 text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $event->starts_at->format('h:i A') }}
            @if ($event->location)
            <span aria-hidden="true" class="text-gold-600">·</span>
            <svg class="w-3.5 h-3.5 text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
            {{ $event->location }}
            @endif
        </div>
        <h3 class="font-display text-xl font-semibold text-maroon-900 mt-3">
            <a href="{{ route('events.show', $event) }}" class="hover:text-maroon-700 transition-colors">{{ $event->title }}</a>
        </h3>
        <p class="mt-2.5 text-sm text-charcoal-600 leading-relaxed grow">{{ $event->excerpt }}</p>
        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-maroon-800 hover:text-maroon-600 transition-colors">
            Event details
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
        </a>
    </div>
</article>
