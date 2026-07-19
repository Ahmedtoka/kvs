@extends('layouts.site')

@section('title', 'About KVS — Our Story | Knowledge Valley International School')
@section('description', 'Since 2008, Knowledge Valley has been a valley of character-building — a British international school in Giza shaping confident, responsible, future-ready learners.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'About Knowledge Valley',
    'title'   => 'A Valley of Character-Building',
    'lead'    => 'Since 2008, KVS has balanced rigorous British academics with leadership, creativity and global awareness — shaping individuals who think critically, act with integrity, and contribute positively to society.',
    'crumbs'  => [['label' => 'About KVS']],
])

{{-- Story --}}
<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-2 gap-14 items-center">
        <div class="reveal">
            <p class="eyebrow">Our Story</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule-left">Rooted in Tradition. Inspired by the Future.</h2>
            <p class="mt-6 text-charcoal-600 leading-[1.75]">
                Knowledge Valley International School was founded in 2008 on a simple belief: education extends far
                beyond the classroom. From our campus in Giza, we deliver a top-tier British curriculum journey —
                from first steps in Early Years to Cambridge, Pearson Edexcel and Oxford AQA qualifications in Secondary.
            </p>
            <p class="mt-4 text-charcoal-600 leading-[1.75]">
                Every student is encouraged to discover their strengths, embrace challenges, and pursue excellence
                with confidence — prepared not only for university, but for life.
            </p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('about.model') }}" data-track="cta_click" data-label="about-kvs-model" class="btn-maroon">Explore the KVS Model</a>
                <a href="{{ route('about.leadership') }}" class="inline-flex items-center gap-2 font-semibold text-maroon-800 hover:text-maroon-600 transition-colors self-center">
                    Leadership messages
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
        <div class="reveal relative">
            <div class="absolute -top-4 -left-4 w-full h-full border-2 border-gold-500/60 rounded-sm" aria-hidden="true"></div>
            <img src="/images/placeholders/about-main.svg" alt="The KVS campus" class="relative w-full rounded-sm shadow-xl" width="1600" height="1000">
            <div class="absolute -bottom-6 right-6 bg-maroon-900 text-ivory px-6 py-4 rounded-sm shadow-lg">
                <span class="block font-display text-2xl font-bold text-gold-400">Since 2008</span>
                <span class="block text-xs tracking-widest uppercase text-ivory/70">Excellence in Education</span>
            </div>
        </div>
    </div>
</section>

{{-- Mission / Vision / Values --}}
<section class="py-16 sm:py-24 bg-beige-100">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">What Drives Us</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule">Mission, Vision &amp; Values</h2>
        </div>
        <div class="mt-14 grid md:grid-cols-3 gap-8">
            @php
                $mvv = [
                    ['title' => 'Our Mission', 'desc' => 'To deliver a world-class British education that builds strong character, academic excellence and lifelong curiosity — in a safe, nurturing environment.'],
                    ['title' => 'Our Vision', 'desc' => 'To be Egypt\'s leading valley of character-building — graduating confident, responsible, innovative, reflective and engaged global citizens.'],
                    ['title' => 'Our Values', 'desc' => 'Integrity, respect and responsibility shape every classroom and corridor. Character comes before everything.'],
                ];
            @endphp
            @foreach ($mvv as $item)
            <div class="reveal bg-white rounded-sm shadow-md p-8 border-t-[3px] border-gold-500">
                <h3 class="font-display text-2xl font-semibold text-maroon-900">{{ $item['title'] }}</h3>
                <p class="mt-4 text-charcoal-600 leading-relaxed">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Accreditation strip --}}
<section class="py-16 sm:py-20 bg-ivory">
    <div class="container-site">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 reveal">
            <div>
                <p class="eyebrow">Trusted &amp; Accredited</p>
                <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule-left">Our Accreditations</h2>
            </div>
            <a href="{{ route('about.accreditations') }}" data-track="see_all_click" data-label="about-accreditations" class="inline-flex items-center gap-2 font-semibold text-maroon-800 hover:text-maroon-600 transition-colors shrink-0 group">
                See all accreditations
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
        @include('partials.accreditation-logos', ['compact' => true])
    </div>
</section>

@endsection
