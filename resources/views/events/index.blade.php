@extends('layouts.site')

@section('title', 'Events at KVS | Knowledge Valley International School')
@section('description', 'Upcoming and past events at Knowledge Valley — open days, science fairs, book fairs, tournaments and celebrations.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'School Life',
    'title'   => 'Events at KVS',
    'lead'    => 'Open days, fairs, tournaments and celebrations — there is always something happening in the Valley.',
    'crumbs'  => [['label' => 'School Life', 'url' => route('school-life')], ['label' => 'Events']],
])

{{-- Upcoming --}}
<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="reveal">
            <p class="eyebrow">Mark Your Calendar</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule-left">Upcoming Events</h2>
        </div>
        @if ($upcoming->isEmpty())
        <div class="mt-12 reveal bg-white border border-beige-200 rounded-sm p-12 text-center">
            <p class="font-display text-xl text-maroon-900">No upcoming events right now</p>
            <p class="mt-2 text-charcoal-600 text-sm">Check back soon — or follow our news for announcements.</p>
            <a href="{{ route('news.index') }}" class="btn-maroon mt-6">Browse News</a>
        </div>
        @else
        <div class="mt-12 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($upcoming as $event)
                @include('partials.event-card', ['event' => $event])
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- Past --}}
@if ($past->isNotEmpty())
<section class="py-16 sm:py-24 bg-beige-100">
    <div class="container-site">
        <div class="reveal">
            <p class="eyebrow">Memories</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule-left">Past Events</h2>
        </div>
        <div class="mt-12 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($past as $event)
                @include('partials.event-card', ['event' => $event])
            @endforeach
        </div>
        @if ($past->hasPages())
        <div class="mt-10">{{ $past->links() }}</div>
        @endif
    </div>
</section>
@endif

@endsection
