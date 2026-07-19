@extends('layouts.app')

@section('title', 'Frequently Asked Questions — Knowledge Valley International School')
@section('meta_description', 'Answers to the questions parents ask most about KVS — curriculum, ages, languages, transport, uniforms, assessment and transfers.')

@section('content')

@include('partials.page-hero', [
    'title' => 'Frequently Asked Questions',
    'subtitle' => 'The questions every parent asks — answered honestly. Can\'t find yours? Call us or send a WhatsApp.',
    'crumbs' => [['Admissions', '/admissions'], ['FAQs', null]],
])

<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site max-w-3xl">
        @php
            $faqs = [
                ['q' => 'What curriculum does KVS follow?',
                 'a' => 'KVS is a British curriculum school. Early Years follow the EYFS framework, Primary follows the National Curriculum of England (Key Stages 1–2), and Secondary leads to IGCSE examinations with Cambridge International, Pearson Edexcel and Oxford International AQA.'],
                ['q' => 'From what age can my child join?',
                 'a' => 'Children join FS1 from age 3. Our Age Placement Guide on the How to Apply page shows exactly which year group matches your child\'s age.'],
                ['q' => 'Is KVS accredited?',
                 'a' => 'Yes — by the University of Cambridge, Pearson Edexcel and Oxford International AQA, in partnership with the British Council. Our German and French programmes are certified by the Goethe-Institut and Institut Français respectively.'],
                ['q' => 'What languages will my child learn?',
                 'a' => 'English is the medium of instruction. German (with Goethe-Institut) and French (with Institut Français) are taught as certified foreign languages, alongside Arabic as required by the Ministry of Education.'],
                ['q' => 'Do you accept transfers from national (Egyptian) schools?',
                 'a' => 'Yes. We welcome transfers from both Egyptian and international schools. A placement assessment ensures your child joins the right year group, and our admissions team handles the transfer paperwork with you.'],
                ['q' => 'Is there a school bus service?',
                 'a' => 'Yes — optional transport covers Giza and surrounding areas, managed and tracked through the SPARE system. Ask admissions about coverage for your specific area.'],
                ['q' => 'How do I pay school fees?',
                 'a' => 'KVS is a cashless school. Fees, uniforms and canteen purchases are handled digitally through Kashier and the SPARE system — you manage everything from your phone.'],
                ['q' => 'What is the admission assessment like?',
                 'a' => 'It is friendly and age-appropriate: for young children it is a play-based session, and for older students a short academic placement in English and Maths. It is about finding the right placement — not a pass/fail exam.'],
                ['q' => 'What are the school hours?',
                 'a' => 'Sunday to Thursday, 7:30 AM – 2:45 PM.'],
                ['q' => 'How can I see the school before deciding?',
                 'a' => 'Book a personal school tour — it takes under a minute on the Book a Tour page, and our team confirms your slot within 24 hours.'],
            ];
        @endphp
        <div class="space-y-4">
            @foreach ($faqs as $faq)
            <details class="reveal group bg-white border border-beige-200 rounded-sm open:shadow-md transition-shadow">
                <summary class="flex items-center justify-between gap-4 cursor-pointer list-none px-6 py-5 font-semibold text-maroon-900 [&::-webkit-details-marker]:hidden">
                    {{ $faq['q'] }}
                    <svg class="w-5 h-5 shrink-0 text-gold-600 transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </summary>
                <p class="px-6 pb-6 text-charcoal-600 leading-[1.75]">{{ $faq['a'] }}</p>
            </details>
            @endforeach
        </div>

        <div class="mt-12 text-center reveal">
            <p class="text-charcoal-600">Still have a question?</p>
            <div class="mt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="https://wa.me/201277771119" class="btn-maroon w-full sm:w-auto">Ask on WhatsApp</a>
                <a href="/book-a-tour" class="btn-gold w-full sm:w-auto">Book a School Tour</a>
            </div>
        </div>
    </div>
</section>

@endsection
