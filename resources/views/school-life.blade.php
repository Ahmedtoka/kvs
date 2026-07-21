@extends('layouts.app')

@section('title', 'School Life — Events & Gallery at Knowledge Valley International School')
@section('meta_description', 'Life at KVS: science fairs, book fairs, art exhibitions, chess academy, graduation ceremonies, charity initiatives and more — see our events and gallery.')

@section('content')
@php $lifeImgs = []; @endphp

@include('partials.page-hero', [
    'title' => 'Life at KVS',
    'subtitle' => 'Learning extends beyond textbooks — leadership, arts, competitions, service and celebrations that enrich every student\'s journey.',
    'crumbs' => [['School Life', null]],
])

{{-- Events grid --}}
<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">Events & Gallery</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule">A Year in the Valley</h2>
        </div>

        <div class="mt-14 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                /* Each event's photo is auto-loaded from public/img/ */
                $events = [
                    ['folder' => '/img/event-science-fair.jpg', 'title' => 'KVS Science Fair', 'desc' => 'Student-led experiments and projects presented to parents and judges.'],
                    ['folder' => '/img/event-graduation-2026.jpg', 'title' => 'Graduation 2026', 'desc' => 'Celebrating our graduates and the journey that brought them here.'],
                    ['folder' => '/img/event-art-exhibition-2026.jpg', 'title' => 'Art Exhibition 2026', 'desc' => 'A gallery of student creativity — painting, sculpture and design.'],
                    ['folder' => '/img/event-senior-walk-2026.jpg', 'title' => 'Senior Walk 2026', 'desc' => 'A cherished tradition as our senior students mark their final chapter.'],
                    ['folder' => '/img/event-6th-october-celebration.jpg', 'title' => '6th of October Celebration', 'desc' => 'Honouring a proud national day with remembrance and school spirit.'],
                    ['folder' => '/img/event-international-peace-day.jpg', 'title' => 'International Peace Day', 'desc' => 'A whole-school celebration of tolerance and global citizenship.'],
                    ['folder' => '/img/event-end-of-year-performance-2026.jpg', 'title' => 'End of Year Performance 2026', 'desc' => 'Music, drama and dance — the stage belongs to our students.'],
                    ['folder' => '/img/event-back-to-school-2026.jpg', 'title' => 'Back to School 2026', 'desc' => 'Welcoming our families into a new academic year together.'],
                    ['folder' => '/img/event-french-institute-delf.jpg', 'title' => 'French Institute Delf Certificates', 'desc' => 'Students earn internationally recognised DELF certificates in partnership with the Institut Français.'],
                ];
            @endphp
            @foreach ($events as $event)
            <article class="reveal group bg-white rounded-sm shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-beige-200">
                <div class="relative overflow-hidden">
                    <img src="{{ $event['folder'] }}" alt="{{ $event['title'] }}" class="w-full aspect-[4/3] object-cover transition-transform duration-500 group-hover:scale-[1.04]" width="1600" height="1200" loading="lazy">
                </div>
                <div class="p-6">
                    <h3 class="font-display text-xl font-semibold text-maroon-900">{{ $event['title'] }}</h3>
                    <p class="mt-2 text-sm text-charcoal-600 leading-relaxed">{{ $event['desc'] }}</p>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Beyond the classroom --}}
<section class="py-20 sm:py-24 bg-maroon-950 text-ivory relative overflow-hidden">
    <div class="relative container-site text-center">
        <p class="eyebrow !text-gold-400">Beyond the Classroom</p>
        <h2 class="font-display font-semibold text-3xl sm:text-4xl mt-3 gold-rule">Where Character is Built</h2>
        <p class="mt-6 max-w-2xl mx-auto text-ivory/75 leading-relaxed">
            Leadership opportunities, competitions, educational trips, service initiatives and clubs —
            because who our students become matters as much as what they know.
        </p>
        <div class="mt-10 flex flex-wrap justify-center gap-3">
            @foreach (['Student Leadership', 'Science & Innovation', 'Arts & Performance', 'Sports & Wellbeing', 'Community Service', 'Educational Trips', 'Competitions', 'Reading Culture'] as $tag)
            <span class="reveal px-5 py-2.5 rounded-full border border-gold-600/50 bg-maroon-900/70 text-sm text-gold-300">{{ $tag }}</span>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta-band')

@endsection
