@extends('admin.layout')

@section('title', 'User Flow')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
    <div>
        <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">User Flow &amp; Ad Performance</h1>
        <p class="text-sm text-charcoal-600 mt-1">Where visitors enter, the journeys they take, where they leave — and which sources actually convert.</p>
    </div>
    <form method="GET" class="flex items-end gap-3 bg-white rounded-sm shadow-sm border border-beige-200 p-3">
        <div>
            <label for="from" class="block text-xs font-medium text-charcoal-600 mb-1">From</label>
            <input id="from" type="date" name="from" value="{{ $from->toDateString() }}" class="h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
        </div>
        <div>
            <label for="to" class="block text-xs font-medium text-charcoal-600 mb-1">To</label>
            <input id="to" type="date" name="to" value="{{ $to->toDateString() }}" class="h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
        </div>
        <button type="submit" class="btn-gold !py-2.5 !px-5 !text-xs">Apply</button>
    </form>
</div>

{{-- KPI cards --}}
<div class="mt-6 grid grid-cols-2 lg:grid-cols-5 gap-4">
    @php $kpiCards = [
        ['Unique visitors', number_format($kpis['visitors']), 'text-maroon-900'],
        ['Pageviews', number_format($kpis['pageviews']), 'text-maroon-900'],
        ['Conversions', number_format($kpis['conversions']), 'text-gold-700'],
        ['Conversion rate', $kpis['rate'] . '%', 'text-gold-700'],
        ['Pages / visitor', $kpis['avg_pages'], 'text-maroon-900'],
    ]; @endphp
    @foreach ($kpiCards as [$label, $value, $color])
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        <p class="text-xs font-medium text-charcoal-600 uppercase tracking-wide">{{ $label }}</p>
        <p class="mt-2 font-display text-2xl sm:text-3xl font-bold {{ $color }}">{{ $value }}</p>
    </div>
    @endforeach
</div>

{{-- Entry / Exit pages --}}
<div class="mt-6 grid lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-6">
        <h2 class="font-display text-lg font-bold text-maroon-900">Entry pages <span class="text-sm font-normal text-charcoal-600">— where visitors start</span></h2>
        <div class="mt-4 space-y-2.5">
            @php $entryMax = max(1, optional($entryPages->first())->total ?? 1); @endphp
            @forelse ($entryPages as $row)
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-charcoal-800 font-medium truncate pr-3">{{ $row->page }}</span>
                    <span class="text-charcoal-600 tabular-nums shrink-0">{{ number_format($row->total) }}</span>
                </div>
                <div class="h-2 rounded-full bg-beige-100 overflow-hidden"><div class="h-full bg-gold-500" style="width: {{ round($row->total / $entryMax * 100) }}%"></div></div>
            </div>
            @empty
            <p class="text-sm text-charcoal-600">No data in this range yet.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-6">
        <h2 class="font-display text-lg font-bold text-maroon-900">Exit pages <span class="text-sm font-normal text-charcoal-600">— where visitors leave</span></h2>
        <div class="mt-4 space-y-2.5">
            @php $exitMax = max(1, optional($exitPages->first())->total ?? 1); @endphp
            @forelse ($exitPages as $row)
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-charcoal-800 font-medium truncate pr-3">{{ $row->page }}</span>
                    <span class="text-charcoal-600 tabular-nums shrink-0">{{ number_format($row->total) }}</span>
                </div>
                <div class="h-2 rounded-full bg-beige-100 overflow-hidden"><div class="h-full bg-maroon-700" style="width: {{ round($row->total / $exitMax * 100) }}%"></div></div>
            </div>
            @empty
            <p class="text-sm text-charcoal-600">No data in this range yet.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Ad / source performance --}}
<div class="mt-6 bg-white rounded-sm shadow-sm border border-beige-200 p-6">
    <h2 class="font-display text-lg font-bold text-maroon-900">Traffic sources &amp; ad performance</h2>
    <p class="text-sm text-charcoal-600 mt-1">Add <code class="text-xs bg-beige-100 px-1.5 py-0.5 rounded">?utm_source=facebook&amp;utm_campaign=summer</code> to your ad links so each source is attributed here.</p>
    <div class="mt-4 overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs uppercase tracking-wide text-charcoal-600 border-b border-beige-200">
                    <th class="py-2 pr-4 font-semibold">Source</th>
                    <th class="py-2 px-4 font-semibold text-right">Visitors</th>
                    <th class="py-2 px-4 font-semibold text-right">Conversions</th>
                    <th class="py-2 pl-4 font-semibold text-right">Conv. rate</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($adsPerformance as $row)
                <tr class="border-b border-beige-100 last:border-0">
                    <td class="py-2.5 pr-4 font-medium text-charcoal-800">{{ $row['source'] }}</td>
                    <td class="py-2.5 px-4 text-right tabular-nums text-charcoal-700">{{ number_format($row['visitors']) }}</td>
                    <td class="py-2.5 px-4 text-right tabular-nums font-semibold text-gold-700">{{ number_format($row['conversions']) }}</td>
                    <td class="py-2.5 pl-4 text-right tabular-nums {{ $row['rate'] > 0 ? 'text-maroon-800 font-semibold' : 'text-charcoal-500' }}">{{ $row['rate'] }}%</td>
                </tr>
                @empty
                <tr><td colspan="4" class="py-4 text-charcoal-600">No traffic recorded in this range yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Campaigns + Conversions by type --}}
<div class="mt-6 grid lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-6">
        <h2 class="font-display text-lg font-bold text-maroon-900">Campaigns that converted</h2>
        <p class="text-sm text-charcoal-600 mt-1">Conversions grouped by <code class="text-xs bg-beige-100 px-1.5 py-0.5 rounded">utm_campaign</code>.</p>
        <div class="mt-4 space-y-2">
            @forelse ($campaigns as $c)
            <div class="flex items-center justify-between gap-3 py-2 border-b border-beige-100 last:border-0">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-charcoal-800 truncate">{{ $c->campaign }}</p>
                    <p class="text-xs text-charcoal-500">{{ $c->source }}</p>
                </div>
                <span class="text-sm font-semibold text-gold-700 tabular-nums shrink-0">{{ number_format($c->conversions) }}</span>
            </div>
            @empty
            <p class="text-sm text-charcoal-600">No campaign-tagged conversions yet. Tag your ad links with <code class="text-xs bg-beige-100 px-1.5 py-0.5 rounded">utm_campaign</code> to see them here.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-6">
        <h2 class="font-display text-lg font-bold text-maroon-900">Conversions by form</h2>
        <p class="text-sm text-charcoal-600 mt-1">Which Thank-You page each conversion came from.</p>
        <div class="mt-4 space-y-2">
            @forelse ($convByType as $c)
            <div class="flex items-center justify-between gap-3 py-2 border-b border-beige-100 last:border-0">
                <span class="text-sm font-medium text-charcoal-800">{{ $typeLabels[$c->label] ?? $c->label }}</span>
                <span class="text-sm font-semibold text-gold-700 tabular-nums">{{ number_format($c->total) }}</span>
            </div>
            @empty
            <p class="text-sm text-charcoal-600">No conversions in this range yet.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- By device --}}
<div class="mt-6 bg-white rounded-sm shadow-sm border border-beige-200 p-6">
    <h2 class="font-display text-lg font-bold text-maroon-900">By device</h2>
    <p class="text-sm text-charcoal-600 mt-1">Mobile vs desktop vs tablet — visitors and how many converted.</p>
    @php $devMeta = ['mobile' => ['Mobile', 'bg-maroon-700'], 'desktop' => ['Desktop', 'bg-gold-500'], 'tablet' => ['Tablet', 'bg-charcoal-400']]; @endphp
    <div class="mt-4 grid sm:grid-cols-3 gap-4">
        @forelse ($deviceSplit as $d)
        @php [$dLabel, $dColor] = $devMeta[$d['device']] ?? [ucfirst($d['device']), 'bg-beige-400']; @endphp
        <div class="rounded-sm border border-beige-200 p-5">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-2.5 h-2.5 rounded-full {{ $dColor }}"></span>
                <span class="text-sm font-medium text-charcoal-700">{{ $dLabel }}</span>
            </div>
            <div class="flex items-end justify-between gap-3">
                <div>
                    <p class="font-display text-2xl font-bold text-maroon-900 tabular-nums">{{ number_format($d['visitors']) }}</p>
                    <p class="text-xs text-charcoal-600">visitors</p>
                </div>
                <div class="text-right">
                    <p class="font-display text-2xl font-bold text-gold-700 tabular-nums">{{ number_format($d['conversions']) }}</p>
                    <p class="text-xs text-charcoal-600">conversions</p>
                </div>
            </div>
            <p class="mt-2 text-xs text-charcoal-500">Conv. rate: {{ $d['visitors'] > 0 ? round($d['conversions'] / $d['visitors'] * 100, 1) : 0 }}%</p>
        </div>
        @empty
        <p class="py-6 text-center text-sm text-charcoal-600 sm:col-span-3">No device data in this range yet.</p>
        @endforelse
    </div>
</div>

{{-- Top journeys --}}
<div class="mt-6 bg-white rounded-sm shadow-sm border border-beige-200 p-6">
    <h2 class="font-display text-lg font-bold text-maroon-900">Top journeys</h2>
    <p class="text-sm text-charcoal-600 mt-1">The most common click paths — first page through to where they stopped (up to 5 steps).</p>
    @if ($pathsCapped)
    <p class="text-xs text-maroon-700 mt-1">Showing a sample of the most recent 20,000 pageviews in this range.</p>
    @endif
    <div class="mt-4 space-y-3">
        @forelse ($topPaths as $path => $count)
        <div class="flex items-start justify-between gap-4 py-2 border-b border-beige-100 last:border-0">
            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 min-w-0">
                @foreach (explode('  |  ', $path) as $i => $step)
                @if ($i > 0)
                <svg class="w-3.5 h-3.5 text-gold-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5"/></svg>
                @endif
                <span class="text-xs px-2 py-1 rounded bg-beige-100 text-charcoal-700 font-medium">{{ $step }}</span>
                @endforeach
            </div>
            <span class="text-sm font-semibold text-charcoal-700 tabular-nums shrink-0">{{ number_format($count) }}</span>
        </div>
        @empty
        <p class="text-sm text-charcoal-600">No journeys recorded in this range yet.</p>
        @endforelse
    </div>
</div>
@endsection
