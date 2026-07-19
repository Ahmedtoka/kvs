@extends('layouts.site')

@section('title', 'The KVS Model — Our Educational Framework | Knowledge Valley')
@section('description', 'Six pillars working together: British academic excellence, Cambridge Learner Attributes, Egypt Vision 2030, OECD Learning Compass, UN Global Goals and digital learning.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'Our Educational Framework',
    'title'   => 'The KVS Model',
    'lead'    => 'A student development framework no other school in Egypt offers — six pillars working together to shape confident, responsible, innovative, reflective and engaged learners.',
    'crumbs'  => [['label' => 'About KVS', 'url' => route('about')], ['label' => 'The KVS Model']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site space-y-14">
        @php
            $pillars = [
                ['title' => 'Academic Excellence', 'desc' => 'A rigorous British curriculum delivered by exceptional teachers, with the highest standards in learning and achievement. Continuous assessment, small-group support and enrichment ensure every learner is stretched and supported.', 'icon' => 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5'],
                ['title' => 'Cambridge Learner Attributes', 'desc' => 'Nurturing learners who are confident, responsible, innovative, reflective and engaged — in class and in life. These five attributes are woven into lessons, assemblies, clubs and even how we praise and guide behaviour.', 'icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z'],
                ['title' => 'Egypt Vision 2030', 'desc' => 'Education aligned with our national development goals — raising a generation ready to build the future of Egypt with skills, values and belonging.', 'icon' => 'M3 21v-4.875C3 15.504 3.504 15 4.125 15h4.5c.621 0 1.125.504 1.125 1.125V21m-6.75 0h16.5M3.75 21H21m-9-13.5V3.545M12 3.545c1.05-.315 2.163-.484 3.31-.484 1.147 0 2.26.169 3.31.484M12 3.545c-1.05-.315-2.163-.484-3.31-.484-1.147 0-2.26.169-3.31.484m13.24 0v5.16c-1.05.315-2.163.485-3.31.485-1.147 0-2.26-.17-3.31-.485m6.62-5.16v5.16m-13.24-5.16v5.16c1.05.315 2.163.485 3.31.485 1.147 0 2.26-.17 3.31-.485m-6.62-5.16v5.16m6.62 0V21'],
                ['title' => 'OECD Learning Compass 2030', 'desc' => 'A global framework guiding our students toward the knowledge, skills, attitudes and values of tomorrow — including student agency, well-being and transformative competencies.', 'icon' => 'M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z'],
                ['title' => 'UN Global Goals', 'desc' => 'Part of the UN Global Schools Program — all 17 Sustainable Development Goals woven into everyday learning, projects and school events like International Peace Day.', 'icon' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418'],
                ['title' => 'Digital Learning', 'desc' => 'Technology integrated across the curriculum — and a fully cashless smart campus (SPARE & Kashier) that parents manage from their phones.', 'icon' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25'],
            ];
        @endphp

        <div class="grid sm:grid-cols-2 gap-8">
            @foreach ($pillars as $i => $pillar)
            <div class="reveal bg-white border border-beige-200 rounded-sm p-8 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-start gap-5">
                    <div class="shrink-0 w-14 h-14 rounded-sm bg-maroon-900 flex items-center justify-center">
                        <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $pillar['icon'] }}"/></svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gold-700 tracking-widest">PILLAR {{ sprintf('%02d', $i + 1) }}</span>
                        <h2 class="font-display text-2xl font-semibold text-maroon-900 mt-1">{{ $pillar['title'] }}</h2>
                    </div>
                </div>
                <p class="mt-5 text-charcoal-600 leading-relaxed">{{ $pillar['desc'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="reveal text-center">
            <a href="{{ route('academics') }}" data-track="cta_click" data-label="kvs-model-academics" class="btn-maroon">See the Model in Action — Our Academics</a>
        </div>
    </div>
</section>

@endsection
