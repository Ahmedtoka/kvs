@extends('layouts.site')

@section('title', 'Languages Programme — English, German & French | Knowledge Valley')
@section('description', 'Three languages, officially certified: English-medium education plus German with Goethe-Institut and French with Institut Français d\'Égypte.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'Academics',
    'title'   => 'Three Languages, Officially Certified',
    'lead'    => 'English-medium education plus German with Goethe-Institut and French with Institut Français d\'Égypte — something families cannot find elsewhere.',
    'crumbs'  => [['label' => 'Academics', 'url' => route('academics')], ['label' => 'Languages']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site grid md:grid-cols-3 gap-8">
        @php
            $langs = [
                ['lang' => 'English', 'partner' => 'Medium of Instruction', 'body' => 'English is the language of learning at KVS from FS1 — across the curriculum, assemblies and school life. Students graduate with the fluency of a true international education.', 'flagText' => 'EN'],
                ['lang' => 'German', 'partner' => 'with Goethe-Institut', 'body' => 'German is taught in partnership with the Goethe-Institut, with official certification pathways (Fit in Deutsch) — a rare advantage for university and career options in Europe.', 'flagText' => 'DE'],
                ['lang' => 'French', 'partner' => "with Institut Français d'Égypte", 'body' => 'French with Institut Français d\'Égypte gives students internationally recognized DELF certification pathways, taught by specialist teachers.', 'flagText' => 'FR'],
            ];
        @endphp
        @foreach ($langs as $l)
        <div class="reveal bg-white rounded-sm shadow-md border border-beige-200 p-8 flex flex-col">
            <div class="w-14 h-14 rounded-full bg-maroon-900 text-gold-400 font-display text-xl font-bold flex items-center justify-center">{{ $l['flagText'] }}</div>
            <h2 class="font-display text-2xl font-semibold text-maroon-900 mt-5">{{ $l['lang'] }}</h2>
            <p class="text-sm font-semibold text-gold-700 mt-1">{{ $l['partner'] }}</p>
            <p class="mt-4 text-charcoal-600 leading-relaxed grow">{{ $l['body'] }}</p>
        </div>
        @endforeach
    </div>
</section>

<section class="py-16 sm:py-20 bg-beige-100">
    <div class="container-site text-center reveal">
        <p class="eyebrow">Why It Matters</p>
        <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule">Certified Languages Open Doors</h2>
        <p class="mt-6 max-w-2xl mx-auto text-charcoal-600 leading-relaxed">
            Official language certificates strengthen university applications in Egypt, Europe and beyond —
            and our students earn them inside their own school, taught by specialists, without evening institutes.
        </p>
        <a href="{{ route('book-tour') }}" data-track="cta_click" data-label="languages-book-tour" class="btn-maroon mt-8">Ask About Language Pathways on a Tour</a>
    </div>
</section>

@endsection
