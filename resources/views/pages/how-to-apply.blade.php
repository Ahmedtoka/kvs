@extends('layouts.site')

@section('title', 'How to Apply — Requirements & Timeline | Knowledge Valley')
@section('description', 'Everything you need to apply to KVS: required documents, assessment details, and the admission timeline for 2026/2027.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'Admissions',
    'title'   => 'How to Apply',
    'lead'    => 'The documents, assessments and timeline — everything in one place. Our team is one call away at every step.',
    'crumbs'  => [['label' => 'Admissions', 'url' => route('admissions')], ['label' => 'How to Apply']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-2 gap-14 items-start">
        <div class="reveal">
            <p class="eyebrow">Checklist</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule-left">Required Documents</h2>
            <p class="mt-4 text-sm text-charcoal-600/80">(Demo list — confirm the final list with the admissions office.)</p>
            <ul class="mt-6 space-y-4">
                @php
                    $docs = [
                        'Child\'s birth certificate (original + copy)',
                        'Parents\' national IDs or passports (copies)',
                        '6 recent passport-size photos of the child',
                        'Latest school report / transfer papers (Years 1+)',
                        'Vaccination record (Early Years)',
                        'Completed application form (available at the school)',
                    ];
                @endphp
                @foreach ($docs as $doc)
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 shrink-0 text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-charcoal-700">{{ $doc }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="reveal">
            <p class="eyebrow">What to Expect</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule-left">The Assessment</h2>
            <div class="mt-6 space-y-5 text-charcoal-600 leading-[1.75]">
                <p>
                    Assessments at KVS are friendly and age-appropriate — never stressful. For Early Years,
                    it is a gentle readiness observation through play. For Primary and Secondary, students complete
                    short assessments in English and Mathematics so we can place them in the right year group with
                    the right support.
                </p>
                <p>
                    Results are shared with you personally, along with our honest recommendation — because the right
                    placement matters more than anything else for your child's confidence.
                </p>
            </div>
            <div class="mt-8 bg-maroon-50 border border-maroon-200/60 rounded-sm p-6">
                <h3 class="font-display text-xl font-semibold text-maroon-900">Timeline for 2026/2027</h3>
                <p class="mt-2 text-sm text-charcoal-600 leading-relaxed">
                    Admission is now open. Assessments run Sunday–Thursday by appointment. Seats in some year groups
                    are limited — early application is recommended.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-14 bg-beige-100">
    <div class="container-site text-center reveal">
        <h2 class="heading-serif text-2xl sm:text-3xl">Ready to Start?</h2>
        <div class="mt-7 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('book-tour') }}" data-track="cta_click" data-label="apply-book-tour" class="btn-gold w-full sm:w-auto">Book a Tour First</a>
            <a href="tel:+201277771119" data-track="call_click" data-label="apply-page" class="btn-maroon w-full sm:w-auto">Call Admissions: 0127 777 1119</a>
        </div>
    </div>
</section>

@endsection
