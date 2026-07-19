@extends('layouts.site')

@section('title', 'Admissions 2026/2027 — Now Open | Knowledge Valley International School')
@section('description', 'Joining KVS is simple: register your interest, visit the school, complete a friendly assessment, and welcome to the Valley. Admission for 2026/2027 is now open.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'Admissions 2026/2027 — Now Open',
    'title'   => 'Joining KVS is Simple',
    'lead'    => 'Four clear steps from your first call to your child\'s first day. Our admissions team guides you personally through each one.',
    'crumbs'  => [['label' => 'Admissions']],
])

{{-- Steps --}}
<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site">
        <ol class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-6">
            @php
                $steps = [
                    ['title' => 'Register Your Interest', 'desc' => 'Fill the short form — or call our admissions team directly on 0127 777 1119.'],
                    ['title' => 'Visit the School', 'desc' => 'Book a personal tour and see life at KVS with your own eyes.'],
                    ['title' => 'Student Assessment', 'desc' => 'A friendly age-appropriate assessment to place your child correctly.'],
                    ['title' => 'Welcome to the Valley', 'desc' => 'Complete the paperwork and your child\'s KVS journey begins.'],
                ];
            @endphp
            @foreach ($steps as $i => $step)
            <li class="reveal relative text-center px-2">
                @if ($i < 3)
                <div class="hidden lg:block absolute top-7 left-[calc(50%+2.5rem)] w-[calc(100%-5rem)] border-t-2 border-dashed border-gold-500/50" aria-hidden="true"></div>
                @endif
                <div class="mx-auto w-14 h-14 rounded-full bg-maroon-900 text-gold-400 font-display text-xl font-bold flex items-center justify-center shadow-md">{{ $i + 1 }}</div>
                <h2 class="font-semibold text-lg text-maroon-900 mt-5">{{ $step['title'] }}</h2>
                <p class="mt-2 text-sm text-charcoal-600 leading-relaxed">{{ $step['desc'] }}</p>
            </li>
            @endforeach
        </ol>

        <div class="mt-14 flex flex-col sm:flex-row items-center justify-center gap-4 reveal">
            <a href="{{ route('book-tour') }}" data-track="cta_click" data-label="admissions-book-tour" class="btn-gold w-full sm:w-auto">Book a School Tour</a>
            <a href="{{ route('admissions.apply') }}" data-track="cta_click" data-label="admissions-how-to-apply" class="btn-maroon w-full sm:w-auto">How to Apply</a>
        </div>
    </div>
</section>

{{-- Quick links --}}
<section class="py-16 sm:py-20 bg-beige-100">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">Everything You Need</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule">Explore Admissions</h2>
        </div>
        <div class="mt-12 grid sm:grid-cols-3 gap-6">
            @php
                $links = [
                    ['route' => 'admissions.apply', 'title' => 'How to Apply', 'desc' => 'Required documents, assessment details and timelines — step by step.'],
                    ['route' => 'admissions.fees',  'title' => 'Tuition & Fees', 'desc' => 'Transparent fee structure by stage, plus payment methods on our smart campus.'],
                    ['route' => 'admissions.faq',   'title' => 'FAQs', 'desc' => 'Quick answers to the questions parents ask us most.'],
                ];
            @endphp
            @foreach ($links as $link)
            <a href="{{ route($link['route']) }}" data-track="see_all_click" data-label="admissions-{{ $link['title'] }}" class="reveal group bg-white rounded-sm border border-beige-200 shadow-md hover:shadow-xl transition-shadow p-8 block">
                <h3 class="font-display text-2xl font-semibold text-maroon-900 group-hover:text-maroon-700 transition-colors">{{ $link['title'] }}</h3>
                <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">{{ $link['desc'] }}</p>
                <span class="inline-flex items-center gap-2 mt-5 text-sm font-semibold text-gold-700">
                    Learn more
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                </span>
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
