@extends('layouts.app')

@section('title', 'How to Apply — Admissions at Knowledge Valley International School')
@section('meta_description', 'Admission to KVS is now open. See the four simple steps, required documents, age placement guide and transfer notes — then book your school tour.')

@section('content')

@include('partials.page-hero', [
    'title' => 'How to Apply',
    'subtitle' => 'Admission for the 2026/2027 academic year is now open. Four simple steps — and we guide you through every one.',
    'crumbs' => [['Admissions', null]],
])

{{-- Steps --}}
<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site">
        <ol class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-6">
            @php
                $steps = [
                    ['title' => 'Register Your Interest', 'desc' => 'Call us, message us on WhatsApp, or fill the Book-a-Tour form. Our admissions team responds within 24 hours.'],
                    ['title' => 'Visit the School', 'desc' => 'A personal tour of our campus — classrooms, facilities, and a chance to ask everything face to face.'],
                    ['title' => 'Student Assessment', 'desc' => 'A friendly, age-appropriate assessment to place your child in the right year group.'],
                    ['title' => 'Complete Enrolment', 'desc' => 'Submit the documents, finalise the paperwork, and welcome to the Valley.'],
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
        <div class="mt-14 text-center reveal">
            <a href="/book-a-tour" class="btn-gold">Start with a School Tour</a>
        </div>
    </div>
</section>

{{-- Documents + Age guide --}}
<section class="py-20 sm:py-24 bg-beige-100">
    <div class="container-site grid lg:grid-cols-2 gap-10 items-start">
        <div class="reveal bg-white rounded-sm shadow-md p-8 sm:p-9">
            <h2 class="font-display text-2xl font-semibold text-maroon-900">Required Documents</h2>
            <ul class="mt-6 space-y-4">
                @php $admissions_list0 = [
                    'Copy of both parents\' national ID',
                    'Pupil\'s passport (for international students)',
                    'Most recent school report from the previous school',
                    '6 personal photos of the pupil',
                    'Birth certificate (original for review + copy)',
                ]; @endphp
                @foreach ($admissions_list0 as $doc)
                <li class="flex gap-3">
                    <svg class="w-5 h-5 mt-0.5 shrink-0 text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-charcoal-700">{{ $doc }}</span>
                </li>
                @endforeach
            </ul>
            <div class="mt-8 bg-beige-100 rounded-sm p-5 text-sm text-charcoal-600 leading-relaxed">
                <p class="font-semibold text-maroon-900 mb-1.5">Transferring from another school?</p>
                <p>Transfers from Egyptian and international schools are welcome. Additional transfer paperwork applies
                depending on your current school system — our admissions team will walk you through it step by step.</p>
            </div>
        </div>

        <div class="reveal bg-white rounded-sm shadow-md p-8 sm:p-9">
            <h2 class="font-display text-2xl font-semibold text-maroon-900">Age Placement Guide</h2>
            <p class="mt-2 text-sm text-charcoal-600">Your child's age on October 1st determines their year group.</p>
            <div class="mt-6 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-maroon-900 text-ivory">
                            <th class="text-left font-semibold px-4 py-3">Year Group</th>
                            <th class="text-left font-semibold px-4 py-3">Age</th>
                            <th class="text-left font-semibold px-4 py-3">Stage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-beige-200">
                        @php $admissions_list1 = [
                            ['FS1', '3 – 4', 'Early Years'], ['FS2', '4 – 5', 'Early Years'],
                            ['Year 1', '5 – 6', 'Primary'], ['Year 2', '6 – 7', 'Primary'],
                            ['Year 3', '7 – 8', 'Primary'], ['Year 4', '8 – 9', 'Primary'],
                            ['Year 5', '9 – 10', 'Primary'], ['Year 6', '10 – 11', 'Primary'],
                            ['Year 7', '11 – 12', 'Secondary'], ['Year 8', '12 – 13', 'Secondary'],
                            ['Year 9', '13 – 14', 'Secondary'], ['Year 10 – 11', '14 – 16', 'IGCSE'],
                        ]; @endphp
                        @foreach ($admissions_list1 as $row)
                        <tr class="even:bg-beige-100/50">
                            <td class="px-4 py-2.5 font-medium text-maroon-900">{{ $row[0] }}</td>
                            <td class="px-4 py-2.5 tabular-nums">{{ $row[1] }}</td>
                            <td class="px-4 py-2.5 text-charcoal-600">{{ $row[2] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

{{-- Quick links --}}
<section class="py-16 bg-ivory">
    <div class="container-site grid sm:grid-cols-3 gap-6">
        @php $admissions_list2 = [
            ['title' => 'Book a School Tour', 'desc' => 'The best first step — see KVS with your own eyes.', 'href' => '/book-a-tour'],
            ['title' => 'Tuition & Fees', 'desc' => 'Request this year\'s fee structure for your child\'s stage.', 'href' => '/fees'],
            ['title' => 'Admissions FAQs', 'desc' => 'Answers to the questions every parent asks.', 'href' => '/faqs'],
        ]; @endphp
        @foreach ($admissions_list2 as $card)
        <a href="{{ $card['href'] }}" class="reveal group bg-white border border-beige-200 rounded-sm p-7 hover:shadow-lg hover:border-gold-500/50 transition-all duration-300 block">
            <h2 class="font-display text-xl font-semibold text-maroon-900 group-hover:text-maroon-700 transition-colors">{{ $card['title'] }}</h2>
            <p class="mt-2 text-sm text-charcoal-600">{{ $card['desc'] }}</p>
            <span class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-gold-700">
                Learn more
                <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
            </span>
        </a>
        @endforeach
    </div>
</section>

@include('partials.cta-band')

@endsection
