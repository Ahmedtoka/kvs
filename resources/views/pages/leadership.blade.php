@extends('layouts.site')

@section('title', 'Leadership Messages | Knowledge Valley International School')
@section('description', 'Messages from the KVS School Board and leadership team — our promise to every family that joins the Valley.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'Our Leadership',
    'title'   => 'A Word from Our Leadership',
    'lead'    => 'The people guiding Knowledge Valley share one promise: an education that nurtures academic excellence, builds strong character, and prepares every student for lifelong success.',
    'crumbs'  => [['label' => 'About KVS', 'url' => route('about')], ['label' => 'Leadership']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site space-y-16">
        @php
            /* DEMO leadership messages — replace with real names, photos and messages from the school */
            $leaders = [
                ['role' => 'Chairman of the Board', 'name' => 'The KVS School Board', 'img' => '/images/placeholders/leadership.svg',
                 'quote' => 'Every student who joins Knowledge Valley will experience an education that nurtures academic excellence, builds strong character, and prepares them for lifelong success.',
                 'body'  => 'Our commitment since 2008 has never changed: to graduate young people who are as strong in values as they are in academics. We invest in exceptional teachers, world-class accreditation, and a campus where every child is known, valued and challenged.'],
                ['role' => 'School Principal', 'name' => 'Principal — KVS', 'img' => '/images/placeholders/about-inset.svg',
                 'quote' => 'We believe every child has a unique strength waiting to be discovered — our job is to find it, nurture it, and celebrate it.',
                 'body'  => 'Across Early Years, Primary and Secondary, our teams design learning that is rigorous, joyful and personal. The Cambridge Learner Attributes — confident, responsible, innovative, reflective, engaged — guide everything from lesson planning to school events.'],
                ['role' => 'Head of Admissions', 'name' => 'Admissions Team — KVS', 'img' => '/images/placeholders/admission-kid.svg',
                 'quote' => 'Choosing a school is one of the biggest decisions a family makes. We are here to make it clear, warm and simple.',
                 'body'  => 'From your first phone call to your child\'s first day, our admissions team walks with you step by step — school tours, friendly assessments, and honest guidance on the right stage and placement for your child.'],
            ];
        @endphp

        @foreach ($leaders as $i => $leader)
        <div class="reveal grid lg:grid-cols-5 gap-10 items-center {{ $i % 2 ? 'lg:[direction:rtl]' : '' }}">
            <div class="lg:col-span-2 [direction:ltr]">
                <div class="relative max-w-sm mx-auto">
                    <div class="absolute -top-4 {{ $i % 2 ? '-left-4' : '-right-4' }} w-full h-full border-2 border-gold-500/60 rounded-sm" aria-hidden="true"></div>
                    <img src="{{ $leader['img'] }}" alt="{{ $leader['name'] }}" class="relative w-full rounded-sm shadow-xl" width="1600" height="1000" loading="lazy">
                </div>
            </div>
            <div class="lg:col-span-3 [direction:ltr]">
                <p class="eyebrow">{{ $leader['role'] }}</p>
                <blockquote class="font-display text-2xl sm:text-3xl leading-snug text-maroon-900 mt-4">"{{ $leader['quote'] }}"</blockquote>
                <p class="mt-5 text-charcoal-600 leading-[1.75]">{{ $leader['body'] }}</p>
                <p class="mt-5 text-sm font-semibold text-charcoal-700 tracking-wide uppercase">{{ $leader['name'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endsection
