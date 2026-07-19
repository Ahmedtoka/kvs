@extends('layouts.app')

@section('title', 'Primary (Years 1–6) — Knowledge Valley International School')
@section('meta_description', 'Primary at KVS: the National Curriculum of England for ages 5–11 — strong foundations in English, Maths and Science, enriched by German, French, arts and sport.')

@section('content')

@include('partials.page-hero', [
    'title' => 'Primary',
    'subtitle' => 'Years 1 – 6 · Ages 5–11 · Key Stages 1 & 2',
    'crumbs' => [['Academics', '/academics'], ['Primary', null]],
])

@include('partials.stage-page', ['stage' => [
    'photo' => kvs_image("Find Your Child's Place at KVS", 1, kvs_image('find your child place', 1)),
    'chip' => 'Years 1 – 6 · Ages 5–11',
    'title' => 'Primary',
    'img' => 'stage-primary',
    'headline' => 'Strong Foundations, Built Properly',
    'intro' => [
        'Primary at KVS follows the National Curriculum of England through Key Stages 1 and 2. English, Mathematics and Science are taught with depth and rigour, while the Cambridge Learner Attributes shape how children think — not just what they know.',
        'This is also where our language advantage begins: German with the Goethe-Institut and French with the Institut Français join the timetable, alongside Arabic studies, ICT, arts and PE.',
    ],
    'subjects_title' => 'The Primary Curriculum',
    'subjects' => [
        ['English', 'Reading, writing, comprehension and spoken confidence to a British standard.'],
        ['Mathematics', 'Fluency, reasoning and problem-solving through the mastery approach.'],
        ['Science', 'Hands-on investigation across biology, chemistry and physics foundations.'],
        ['Languages — German & French', 'Certified pathways with Goethe-Institut and Institut Français.'],
        ['Arabic, Religion & Social Studies', 'Ministry-required subjects taught with the same care and quality.'],
        ['ICT, Arts & PE', 'Digital skills, creative expression and daily physical activity.'],
    ],
    'day' => [
        'Morning assembly building confidence, values and community.',
        'Core lessons in English, Maths and Science with individual attention.',
        'Language lessons — German and French — woven through the week.',
        'Clubs, competitions and events: science fair, book fair, chess academy.',
        'Progress tracked and shared with parents through regular reports.',
    ],
    'next_title' => 'Joining Mid-Journey?',
    'next_desc' => 'We welcome transfer students from Egyptian and international schools throughout Primary. Our placement assessment ensures your child joins the right year group comfortably.',
]])

@include('partials.cta-band')

@endsection
