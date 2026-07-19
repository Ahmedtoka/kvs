@extends('layouts.site')

@section('title', $post->title . ' | News — Knowledge Valley')
@section('description', $post->excerpt)

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'News · ' . $post->published_at?->format('d M Y'),
    'title'   => $post->title,
    'lead'    => $post->excerpt,
    'crumbs'  => [['label' => 'News', 'url' => route('news.index')], ['label' => $post->title]],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-3 gap-12 items-start">
        <article class="lg:col-span-2 reveal">
            <img src="{{ $post->image ?: '/images/placeholders/welcome.svg' }}" alt="{{ $post->title }}" class="w-full rounded-sm shadow-lg aspect-[16/9] object-cover" width="1600" height="900">
            <div class="mt-8 space-y-5 text-charcoal-700 leading-[1.8]">
                @foreach (preg_split('/\n\n+/', $post->body) as $para)
                <p>{{ $para }}</p>
                @endforeach
            </div>
        </article>

        <aside class="reveal">
            @if ($more->isNotEmpty())
            <div class="bg-white rounded-sm border border-beige-200 shadow-md p-7">
                <h2 class="font-display text-xl font-semibold text-maroon-900">More News</h2>
                <ul class="mt-4 divide-y divide-beige-100">
                    @foreach ($more as $m)
                    <li class="py-3">
                        <a href="{{ route('news.show', $m) }}" class="group block">
                            <span class="block text-xs text-gold-700 font-semibold">{{ $m->published_at?->format('d M Y') }}</span>
                            <span class="block mt-0.5 font-medium text-charcoal-800 group-hover:text-maroon-800 transition-colors">{{ $m->title }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('news.index') }}" data-track="see_all_click" data-label="news-page-see-all" class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-maroon-800 hover:text-maroon-600 transition-colors">
                    See all news
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
            @endif
        </aside>
    </div>
</section>

@endsection
