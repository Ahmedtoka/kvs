{{-- Usage: @include('partials.news-card', ['post' => $post]) --}}
<article class="reveal group bg-white rounded-sm shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-beige-200 flex flex-col">
    <a href="{{ route('news.show', $post) }}" class="block overflow-hidden">
        <img src="{{ $post->image ?: '/images/placeholders/welcome.svg' }}" alt="{{ $post->title }}"
             class="w-full aspect-[16/10] object-cover transition-transform duration-500 group-hover:scale-[1.03]" width="1600" height="1000" loading="lazy">
    </a>
    <div class="p-6 flex flex-col grow">
        <time datetime="{{ $post->published_at?->toDateString() }}" class="text-xs uppercase tracking-wider text-gold-700 font-semibold">
            {{ $post->published_at?->format('d M Y') }}
        </time>
        <h3 class="font-display text-xl font-semibold text-maroon-900 mt-3">
            <a href="{{ route('news.show', $post) }}" class="hover:text-maroon-700 transition-colors">{{ $post->title }}</a>
        </h3>
        <p class="mt-2.5 text-sm text-charcoal-600 leading-relaxed grow">{{ $post->excerpt }}</p>
        <a href="{{ route('news.show', $post) }}" class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-maroon-800 hover:text-maroon-600 transition-colors">
            Read more
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
        </a>
    </div>
</article>
