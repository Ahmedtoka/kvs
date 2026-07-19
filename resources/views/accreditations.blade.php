@extends('layouts.app')

@section('title', 'Accreditations & Partners — Knowledge Valley International School')
@section('meta_description', 'KVS is accredited by the University of Cambridge, Pearson Edexcel, Oxford International AQA and the British Council, with certified language partnerships with Goethe-Institut and Institut Français.')

@section('content')

@include('partials.page-hero', [
    'title' => 'Accreditations & Partners',
    'subtitle' => 'Your guarantee of a genuine, internationally recognised British education.',
    'crumbs' => [['About KVS', '/about'], ['Accreditations', null]],
])

<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="max-w-3xl reveal">
            <p class="eyebrow">Why It Matters</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule-left">Accredited at Every Level</h2>
            <p class="mt-6 text-charcoal-600 leading-[1.75]">
                Accreditation is the difference between a school that <em>says</em> it delivers a British education
                and one that is officially examined, audited and certified to deliver it. KVS students sit
                internationally recognised examinations, and every certificate they earn is accepted by
                universities in Egypt and around the world.
            </p>
        </div>

        <div class="mt-14 grid md:grid-cols-2 gap-8">
            @php
                $accreditations = [
                    ['name' => 'University of Cambridge', 'type' => 'Academic Accreditation', 'desc' => 'Cambridge International qualifications and the Cambridge Learner Attributes framework — the world\'s most recognised British curriculum pathway.'],
                    ['name' => 'Pearson Edexcel', 'type' => 'Academic Accreditation', 'desc' => 'An approved Pearson Edexcel centre, offering internationally examined qualifications through to International GCSE.'],
                    ['name' => 'Oxford International AQA', 'type' => 'Academic Accreditation', 'desc' => 'Approved to deliver Oxford International AQA examinations — bringing the rigour of the UK\'s leading exam board to our students.'],
                    ['name' => 'British Council', 'type' => 'Partnership', 'desc' => 'Partnership with the British Council — supporting international education standards and global learning programmes.'],
                    ['name' => 'Goethe-Institut', 'type' => 'Language Partnership — German', 'desc' => 'Our German language programme is delivered in partnership with the Goethe-Institut, with internationally certified levels.'],
                    ['name' => 'Institut Français d\'Égypte', 'type' => 'Language Partnership — French', 'desc' => 'French at KVS is certified through the Institut Français — official DELF-track learning from an early age.'],
                ];
            @endphp
            @foreach ($accreditations as $acc)
            <article class="reveal bg-white border border-beige-200 rounded-sm p-8 hover:shadow-lg transition-shadow duration-300 flex gap-6">
                <div class="shrink-0 w-14 h-14 rounded-sm bg-maroon-900 flex items-center justify-center">
                    <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-wider uppercase text-gold-700">{{ $acc['type'] }}</p>
                    <h3 class="font-display text-xl font-semibold text-maroon-900 mt-1.5">{{ $acc['name'] }}</h3>
                    <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">{{ $acc['desc'] }}</p>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-16 bg-beige-100 rounded-sm p-8 sm:p-10 reveal">
            <div class="flex flex-col sm:flex-row items-start gap-6">
                <div class="shrink-0 w-12 h-12 rounded-sm bg-gold-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gold-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582"/></svg>
                </div>
                <div>
                    <h3 class="font-display text-xl font-semibold text-maroon-900">UN Global Schools Program</h3>
                    <p class="mt-3 text-sm text-charcoal-600 leading-relaxed max-w-3xl">
                        KVS is a member of the UN Global Schools Program — all 17 Sustainable Development Goals are
                        woven into everyday learning, alongside alignment with Egypt Vision 2030 and the OECD
                        Learning Compass 2030.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.cta-band')

@endsection
