@extends('layouts.app')

@section('title', 'The British Curriculum at KVS — Academics')
@section('meta_description', 'Explore the KVS academic journey: EYFS Early Years, British Primary, and Secondary through to IGCSE with Cambridge, Pearson Edexcel and Oxford International AQA.')

@section('content')
@php $stageImgs = array_merge(kvs_images("Find Your Child's Place at KVS"), kvs_images('find your child place')); @endphp

@include('partials.page-hero', [
    'title' => 'The British Curriculum at KVS',
    'subtitle' => 'One seamless journey — from a child\'s first day in Early Years to internationally certified IGCSE qualifications.',
    'crumbs' => [['Academics', null]],
])

{{-- Journey --}}
<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">The Journey</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule">Your Child's Path Through KVS</h2>
        </div>

        <div class="mt-14 grid md:grid-cols-3 gap-8">
            @php
                $stages = [
                    ['img' => 'stage-early', 'chip' => 'FS1 – FS2 · Ages 3–5', 'title' => 'Early Years', 'href' => '/academics/early-years',
                     'desc' => 'The British EYFS framework — learning through play, phonics, early numeracy, and the social confidence that sets the tone for everything after.'],
                    ['img' => 'stage-primary', 'chip' => 'Years 1 – 6 · Ages 5–11', 'title' => 'Primary', 'href' => '/academics/primary',
                     'desc' => 'English, Maths and Science built on the National Curriculum of England, enriched by German, French, arts, PE and the Cambridge Learner Attributes.'],
                    ['img' => 'stage-secondary', 'chip' => 'Years 7+ · IGCSE Pathway', 'title' => 'Secondary & IGCSE', 'href' => '/academics/secondary',
                     'desc' => 'Key Stage 3 foundations leading to IGCSE examinations with Cambridge, Pearson Edexcel and Oxford International AQA.'],
                ];
            @endphp
            @foreach ($stages as $stage)
            <article class="reveal group bg-white rounded-sm shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-beige-200">
                <div class="overflow-hidden">
                    <img src="{{ $stageImgs[$loop->index] ?? '/images/placeholders/'.$stage['img'].'.svg' }}" alt="{{ $stage['title'] }} at KVS" class="w-full aspect-[16/10] object-cover transition-transform duration-500 group-hover:scale-[1.03]" width="1600" height="1000" loading="lazy">
                </div>
                <div class="p-7">
                    <span class="inline-block text-xs font-semibold bg-gold-100 text-gold-800 px-3 py-1 rounded-full">{{ $stage['chip'] }}</span>
                    <h3 class="font-display text-2xl font-semibold text-maroon-900 mt-4">{{ $stage['title'] }}</h3>
                    <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">{{ $stage['desc'] }}</p>
                    <a href="{{ $stage['href'] }}" class="inline-flex items-center gap-2 mt-5 text-sm font-semibold text-maroon-800 hover:text-maroon-600 transition-colors">
                        Explore {{ $stage['title'] }}
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Languages --}}
<section class="py-20 sm:py-24 bg-maroon-950 text-ivory relative overflow-hidden">
    <div class="absolute -left-32 -bottom-32 w-[30rem] opacity-[0.05] pointer-events-none select-none" aria-hidden="true">
        <img src="/images/logo-mark.png" alt="" class="w-full h-auto">
    </div>
    <div class="relative container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow !text-gold-400">A Rare Advantage</p>
            <h2 class="font-display font-semibold text-3xl sm:text-4xl mt-3 gold-rule">Three Languages, Officially Certified</h2>
            <p class="mt-6 text-ivory/75 leading-relaxed">
                Few schools in Egypt offer even one certified foreign-language partnership. KVS offers two —
                on top of full English-medium British education.
            </p>
        </div>
        <div class="mt-12 grid sm:grid-cols-3 gap-6">
            @php
                $langs = [
                    ['lang' => 'English', 'partner' => 'Medium of Instruction', 'desc' => 'The language of every classroom — reading, writing, reasoning and presenting to a British curriculum standard.'],
                    ['lang' => 'German', 'partner' => 'with Goethe-Institut', 'desc' => 'Internationally certified German levels delivered in partnership with the Goethe-Institut.'],
                    ['lang' => 'French', 'partner' => 'with Institut Français', 'desc' => 'Official French pathway in partnership with the Institut Français d\'Égypte.'],
                ];
            @endphp
            @foreach ($langs as $l)
            <div class="reveal bg-maroon-900/70 border border-gold-700/25 rounded-sm p-8 text-center">
                <p class="font-display text-3xl font-bold text-gold-400">{{ $l['lang'] }}</p>
                <p class="text-xs tracking-widest uppercase text-ivory/60 mt-2">{{ $l['partner'] }}</p>
                <p class="mt-4 text-sm text-ivory/75 leading-relaxed">{{ $l['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Learner profile --}}
<section class="py-20 sm:py-24 bg-beige-100">
    <div class="container-site grid lg:grid-cols-2 gap-14 items-center">
        <div class="reveal">
            <p class="eyebrow">The Outcome</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule-left">The KVS Learner</h2>
            <p class="mt-6 text-charcoal-600 leading-[1.75]">
                Academic results matter — and ours speak through the universities our graduates reach. But the KVS
                education model, built on four pillars from the Cambridge Learner Attributes to the UN Global Goals,
                measures success by who our students become:
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                @foreach (['Confident', 'Responsible', 'Innovative', 'Reflective', 'Engaged'] as $attr)
                <span class="px-5 py-2.5 rounded-full bg-white border border-gold-500/50 font-display text-maroon-900">{{ $attr }}</span>
                @endforeach
            </div>
            <a href="/about" class="inline-flex items-center gap-2 mt-8 font-semibold text-maroon-800 hover:text-maroon-600 transition-colors group">
                Learn about the KVS Model
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
        <div class="reveal relative">
            <div class="absolute -top-4 -left-4 w-full h-full border-2 border-gold-500/60 rounded-sm" aria-hidden="true"></div>
            <img src="{{ $stageImgs[1] ?? '/images/placeholders/stage-primary.svg' }}" alt="KVS students in class" class="relative w-full rounded-sm shadow-xl" width="1600" height="1000" loading="lazy">
        </div>
    </div>
</section>

@include('partials.cta-band')

@endsection
