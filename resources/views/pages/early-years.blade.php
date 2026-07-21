@extends('layouts.site')

@section('title', 'Early Years (FS1–FS2) — EYFS Framework | Knowledge Valley')
@section('description', 'KVS Early Years: a warm, nurturing start built on the British EYFS framework for ages 3–5 — where curiosity, confidence and a love of learning take root.')

@section('content')
@include('partials.stage-page', ['stage' => [
    'eyebrow'  => 'Academics · Ages 3–5',
    'title'    => 'Early Years',
    'lead'     => 'A warm, nurturing start built on the British EYFS framework — where curiosity, confidence and a love of learning take root.',
    'badge'    => 'FS1 – FS2 · Ages 3–5',
    'image'    => '/img/stage-early.svg',
    'overview' => [
        'Our Early Years follows the British Early Years Foundation Stage (EYFS) framework, built around learning through purposeful play. Classrooms are language-rich, hands-on environments where children explore, question and create every day.',
        'Small class sizes and dedicated assistants mean every child is known and nurtured. By the end of FS2, our children are confident communicators, early readers, and joyful learners ready for Year 1.',
    ],
    'highlights' => [
        ['title' => 'Learning Through Play', 'desc' => 'Structured play that builds early literacy, numeracy and motor skills — the EYFS way.'],
        ['title' => 'Phonics from Day One', 'desc' => 'Systematic synthetic phonics gives children a strong, confident start in reading.'],
        ['title' => 'A Language-Rich Start', 'desc' => 'English-medium learning with early exposure to Arabic and additional languages.'],
        ['title' => 'Character Foundations', 'desc' => 'Sharing, kindness and responsibility — the Valley\'s values begin here.'],
        ['title' => 'Safe, Purpose-Built Spaces', 'desc' => 'Dedicated Early Years playgrounds, classrooms and quiet corners designed for ages 3–5.'],
        ['title' => 'Partnership with Parents', 'desc' => 'Regular updates, open mornings and clear milestones so you always know how your child is growing.'],
    ],
    'day' => [
        ['time' => '7:30 AM', 'activity' => 'Warm welcome, free-flow play and morning circle'],
        ['time' => '8:30 AM', 'activity' => 'Phonics & early literacy small groups'],
        ['time' => '10:00 AM', 'activity' => 'Snack, outdoor play and motor skills'],
        ['time' => '11:00 AM', 'activity' => 'Numeracy through games and manipulatives'],
        ['time' => '12:30 PM', 'activity' => 'Story time, art, music or discovery corners'],
        ['time' => '2:00 PM', 'activity' => 'Reflection circle and home time preparation'],
    ],
    'next' => ['label' => 'Primary (Years 1–6)', 'route' => 'academics.primary'],
]])
@endsection
