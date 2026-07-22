@extends('layouts.app')

@section('title', 'Our Story & Philosophy — Knowledge Valley International School')
@section('meta_description', 'Since 2008, Knowledge Valley International School has combined a rigorous British curriculum with character-building — discover our story, vision, mission and values.')

@section('content')
@php $valleyImgs = ['/img/campus.jpg']; @endphp

@include('partials.page-hero', [
    'title' => 'Our Story & Philosophy',
    'subtitle' => 'Rooted in tradition, inspired by the future — the belief that has guided Knowledge Valley since 2008.',
    'crumbs' => [['About KVS', null]],
])

{{-- Story --}}
<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-2 gap-14 lg:gap-20 items-center">
        <div class="reveal">
            <p class="eyebrow">Our Story</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule-left">Education That Extends Far Beyond the Classroom</h2>
            <p class="mt-6 text-charcoal-600 leading-[1.75]">
                Knowledge Valley School was founded on the belief that education extends far beyond the classroom.
                It is about shaping individuals who think critically, act with integrity, and contribute positively
                to society.
            </p>
            <p class="mt-4 text-charcoal-600 leading-[1.75]">
                For years, KVS has cultivated a learning environment where academic achievement is complemented by
                character development, leadership, creativity, and global awareness. Every student is encouraged to
                discover their strengths, embrace challenges, and pursue excellence with confidence.
            </p>
            <p class="mt-4 text-charcoal-600 leading-[1.75]">
                As education continues to evolve, so does KVS. We honour our heritage while embracing innovation,
                ensuring that every learner is prepared not only for university, but for life.
            </p>
        </div>
        <div class="reveal relative">
            <div class="absolute -top-4 -right-4 w-full h-full border-2 border-gold-500/60 rounded-sm" aria-hidden="true"></div>
            <video data-welcome-video src="/videos/Homevideo.webm" poster="{{ $valleyImgs[0] ?? '/img/campus.jpg' }}" muted loop playsinline preload="none" aria-label="Life at Knowledge Valley International School" class="relative w-full aspect-[16/10] object-cover rounded-sm shadow-xl" width="1600" height="1000"></video>
        </div>
    </div>
</section>

{{-- Purpose quote band --}}
<section class="bg-maroon-900 text-ivory relative overflow-hidden">
    <div class="absolute -right-24 -top-24 w-[26rem] opacity-[0.05] pointer-events-none select-none" aria-hidden="true">
        <img src="/img/logo-mark.png" alt="" class="w-full h-auto">
    </div>
    <div class="relative container-site py-14 sm:py-16 text-center">
        <p class="eyebrow !text-gold-400">Our Purpose</p>
        <blockquote class="font-display text-2xl sm:text-3xl leading-snug max-w-3xl mx-auto mt-4">
            "To inspire every learner to achieve their highest potential through outstanding education,
            meaningful experiences, and strong values that last a lifetime."
        </blockquote>
    </div>
</section>

{{-- Vision & Mission --}}
<section class="py-20 sm:py-24 bg-beige-100">
    <div class="container-site grid md:grid-cols-2 gap-8">
        <div class="reveal bg-white rounded-sm shadow-md p-9 border-t-[3px] border-gold-500">
            <div class="w-12 h-12 rounded-sm bg-maroon-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-maroon-800" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h2 class="font-display text-2xl font-semibold text-maroon-900 mt-5">Our Vision</h2>
            <p class="mt-4 text-charcoal-600 leading-[1.75]">
                To be recognised as a leading British international school that nurtures knowledgeable, ethical,
                and future-ready leaders who positively shape their communities and the world around them.
            </p>
        </div>
        <div class="reveal bg-white rounded-sm shadow-md p-9 border-t-[3px] border-maroon-700">
            <div class="w-12 h-12 rounded-sm bg-gold-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-gold-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
            </div>
            <h2 class="font-display text-2xl font-semibold text-maroon-900 mt-5">Our Mission</h2>
            <p class="mt-4 text-charcoal-600 leading-[1.75]">
                To provide an exceptional British education that combines academic excellence, character development,
                innovation, and real-world learning within a supportive and inclusive community.
            </p>
        </div>
    </div>
</section>

{{-- Core Values --}}
<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">What We Stand For</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule">Our Core Values</h2>
        </div>
        <div class="mt-14 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $values = [
                    ['title' => 'Excellence', 'desc' => 'We pursue the highest standards in learning, teaching, leadership, and personal achievement.'],
                    ['title' => 'Integrity', 'desc' => 'We act with honesty, responsibility, respect, and accountability in everything we do.'],
                    ['title' => 'Respect', 'desc' => 'We value every individual and foster an inclusive environment built upon kindness, empathy, and mutual understanding.'],
                    ['title' => 'Innovation', 'desc' => 'We embrace curiosity, creativity, technology, and continuous improvement to prepare students for an ever-changing future.'],
                    ['title' => 'Community', 'desc' => 'We believe meaningful partnerships between students, parents, teachers, and the wider community create an environment where everyone can thrive.'],
                    ['title' => 'Growth', 'desc' => 'We encourage every learner to challenge themselves, discover their potential, and continue growing academically, socially, and personally.'],
                ];
            @endphp
            @foreach ($values as $v)
            <div class="reveal bg-white border border-beige-200 rounded-sm p-7 hover:shadow-lg transition-shadow duration-300">
                <h3 class="font-display text-xl font-semibold text-maroon-900 flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-gold-500 shrink-0" aria-hidden="true"></span>
                    {{ $v['title'] }}
                </h3>
                <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">{{ $v['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- The KVS Learner --}}
<section class="py-20 sm:py-24 bg-maroon-950 text-ivory relative overflow-hidden">
    <div class="relative container-site text-center">
        <p class="eyebrow !text-gold-400">The KVS Learner</p>
        <h2 class="font-display font-semibold text-3xl sm:text-4xl mt-3 gold-rule">Who Our Students Become</h2>
        <p class="mt-6 max-w-2xl mx-auto text-ivory/75">Built on the Cambridge Learner Attributes, every KVS student grows to be:</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            @foreach (['Confident', 'Responsible', 'Innovative', 'Reflective', 'Engaged'] as $attr)
            <span class="reveal px-7 py-3.5 rounded-full border border-gold-600/50 bg-maroon-900/70 font-display text-lg text-gold-300">{{ $attr }}</span>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta-band')

{{-- School video: muted autoplay only when scrolled into view (mobile + desktop) --}}
<script>
    (function () {
        var v = document.querySelector('[data-welcome-video]');
        if (!v) return;
        v.muted = true;
        if (!('IntersectionObserver' in window)) { v.play().catch(function () {}); return; }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting && e.intersectionRatio >= 0.4) {
                    var pr = v.play();
                    if (pr && pr.catch) { pr.catch(function () {}); }
                } else {
                    v.pause();
                }
            });
        }, { threshold: [0, 0.4, 0.6] });
        io.observe(v);
    })();
</script>
@endsection
