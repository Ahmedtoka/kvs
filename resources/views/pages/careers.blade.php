@extends('layouts.site')

@section('title', 'Careers at KVS — Join Our Team | Knowledge Valley International School')
@section('description', 'Join a school where teachers grow: professional development with international partners, a collaborative culture, and a campus full of purpose.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'Careers',
    'title'   => 'Join Our Team',
    'lead'    => 'Great schools are built by great educators. If you share our belief in character-first education, we would love to hear from you.',
    'crumbs'  => [['label' => 'About KVS', 'url' => route('about')], ['label' => 'Careers']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-2 gap-14 items-start">
        <div class="reveal">
            <p class="eyebrow">Why Teach at KVS</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule-left">A School Where Teachers Grow</h2>
            <ul class="mt-8 space-y-5">
                @php
                    $perks = [
                        ['title' => 'Professional Development', 'desc' => 'Training with Cambridge, British Council and our international partners.'],
                        ['title' => 'A Collaborative Culture', 'desc' => 'Planning time, mentoring and real teamwork across departments.'],
                        ['title' => 'Modern Teaching Environment', 'desc' => 'Smart classrooms, labs and digital tools that support your craft.'],
                        ['title' => 'Purpose You Can Feel', 'desc' => 'Character-building is our mission — your impact goes beyond grades.'],
                    ];
                @endphp
                @foreach ($perks as $perk)
                <li class="flex gap-4">
                    <svg class="w-5 h-5 mt-1 shrink-0 text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <h3 class="font-semibold text-maroon-900">{{ $perk['title'] }}</h3>
                        <p class="mt-1 text-sm text-charcoal-600 leading-relaxed">{{ $perk['desc'] }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="reveal bg-white rounded-sm border border-beige-200 shadow-md p-8 sm:p-10">
            <h2 class="font-display text-2xl font-semibold text-maroon-900">Apply Now</h2>
            <p class="mt-3 text-charcoal-600 leading-relaxed">
                We welcome applications from qualified teachers, teaching assistants and administrative
                professionals all year round.
            </p>
            <div class="mt-7 space-y-4 text-sm">
                <p class="flex items-start gap-3">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-gold-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    <span>Send your CV and cover letter to<br><a href="mailto:info@kvs.edu.eg?subject=Job%20Application" class="font-semibold text-maroon-800 hover:text-maroon-600">info@kvs.edu.eg</a> with the subject "Job Application".</span>
                </p>
                <p class="flex items-start gap-3">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-gold-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                    <span>Or call the school office: 02 3722 1413 · 02 3722 1206</span>
                </p>
            </div>
            <a href="mailto:info@kvs.edu.eg?subject=Job%20Application" data-track="cta_click" data-label="careers-apply" class="btn-maroon w-full mt-8">Email Your CV</a>
        </div>
    </div>
</section>

@endsection
