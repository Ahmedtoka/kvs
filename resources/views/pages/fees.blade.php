@extends('layouts.site')

@section('title', 'Tuition & Fees 2026/2027 | Knowledge Valley International School')
@section('description', 'Transparent tuition structure at KVS by stage — with modern digital payment through our smart cashless campus (SPARE & Kashier).')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'Admissions',
    'title'   => 'Tuition & Fees',
    'lead'    => 'A transparent structure with modern, digital payment options through our smart cashless campus.',
    'crumbs'  => [['label' => 'Admissions', 'url' => route('admissions')], ['label' => 'Tuition & Fees']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site max-w-4xl">
        <div class="reveal bg-gold-100 border border-gold-300 rounded-sm px-6 py-4 text-sm text-maroon-900 font-medium">
            The figures below are DEMO placeholders — the school publishes official fees for each academic year.
            Contact admissions for the confirmed 2026/2027 fee schedule.
        </div>

        <div class="mt-8 reveal bg-white rounded-sm border border-beige-200 shadow-md overflow-x-auto">
            <table class="w-full text-sm min-w-[560px]">
                <thead>
                    <tr class="bg-maroon-900 text-ivory text-left text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Stage</th>
                        <th class="px-6 py-4 font-semibold">Year Groups</th>
                        <th class="px-6 py-4 font-semibold text-right">Annual Tuition (EGP)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $fees = [
                            ['stage' => 'Early Years', 'years' => 'FS1 – FS2', 'fee' => 'XX,XXX'],
                            ['stage' => 'Primary — Lower', 'years' => 'Years 1 – 3', 'fee' => 'XX,XXX'],
                            ['stage' => 'Primary — Upper', 'years' => 'Years 4 – 6', 'fee' => 'XX,XXX'],
                            ['stage' => 'Secondary', 'years' => 'Years 7 – 9', 'fee' => 'XX,XXX'],
                            ['stage' => 'IGCSE', 'years' => 'Years 10+', 'fee' => 'XX,XXX'],
                        ];
                    @endphp
                    @foreach ($fees as $row)
                    <tr class="border-b border-beige-100 last:border-0 hover:bg-ivory/60 transition-colors">
                        <td class="px-6 py-4 font-semibold text-maroon-900">{{ $row['stage'] }}</td>
                        <td class="px-6 py-4 text-charcoal-600">{{ $row['years'] }}</td>
                        <td class="px-6 py-4 text-right font-display font-bold text-maroon-900 tabular-nums">{{ $row['fee'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-10 grid sm:grid-cols-2 gap-6">
            <div class="reveal bg-white rounded-sm border border-beige-200 shadow-sm p-7">
                <h2 class="font-display text-xl font-semibold text-maroon-900">What Fees Include</h2>
                <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">
                    Tuition, examinations registration support, library and lab access, and the core activities
                    programme. Transport, uniforms and canteen are managed separately — digitally.
                </p>
            </div>
            <div class="reveal bg-white rounded-sm border border-beige-200 shadow-sm p-7">
                <h2 class="font-display text-xl font-semibold text-maroon-900">Pay Digitally</h2>
                <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">
                    Through SPARE and Kashier, fees and school payments are handled from your phone —
                    installments, receipts and full transparency. <a href="{{ route('school-life.smart') }}" class="font-semibold text-maroon-800 hover:text-maroon-600">Learn about our smart campus</a>.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
