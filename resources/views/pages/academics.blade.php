@extends('layouts.site')

@section('title', 'Academics — British Curriculum from Early Years to IGCSE | KVS')
@section('description', 'A seamless British curriculum journey at KVS — EYFS Early Years, Cambridge Primary, and Secondary with Cambridge, Edexcel and Oxford AQA IGCSE pathways.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'Academics',
    'title'   => "Find Your Child's Place at KVS",
    'lead'    => 'A seamless British curriculum journey — from first steps in Early Years to Cambridge, Edexcel and Oxford AQA qualifications in Secondary.',
    'crumbs'  => [['label' => 'Academics']],
])

{{-- Stages --}}
<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="grid md:grid-cols-3 gap-8">
            @php
                $stages = [
                    ['route' => 'academics.early',     'img' => 'stage-early',     'badge' => 'FS1 – FS2 · Ages 3–5',        'title' => 'Early Years',       'desc' => 'A warm, nurturing start built on the EYFS framework — where curiosity, confidence and a love of learning take root.'],
                    ['route' => 'academics.primary',   'img' => 'stage-primary',   'badge' => 'Years 1 – 6 · Ages 5–11',      'title' => 'Primary',           'desc' => 'Strong academic foundations in English, Maths and Science — enriched by languages, arts, and the Cambridge Learner Attributes.'],
                    ['route' => 'academics.secondary', 'img' => 'stage-secondary', 'badge' => 'Years 7+ · IGCSE Pathway',     'title' => 'Secondary & IGCSE', 'desc' => 'Rigorous preparation for Cambridge, Pearson Edexcel and Oxford AQA qualifications — the gateway to leading universities.'],
                ];
            @endphp
            @foreach ($stages as $s)
            <article class="reveal group bg-white rounded-sm shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-beige-200">
                <a href="{{ route($s['route']) }}" class="block overflow-hidden">
                    <img src="/images/placeholders/{{ $s['img'] }}.svg" alt="{{ $s['title'] }} at KVS" class="w-full aspect-[16/10] object-cover transition-transform duration-500 group-hover:scale-[1.03]" width="1600" height="1000" loading="lazy">
                </a>
                <div class="p-7">
                    <span class="inline-block text-xs font-semibold bg-gold-100 text-gold-800 px-3 py-1 rounded-full">{{ $s['badge'] }}</span>
                    <h2 class="font-display text-2xl font-semibold text-maroon-900 mt-4">{{ $s['title'] }}</h2>
                    <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">{{ $s['desc'] }}</p>
                    <a href="{{ route($s['route']) }}" data-track="see_all_click" data-label="academics-{{ $s['img'] }}" class="inline-flex items-center gap-2 mt-5 text-sm font-semibold text-maroon-800 hover:text-maroon-600 transition-colors">
                        Explore {{ $s['title'] }}
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Languages strip --}}
<section class="py-16 sm:py-20 bg-maroon-950 text-ivory relative overflow-hidden">
    <div class="absolute -left-32 -bottom-24 w-[28rem] opacity-[0.05] pointer-events-none select-none" aria-hidden="true">
        <img src="/images/logo-mark.png" alt="" class="w-full h-auto">
    </div>
    <div class="relative container-site flex flex-col lg:flex-row items-center justify-between gap-8">
        <div>
            <p class="eyebrow !text-gold-400">Three Languages, Officially Certified</p>
            <h2 class="font-display font-semibold text-2xl sm:text-3xl mt-2">English · German with Goethe-Institut · French with Institut Français</h2>
        </div>
        <a href="{{ route('academics.languages') }}" data-track="see_all_click" data-label="academics-languages" class="btn-gold shrink-0">Explore the Languages Programme</a>
    </div>
</section>

{{-- Examinations --}}
<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">Qualifications</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule">Three Examination Boards, One Standard: Excellence</h2>
            <p class="mt-6 text-charcoal-600 leading-relaxed">
                KVS students sit internationally recognized examinations with Cambridge, Pearson Edexcel and
                Oxford International AQA — flexibility that lets each student play to their strengths.
            </p>
        </div>
        @include('partials.accreditation-logos', ['compact' => true])
    </div>
</section>

@endsection
