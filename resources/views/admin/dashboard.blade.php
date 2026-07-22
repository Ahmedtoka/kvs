@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Dashboard</h1>
<p class="text-sm text-charcoal-600 mt-1">Admissions overview — updated live.</p>

{{-- ===== Live now (real-time visitors) ===== --}}
<div class="mt-6 bg-white rounded-sm shadow-sm border border-beige-200 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-3.5 bg-maroon-950">
        <div class="flex items-center gap-2.5">
            <span class="relative flex h-2.5 w-2.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background:#22c55e"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5" style="background:#22c55e"></span></span>
            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-ivory/85">Live now</span>
        </div>
        <span class="text-[11px] text-ivory/45 uppercase tracking-wide">Active in the last 5 minutes</span>
    </div>
    <div class="grid sm:grid-cols-[minmax(0,10rem)_1fr] gap-6 p-6">
        <div class="flex sm:flex-col items-center sm:items-start gap-3 sm:gap-1 sm:pr-6 sm:border-r border-beige-200">
            <p class="font-display text-5xl font-bold text-maroon-900 tabular-nums leading-none" id="live-count">{{ $live['count'] }}</p>
            <p class="text-xs text-charcoal-600 uppercase tracking-wide">On site right now</p>
        </div>
        <div class="min-w-0">
            <p class="text-xs text-charcoal-600 uppercase tracking-wide mb-3">Active pages</p>
            <ul id="live-pages" class="space-y-1.5 max-h-44 overflow-y-auto pr-1">
                @forelse ($live['pages'] as $lp)
                <li class="flex items-center justify-between gap-3 px-3 py-2 rounded-sm bg-ivory border border-beige-100">
                    <span class="truncate text-sm text-charcoal-800 font-medium">{{ $lp->page }}</span>
                    <span class="shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-maroon-800"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>{{ $lp->visitors }}</span>
                </li>
                @empty
                <li class="px-3 py-2 text-sm text-charcoal-500">No visitors active right now.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@if (auth()->user()->hasRole('media_buyer'))
<script>
    (function () {
        var url = '{{ route('admin.analytics.live') }}';
        function esc(s){ return String(s).replace(/[&<>"]/g, function(c){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]; }); }
        function refresh() {
            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then(function (r) { return r.json(); })
                .then(function (d) {
                    var c = document.getElementById('live-count'); if (c) c.textContent = d.count;
                    var u = document.getElementById('live-pages'); if (!u) return;
                    if (!d.pages || !d.pages.length) { u.innerHTML = '<li class="px-3 py-2 text-sm text-charcoal-500">No visitors active right now.</li>'; return; }
                    u.innerHTML = d.pages.map(function (p) {
                        return '<li class="flex items-center justify-between gap-3 px-3 py-2 rounded-sm bg-ivory border border-beige-100"><span class="truncate text-sm text-charcoal-800 font-medium">' + esc(p.page) + '</span><span class="shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-maroon-800"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>' + p.visitors + '</span></li>';
                    }).join('');
                }).catch(function () {});
        }
        setInterval(refresh, 15000);
    })();
</script>
@endif

{{-- Stats --}}
<div class="mt-7 grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
    @php
        $cards = [
            ['label' => 'Total Leads', 'value' => $stats['total'], 'accent' => 'text-maroon-800'],
            ['label' => 'New (Uncontacted)', 'value' => $stats['new'], 'accent' => 'text-gold-700'],
            ['label' => 'Last 7 Days', 'value' => $stats['this_week'], 'accent' => 'text-maroon-800'],
            ['label' => 'Tour Requests', 'value' => $stats['tours'], 'accent' => 'text-maroon-800'],
            ['label' => 'Enrolled', 'value' => $stats['enrolled'], 'accent' => 'text-gold-700'],
            ['label' => 'New CVs', 'value' => $stats['careers'], 'accent' => 'text-maroon-800'],
        ];
    @endphp
    @foreach ($cards as $card)
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        <p class="font-display text-3xl font-bold {{ $card['accent'] }} tabular-nums">{{ number_format($card['value']) }}</p>
        <p class="text-xs text-charcoal-600 mt-1.5">{{ $card['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Pipeline --}}
<div class="mt-8 bg-white rounded-sm shadow-sm border border-beige-200 p-6">
    <h2 class="font-display text-lg font-semibold text-maroon-900">Pipeline</h2>
    <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
        @foreach (\App\Models\Lead::STATUSES as $key => $label)
        <a href="{{ route('admin.leads.index', ['status' => $key]) }}" class="rounded-sm border border-beige-200 px-3 py-3 text-center hover:border-gold-500 hover:shadow-sm transition-all">
            <p class="font-display text-xl font-bold text-maroon-900 tabular-nums">{{ $byStatus[$key] ?? 0 }}</p>
            <p class="text-[11px] tracking-wide uppercase text-charcoal-600 mt-1">{{ $label }}</p>
        </a>
        @endforeach
    </div>
</div>

{{-- Recent leads --}}
<div class="mt-8 bg-white rounded-sm shadow-sm border border-beige-200 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-beige-200">
        <h2 class="font-display text-lg font-semibold text-maroon-900">Latest Leads</h2>
        <a href="{{ route('admin.leads.index') }}" class="text-sm font-semibold text-maroon-800 hover:text-maroon-600">View all →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-beige-100 text-left text-xs uppercase tracking-wide text-charcoal-600">
                    <th class="px-5 py-3 font-semibold">Date</th>
                    <th class="px-5 py-3 font-semibold">Parent</th>
                    <th class="px-5 py-3 font-semibold">Phone</th>
                    <th class="px-5 py-3 font-semibold">Type</th>
                    <th class="px-5 py-3 font-semibold">Stage / Year</th>
                    <th class="px-5 py-3 font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-beige-100">
                @forelse ($recent as $lead)
                <tr class="hover:bg-beige-100/40">
                    <td class="px-5 py-3 whitespace-nowrap text-charcoal-600">{{ $lead->created_at->format('d M, H:i') }}</td>
                    <td class="px-5 py-3 font-medium text-charcoal-800">{{ $lead->parent_name }}</td>
                    <td class="px-5 py-3 tabular-nums"><a href="tel:{{ $lead->phone }}" class="hover:text-maroon-700">{{ $lead->phone }}</a></td>
                    <td class="px-5 py-3">{{ \App\Models\Lead::TYPES[$lead->type] ?? $lead->type }}</td>
                    <td class="px-5 py-3 text-charcoal-600">{{ $lead->stage ?: $lead->year_group ?: '—' }}</td>
                    <td class="px-5 py-3">
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold {{ $lead->status === 'new' ? 'bg-gold-100 text-gold-800' : 'bg-beige-100 text-charcoal-700' }}">
                            {{ \App\Models\Lead::STATUSES[$lead->status] ?? $lead->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-charcoal-600">No leads yet — they will appear here the moment a parent submits any form on the website.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
