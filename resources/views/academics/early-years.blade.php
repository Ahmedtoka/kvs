@extends('layouts.app')

@section('title', 'Early Years (FS1–FS2) — Knowledge Valley International School')
@section('meta_description', 'Early Years at KVS: a joyful, nurturing and inspiring start on the British EYFS framework for ages 3–5, building curiosity, confidence and a lifelong love of learning.')

@section('content')

@include('partials.page-hero', [
    'title' => 'Early Years',
    'subtitle' => 'FS1 – FS2 · Ages 3–5 · The British EYFS Framework',
    'crumbs' => [['Academics', '/academics'], ['Early Years', null]],
])

@include('partials.stage-page', ['stage' => [
    'photo' => '/img/stage-early-years.jpg',
    'chip' => 'FS1 – FS2 · Ages 3–5',
    'title' => 'Early Years',
    'img' => 'stage-early',
    'headline' => 'Where the Love of Learning Begins',
    'intro' => [
        'Our Early Years programme provides a joyful, nurturing, and inspiring start to every child\'s educational journey. Through play-based learning, exploration, and meaningful experiences, we foster curiosity, creativity, confidence, and independence while building strong foundations in communication, literacy, numeracy, and personal development. In a safe and caring environment, every child is encouraged to discover their unique potential and develop a lifelong love of learning.',
        'Delivered through the British EYFS (Early Years Foundation Stage) framework in small groups, with nurturing teachers and daily communication with parents — so your child is known, seen and supported from day one.',
    ],
    'subjects_title' => 'The Seven Areas of EYFS Learning',
    'subjects' => [
        ['Communication & Language', 'Listening, understanding and speaking with growing confidence.'],
        ['Literacy & Phonics', 'Systematic phonics building early reading and writing skills.'],
        ['Mathematics', 'Numbers, patterns and shapes through hands-on discovery.'],
        ['Personal, Social & Emotional', 'Making friends, managing feelings, and building independence.'],
        ['Physical Development', 'Fine and gross motor skills through play, movement and sport.'],
        ['Understanding the World & Expressive Arts', 'Exploring nature, people and creativity through art, music and role play.'],
    ],
    'day' => [
        'A calm morning welcome and circle time that builds routine and belonging.',
        'Phonics and early numeracy in short, playful, focused sessions.',
        'Outdoor play and physical development every single day.',
        'Creative corners — art, construction, role play and story time.',
        'Daily updates so parents always know how their child\'s day went.',
    ],
    'next_title' => 'The Right Start, at the Right Age',
    'next_desc' => 'Children join FS1 from age 3 and FS2 from age 4. Places in Early Years are the most requested in the school — we recommend booking your tour early.',
]])

@include('partials.cta-band')

@endsection
