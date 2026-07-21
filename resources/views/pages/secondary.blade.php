@extends('layouts.site')

@section('title', 'Secondary & IGCSE — Cambridge, Edexcel, Oxford AQA | Knowledge Valley')
@section('description', 'KVS Secondary: rigorous preparation for Cambridge, Pearson Edexcel and Oxford AQA IGCSE qualifications — the gateway to leading universities.')

@section('content')
@include('partials.stage-page', ['stage' => [
    'eyebrow'  => 'Academics · Years 7+',
    'title'    => 'Secondary & IGCSE',
    'lead'     => 'Rigorous preparation for Cambridge, Pearson Edexcel and Oxford AQA qualifications — the gateway to leading universities in Egypt and worldwide.',
    'badge'    => 'Years 7+ · IGCSE Pathway',
    'image'    => '/img/stage-secondary.svg',
    'overview' => [
        'Secondary at KVS builds from Cambridge Lower Secondary into a flexible IGCSE pathway. Students select subjects across three examination boards — Cambridge, Pearson Edexcel and Oxford International AQA — guided by experienced academic advisors.',
        'Alongside examination excellence, students lead houses and clubs, mentor younger years, and complete projects linked to the UN Global Goals — graduating with the character and credentials for top universities.',
    ],
    'highlights' => [
        ['title' => 'Three Examination Boards', 'desc' => 'Cambridge, Edexcel and Oxford AQA — subject choices that play to each student\'s strengths.'],
        ['title' => 'University Guidance', 'desc' => 'Subject selection, equivalency guidance and university preparation from Year 9.'],
        ['title' => 'Sciences & Labs', 'desc' => 'Physics, Chemistry and Biology taught with full practical lab programmes.'],
        ['title' => 'Leadership & Service', 'desc' => 'Student council, house leadership, charity initiatives and community service.'],
        ['title' => 'Certified Languages', 'desc' => 'Continue German or French to official certification levels.'],
        ['title' => 'Exam-Ready Culture', 'desc' => 'Mock examinations, study skills and structured revision programmes.'],
    ],
    'day' => [
        ['time' => '7:30 AM', 'activity' => 'Registration and tutor time'],
        ['time' => '8:00 AM', 'activity' => 'IGCSE core subjects (English, Maths, Sciences)'],
        ['time' => '10:30 AM', 'activity' => 'Break'],
        ['time' => '11:00 AM', 'activity' => 'Elective subjects and languages'],
        ['time' => '1:00 PM', 'activity' => 'Lunch, then labs / PE / enrichment'],
        ['time' => '2:45 PM', 'activity' => 'Clubs, revision sessions or leadership activities'],
    ],
    'next' => ['label' => 'How to Apply — Admissions', 'route' => 'admissions.apply'],
]])
@endsection
