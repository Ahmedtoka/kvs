@extends('layouts.app')

@section('title', 'Secondary & IGCSE — Knowledge Valley International School')
@section('meta_description', 'Secondary at KVS: Key Stage 3 through IGCSE with Cambridge, Pearson Edexcel and Oxford International AQA — the gateway to leading universities.')

@section('content')

@include('partials.page-hero', [
    'title' => 'Secondary & IGCSE',
    'subtitle' => 'Years 7+ · Key Stage 3 to IGCSE · Cambridge, Pearson Edexcel & Oxford International AQA',
    'crumbs' => [['Academics', '/academics'], ['Secondary & IGCSE', null]],
])

@include('partials.stage-page', ['stage' => [
    'photo' => kvs_image("Find Your Child's Place at KVS", 2, kvs_image('find your child place', 2)),
    'chip' => 'Years 7+ · IGCSE Pathway',
    'title' => 'Secondary',
    'img' => 'stage-secondary',
    'headline' => 'The Results That Open Doors',
    'intro' => [
        'Secondary is where a KVS education proves its value. Key Stage 3 deepens academic foundations, then students progress to IGCSE examinations with the world\'s most respected boards: Cambridge International, Pearson Edexcel and Oxford International AQA.',
        'Every IGCSE certificate earned at KVS is internationally examined and recognised by universities in Egypt and worldwide — supported by focused teaching, exam preparation and individual academic guidance.',
    ],
    'subjects_title' => 'The Secondary Curriculum',
    'subjects' => [
        ['English Language & Literature', 'Advanced analysis, writing and communication to IGCSE standard.'],
        ['Mathematics', 'Extended mathematics preparing students for university-level study.'],
        ['Sciences', 'Biology, Chemistry and Physics as separate IGCSE subjects.'],
        ['Languages', 'Continued certified German and French, plus Arabic.'],
        ['Business, ICT & Humanities', 'IGCSE options that let students shape their own pathway.'],
        ['Exam Preparation', 'Mock examinations, past-paper practice and one-to-one academic guidance.'],
    ],
    'day' => [
        'Specialist subject teachers with deep IGCSE examination experience.',
        'A structured options process helping each student choose the right subjects.',
        'Regular mock exams that build technique and remove exam-day anxiety.',
        'Leadership opportunities — student council, competitions, community service.',
        'University and career guidance as students approach graduation.',
    ],
    'next_title' => 'Aiming Higher',
    'next_desc' => 'Our IGCSE pathway is built to open the doors of leading universities in Egypt and abroad. Book a tour and meet the teachers who will get your child there.',
]])

@include('partials.cta-band')

@endsection
