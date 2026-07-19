@extends('layouts.site')

@section('title', 'Admissions FAQs | Knowledge Valley International School')
@section('description', 'Quick answers to the questions parents ask us most — curriculum, assessments, languages, transport, fees and more.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'Admissions',
    'title'   => 'Frequently Asked Questions',
    'lead'    => 'Quick answers to what parents ask us most. Can\'t find yours? Call us — a real person answers.',
    'crumbs'  => [['label' => 'Admissions', 'url' => route('admissions')], ['label' => 'FAQs']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site max-w-3xl">
        @php
            $faqs = [
                ['q' => 'What curriculum does KVS follow?', 'a' => 'A full British curriculum: EYFS in Early Years, Cambridge Primary in Years 1–6, then an IGCSE pathway with Cambridge, Pearson Edexcel and Oxford International AQA in Secondary.'],
                ['q' => 'From what age can my child join?', 'a' => 'Children join FS1 from age 3 (by October 1st of the entry year). We accept applications for all stages from FS1 up to the IGCSE years, subject to seat availability.'],
                ['q' => 'Is the entry assessment difficult?', 'a' => 'No — it is friendly and age-appropriate. Early Years is a play-based readiness observation; Primary and Secondary applicants complete short English and Maths assessments so we place them correctly.'],
                ['q' => 'Which languages will my child learn?', 'a' => 'English is the medium of instruction. From Primary, students add German (with Goethe-Institut) or French (with Institut Français d\'Égypte), both with official certification pathways. Arabic follows national requirements.'],
                ['q' => 'Do you provide school transport?', 'a' => 'Yes — air-conditioned buses with supervisors cover Giza and nearby areas, managed and paid digitally through our smart campus systems.'],
                ['q' => 'How do I pay fees?', 'a' => 'Digitally, through SPARE and Kashier — installments, receipts and full transparency from your phone. The admissions office shares the official fee schedule and payment plan options.'],
                ['q' => 'When does admission close for 2026/2027?', 'a' => 'Admission remains open while seats last. Some year groups fill early — we recommend booking your tour and assessment as soon as possible.'],
                ['q' => 'Can we visit before applying?', 'a' => 'Absolutely — we encourage it. Book a personal school tour and see the campus, classrooms and teachers with your own eyes.'],
            ];
        @endphp

        <div class="space-y-4">
            @foreach ($faqs as $faq)
            <details class="reveal group bg-white rounded-sm border border-beige-200 shadow-sm open:shadow-md transition-shadow">
                <summary class="flex items-center justify-between gap-4 px-6 py-5 cursor-pointer list-none">
                    <h2 class="font-semibold text-maroon-900">{{ $faq['q'] }}</h2>
                    <svg class="w-5 h-5 shrink-0 text-gold-600 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </summary>
                <p class="px-6 pb-6 text-charcoal-600 leading-relaxed">{{ $faq['a'] }}</p>
            </details>
            @endforeach
        </div>

        <div class="mt-12 text-center reveal">
            <p class="text-charcoal-600">Still have a question?</p>
            <div class="mt-5 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="tel:+201277771119" data-track="call_click" data-label="faq-page" class="btn-maroon w-full sm:w-auto">Call 0127 777 1119</a>
                <a href="{{ route('book-tour') }}" data-track="cta_click" data-label="faq-book-tour" class="btn-gold w-full sm:w-auto">Book a School Tour</a>
            </div>
        </div>
    </div>
</section>

@endsection
