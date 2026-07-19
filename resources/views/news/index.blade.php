@extends('layouts.site')

@section('title', 'News from KVS | Knowledge Valley International School')
@section('description', 'The latest news and announcements from Knowledge Valley International School.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'School Life',
    'title'   => 'News from the Valley',
    'lead'    => 'Announcements, achievements and stories from the KVS community.',
    'crumbs'  => [['label' => 'School Life', 'url' => route('school-life')], ['label' => 'News']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site">
        @if ($posts->isEmpty())
        <div class="reveal bg-white border border-beige-200 rounded-sm p-12 text-center">
            <p class="font-display text-xl text-maroon-900">No news published yet</p>
            <p class="mt-2 text-charcoal-600 text-sm">Announcements will appear here.</p>
        </div>
        @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($posts as $post)
                @include('partials.news-card', ['post' => $post])
            @endforeach
        </div>
        @if ($posts->hasPages())
        <div class="mt-10">{{ $posts->links() }}</div>
        @endif
        @endif
    </div>
</section>

@endsection
