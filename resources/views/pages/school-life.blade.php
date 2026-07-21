@extends('layouts.site')

@section('title', 'School Life at KVS — Activities, Clubs & Facilities | Knowledge Valley')
@section('description', 'Life at KVS: science fairs, book fairs, chess academy, art, sports, charity initiatives and a vibrant campus — all year round.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'School Life',
    'title'   => 'Life at KVS',
    'lead'    => 'Learning at KVS extends far beyond the classroom — science fairs, book fairs, chess, art, sports and charity initiatives fill the school year.',
    'crumbs'  => [['label' => 'School Life']],
])

{{-- Activities --}}
<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">Beyond the Classroom</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule">A Year Full of Life</h2>
        </div>
        <div class="mt-14 grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $activities = [
                    ['title' => 'KVS Science Fair', 'desc' => 'Students research, build and present — from renewable energy models to robotics demos.', 'img' => 'g-science-fair'],
                    ['title' => 'Book Fair & Reading Culture', 'desc' => 'A week-long celebration of reading in four languages, with author talks and storytelling.', 'img' => 'g-book-fair'],
                    ['title' => 'Chess Academy', 'desc' => 'Strategic thinking through our in-house chess academy and inter-house tournaments.', 'img' => 'g-chess'],
                    ['title' => 'Art & Performance', 'desc' => 'Exhibitions, school performances and music — creativity is celebrated all year.', 'img' => 'g-art'],
                    ['title' => 'Charity & Service', 'desc' => 'Student-led charity initiatives linked to the UN Global Goals build empathy and citizenship.', 'img' => 'g-peace-day'],
                    ['title' => 'Celebrations & Milestones', 'desc' => 'From International Peace Day to graduation — moments that bind the KVS family.', 'img' => 'g-graduation'],
                ];
            @endphp
            @foreach ($activities as $act)
            <article class="reveal group bg-white rounded-sm shadow-md hover:shadow-xl transition-shadow overflow-hidden border border-beige-200">
                <div class="overflow-hidden">
                    <img src="/img/{{ $act['img'] }}.svg" alt="{{ $act['title'] }}" class="w-full aspect-[16/10] object-cover transition-transform duration-500 group-hover:scale-[1.03]" width="1600" height="1000" loading="lazy">
                </div>
                <div class="p-6">
                    <h3 class="font-display text-xl font-semibold text-maroon-900">{{ $act['title'] }}</h3>
                    <p class="mt-2.5 text-sm text-charcoal-600 leading-relaxed">{{ $act['desc'] }}</p>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-4 reveal">
            <a href="{{ route('events.index') }}" data-track="see_all_click" data-label="school-life-events" class="btn-maroon w-full sm:w-auto">See All Events</a>
            <a href="{{ route('gallery') }}" data-track="see_all_click" data-label="school-life-gallery" class="btn-gold w-full sm:w-auto">Browse the Gallery</a>
        </div>
    </div>
</section>

{{-- Facilities --}}
<section class="py-16 sm:py-24 bg-beige-100">
    <div class="container-site">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 reveal">
            <div>
                <p class="eyebrow">Our Campus</p>
                <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule-left">Facilities Built for Learning</h2>
            </div>
            <a href="{{ route('school-life.smart') }}" data-track="see_all_click" data-label="school-life-smart-campus" class="inline-flex items-center gap-2 font-semibold text-maroon-800 hover:text-maroon-600 transition-colors shrink-0 group">
                Discover our smart campus
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
        <div class="mt-12 grid grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-5">
            @php
                $facilities = [
                    ['img' => 'c-science-lab',   'label' => 'Science Labs'],
                    ['img' => 'c-library',       'label' => 'Library'],
                    ['img' => 'c-art-room',      'label' => 'Art Rooms'],
                    ['img' => 'c-classroom',     'label' => 'Smart Classrooms'],
                    ['img' => 'c-computer-lab',  'label' => 'Computer Labs'],
                    ['img' => 'c-playground',    'label' => 'Playgrounds'],
                    ['img' => 'c-sports',        'label' => 'Sports Facilities'],
                    ['img' => 'c-theatre',       'label' => 'Theatre'],
                    ['img' => 'c-cafeteria',     'label' => 'Cafeteria'],
                ];
            @endphp
            @foreach ($facilities as $f)
            <figure class="reveal group relative rounded-sm overflow-hidden">
                <img src="/img/{{ $f['img'] }}.svg" alt="{{ $f['label'] }} at KVS" class="w-full aspect-square object-cover transition-transform duration-500 group-hover:scale-[1.05]" width="800" height="800" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-maroon-950/85 via-maroon-950/10 to-transparent"></div>
                <figcaption class="absolute bottom-0 inset-x-0 p-3.5 text-ivory font-display font-semibold text-sm">{{ $f['label'] }}</figcaption>
            </figure>
            @endforeach
        </div>
    </div>
</section>

@endsection
