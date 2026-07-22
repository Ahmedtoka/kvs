@extends('admin.layout')

@section('title', 'Visitor journey')

@section('content')
@php
    $fmt = function ($sec) {
        if ($sec === null) return null;
        if ($sec < 60) return $sec . 's';
        if ($sec < 3600) return intdiv($sec, 60) . 'm ' . ($sec % 60) . 's';
        return intdiv($sec, 3600) . 'h ' . intdiv($sec % 3600, 60) . 'm';
    };
    $meta = [
        'pageview'       => ['Viewed page', 'bg-maroon-100 text-maroon-800', 'bg-maroon-500'],
        'cta_click'      => ['Clicked a button', 'bg-gold-100 text-gold-800', 'bg-gold-500'],
        'see_all_click'  => ['Clicked "See all"', 'bg-gold-100 text-gold-800', 'bg-gold-500'],
        'nav_click'      => ['Navigation click', 'bg-beige-200 text-charcoal-700', 'bg-charcoal-400'],
        'whatsapp_click' => ['WhatsApp click', 'bg-green-100 text-green-800', 'bg-green-500'],
        'call_click'     => ['Call click', 'bg-green-100 text-green-800', 'bg-green-500'],
        'form_view'      => ['Viewed a form', 'bg-gold-100 text-gold-800', 'bg-gold-500'],
        'form_submit'    => ['Submitted a form', 'bg-gold-100 text-gold-800', 'bg-gold-600'],
        'scroll_75'      => ['Scrolled 75%', 'bg-beige-200 text-charcoal-700', 'bg-charcoal-400'],
        'conversion'     => ['CONVERTED', 'bg-maroon-800 text-ivory', 'bg-maroon-700'],
    ];
    $devColors = ['mobile' => 'bg-maroon-100 text-maroon-800', 'desktop' => 'bg-gold-100 text-gold-800', 'tablet' => 'bg-beige-200 text-charcoal-700'];
@endphp

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <a href="{{ route('admin.visitors') }}" class="text-xs font-semibold text-charcoal-500 hover:text-maroon-700">&larr; All visitors</a>
        <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900 mt-1">Visitor journey</h1>
        <div class="flex flex-wrap items-center gap-2 mt-2">
            <span class="font-mono text-xs text-charcoal-500">{{ substr($visitor, 0, 12) }}</span>
            <span class="text-xs px-2 py-0.5 rounded-full {{ $devColors[$device] ?? 'bg-beige-100 text-charcoal-700' }}">{{ ucfirst($device) }}</span>
            <span class="text-xs px-2 py-0.5 rounded-full bg-beige-100 text-charcoal-700">Source: {{ $summary['source'] }}</span>
            @if ($summary['campaign'])<span class="text-xs px-2 py-0.5 rounded-full bg-beige-100 text-charcoal-700">Campaign: {{ $summary['campaign'] }}</span>@endif
        </div>
    </div>
</div>

{{-- KPI tiles --}}
<div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
    @php $tiles = [
        ['Time on site', $fmt($summary['duration']) ?: '0s', 'text-maroon-900'],
        ['Pages viewed', number_format($summary['pageviews']), 'text-maroon-900'],
        ['Total actions', number_format($summary['total_events']), 'text-maroon-900'],
        ['Conversions', number_format($summary['conversions']), 'text-gold-700'],
    ]; @endphp
    @foreach ($tiles as [$label, $value, $color])
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        <p class="text-xs font-medium text-charcoal-600 uppercase tracking-wide">{{ $label }}</p>
        <p class="mt-2 font-display text-2xl sm:text-3xl font-bold {{ $color }} tabular-nums">{{ $value }}</p>
    </div>
    @endforeach
</div>

{{-- Entry / exit --}}
<div class="mt-4 grid sm:grid-cols-2 gap-4">
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-4">
        <p class="text-xs text-charcoal-600 uppercase tracking-wide">Started on</p>
        <p class="mt-1 font-medium text-charcoal-800 truncate">{{ $summary['entry'] ?? '—' }}</p>
        <p class="text-xs text-charcoal-500 mt-0.5">{{ $first->created_at->format('D, d M Y · H:i') }}</p>
    </div>
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-4">
        <p class="text-xs text-charcoal-600 uppercase tracking-wide">Ended on</p>
        <p class="mt-1 font-medium text-charcoal-800 truncate">{{ $summary['exit'] ?? '—' }}</p>
        <p class="text-xs text-charcoal-500 mt-0.5">{{ $last->created_at->format('D, d M Y · H:i') }}</p>
    </div>
</div>

{{-- Timeline --}}
<h2 class="mt-8 font-display text-lg font-bold text-maroon-900">Full timeline <span class="text-sm font-normal text-charcoal-600">— every action in order</span></h2>
<div class="mt-4 bg-white rounded-sm shadow-sm border border-beige-200 p-5 sm:p-6">
    <ol class="relative border-s-2 border-beige-200 ms-3">
        @foreach ($timeline as $t)
        @php [$label, $badge, $dot] = $meta[$t['event']] ?? [ucfirst(str_replace('_', ' ', $t['event'])), 'bg-beige-100 text-charcoal-700', 'bg-charcoal-400']; @endphp
        <li class="mb-6 ms-6">
            <span class="absolute -start-[9px] flex h-4 w-4 items-center justify-center rounded-full {{ $dot }} ring-4 ring-white"></span>
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $badge }}">{{ $label }}</span>
                <span class="text-sm text-charcoal-800 font-medium">{{ $t['page'] }}</span>
                @if ($t['label'])<span class="text-xs text-charcoal-500 truncate max-w-xs">· {{ $t['label'] }}</span>@endif
            </div>
            <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-charcoal-500">
                <span class="tabular-nums">{{ $t['at']->format('H:i:s') }}</span>
                @if ($t['dwell'] !== null)<span class="text-maroon-700 font-medium">spent ~{{ $fmt($t['dwell']) }} here</span>@endif
            </div>
            @if ($t['break'])
            <div class="mt-4 -ms-6 flex items-center gap-2 text-xs text-charcoal-400">
                <span class="h-px w-8 bg-beige-300"></span> later — new session <span class="h-px grow bg-beige-300"></span>
            </div>
            @endif
        </li>
        @endforeach
    </ol>
</div>
@endsection
