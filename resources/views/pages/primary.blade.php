@extends('layouts.site')

@section('title', 'Primary (Years 1–6) — Cambridge Primary | Knowledge Valley')
@section('description', 'KVS Primary: strong academic foundations in English, Maths and Science — enriched by languages, arts and the Cambridge Learner Attributes.')

@section('content')
@include('partials.stage-page', ['stage' => [
    'eyebrow'  => 'Academics · Ages 5–11',
    'title'    => 'Primary',
    'lead'     => 'Strong academic foundations in English, Maths and Science — enriched by languages, arts, and the Cambridge Learner Attributes.',
    'badge'    => 'Years 1 – 6 · Ages 5–11',
    'image'    => '/img/stage-primary.svg',
    'overview' => [
        'Primary at KVS follows the Cambridge Primary programme in English, Mathematics and Science, benchmarked by Cambridge Progression Tests. Lessons are active and challenging, with clear feedback so every child knows their next step.',
        'Beyond the core, students study Arabic, Religion and Social Studies per national requirements, begin German or French with our certified partners, and grow through art, music, PE, ICT and a wide programme of clubs and trips.',
    ],
    'highlights' => [
        ['title' => 'Cambridge Primary Core', 'desc' => 'English, Maths and Science with international benchmarks and progression tests.'],
        ['title' => 'Second Language Pathways', 'desc' => 'German (Goethe-Institut) or French (Institut Français) from Primary.'],
        ['title' => 'Learner Attributes in Action', 'desc' => 'Confident, responsible, innovative, reflective, engaged — celebrated weekly.'],
        ['title' => 'Reading Culture', 'desc' => 'Library lessons, reading challenges and the annual KVS Book Fair.'],
        ['title' => 'STEM & Digital Skills', 'desc' => 'Hands-on science, computing lessons and the KVS Science Fair.'],
        ['title' => 'Sports, Arts & Clubs', 'desc' => 'A rich after-school programme — from football and chess to art and drama.'],
    ],
    'day' => [
        ['time' => '7:30 AM', 'activity' => 'Registration and morning assembly'],
        ['time' => '8:00 AM', 'activity' => 'English & Maths core lessons'],
        ['time' => '10:15 AM', 'activity' => 'Break and supervised play'],
        ['time' => '10:45 AM', 'activity' => 'Science, humanities and languages'],
        ['time' => '12:45 PM', 'activity' => 'Lunch, then PE / art / music / ICT'],
        ['time' => '2:45 PM', 'activity' => 'Home time or after-school clubs'],
    ],
    'next' => ['label' => 'Secondary & IGCSE', 'route' => 'academics.secondary'],
]])
@endsection
