@extends('layouts.site')

@section('title', 'Accreditations & Partners | Knowledge Valley International School')
@section('description', 'KVS is accredited by and partnered with the University of Cambridge, Pearson Edexcel, Oxford International AQA, British Council, Goethe-Institut and Institut Français.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'Trusted & Accredited',
    'title'   => 'Our Accreditations & Partners',
    'lead'    => 'Six international accreditations and partnerships guarantee that a KVS education is recognized by leading universities and employers worldwide.',
    'crumbs'  => [['label' => 'About KVS', 'url' => route('about')], ['label' => 'Accreditations']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site">
        @include('partials.accreditation-logos')

        <div class="mt-16 space-y-8">
            @php
                $details = [
                    ['name' => 'University of Cambridge', 'body' => 'As a Cambridge Pathway school, KVS delivers Cambridge Primary, Lower Secondary and IGCSE programmes. Cambridge qualifications are recognized by universities and employers in every corner of the world.'],
                    ['name' => 'Pearson Edexcel', 'body' => 'KVS is an approved Pearson Edexcel centre, offering International GCSE qualifications with globally benchmarked assessment and certification.'],
                    ['name' => 'Oxford International AQA', 'body' => 'Our students can also sit Oxford International AQA examinations — bringing the standards of two of the UK\'s most trusted education institutions to Giza.'],
                    ['name' => 'British Council', 'body' => 'Our partnership with the British Council supports teacher development, examinations and international school programmes.'],
                    ['name' => 'Goethe-Institut', 'body' => 'German at KVS is taught in partnership with the Goethe-Institut, with official certification pathways for our students.'],
                    ['name' => "Institut Français d'Égypte", 'body' => 'French at KVS is delivered with Institut Français d\'Égypte, giving students internationally recognized French language certification.'],
                ];
            @endphp
            @foreach ($details as $d)
            <div class="reveal bg-white rounded-sm border border-beige-200 shadow-sm p-7 sm:p-8 flex flex-col sm:flex-row gap-6 items-start">
                <div class="shrink-0 w-12 h-12 rounded-full bg-gold-100 border border-gold-300 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gold-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 class="font-display text-2xl font-semibold text-maroon-900">{{ $d['name'] }}</h2>
                    <p class="mt-3 text-charcoal-600 leading-relaxed">{{ $d['body'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <p class="mt-10 text-xs text-charcoal-600/70 text-center">
            Logo badges shown are demo placeholders — official brand assets will replace them (same filenames in <code>/images/accreditations/</code>).
        </p>
    </div>
</section>

@endsection
