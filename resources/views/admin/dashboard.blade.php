@extends('admin.layout')

@section('title', 'Dashboard')

@php
    $lw = $extra['leads_week']; $lp = $extra['leads_week_prev'];
    $leadDelta = $lp > 0 ? (int) round(($lw - $lp) / $lp * 100) : ($lw > 0 ? null : 0);
    $primary = [
        ['label' => 'Visitors today', 'value' => $extra['visitors_today'], 'accent' => 'maroon',
         'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
        ['label' => 'Leads today', 'value' => $extra['leads_today'], 'accent' => 'gold',
         'icon' => 'M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z'],
        ['label' => 'New (uncontacted)', 'value' => $stats['new'], 'accent' => 'maroon',
         'icon' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0'],
        ['label' => 'Enrolled', 'value' => $stats['enrolled'], 'accent' => 'gold',
         'icon' => 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5'],
    ];
    $secondary = [
        ['label' => 'Total leads', 'value' => $stats['total']],
        ['label' => 'Tour requests', 'value' => $stats['tours']],
        ['label' => 'New CVs', 'value' => $stats['careers']],
        ['label' => 'Visitors (7 days)', 'value' => $extra['visitors_7d']],
    ];
@endphp

@section('content')
<div class="flex items-center justify-between gap-4">
    <div>
        <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Dashboard</h1>
        <p class="text-sm text-charcoal-600 mt-1">Admissions &amp; audience overview — updated live.</p>
    </div>
    <a href="{{ route('admin.leads.index') }}" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold text-maroon-800 hover:text-maroon-600">
        Manage leads
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
    </a>
</div>

{{-- Live now --}}
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

{{-- Primary KPIs --}}
<div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach ($primary as $c)
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="font-display text-3xl font-bold tabular-nums {{ $c['accent'] === 'gold' ? 'text-gold-700' : 'text-maroon-800' }}">{{ number_format($c['value']) }}</p>
                <p class="text-xs text-charcoal-600 mt-1.5">{{ $c['label'] }}</p>
            </div>
            <span class="w-10 h-10 rounded-sm flex items-center justify-center shrink-0 {{ $c['accent'] === 'gold' ? 'bg-gold-50 text-gold-700' : 'bg-maroon-50 text-maroon-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}"/></svg>
            </span>
        </div>
    </div>
    @endforeach
</div>

{{-- Secondary strip --}}
<div class="mt-4 grid grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach ($secondary as $c)
    <div class="bg-white rounded-sm border border-beige-200 shadow-sm px-5 py-4 flex items-center justify-between">
        <p class="text-xs text-charcoal-600">{{ $c['label'] }}</p>
        <p class="font-display text-xl font-bold text-maroon-900 tabular-nums">{{ number_format($c['value']) }}</p>
    </div>
    @endforeach
</div>

{{-- Charts: leads trend + status donut --}}
<div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="lg:col-span-2 bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-display text-lg font-bold text-maroon-900">Leads · last 14 days</h2>
                <p class="text-[11px] text-charcoal-400 mt-0.5">Daily form submissions</p>
            </div>
            @if ($leadDelta !== 0)
            <span class="inline-flex items-center gap-0.5 text-xs font-semibold px-2 py-0.5 rounded-full {{ ($leadDelta === null || $leadDelta > 0) ? 'text-emerald-700 bg-emerald-50' : 'text-maroon-700 bg-maroon-50' }}">
                @if ($leadDelta === null || $leadDelta > 0)
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
                @else
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                @endif
                {{ $leadDelta === null ? 'New' : abs($leadDelta) . '%' }} vs last week
            </span>
            @endif
        </div>
        <div class="mt-4 h-56"><canvas id="leadsChart" aria-label="Leads over the last 14 days"></canvas></div>
    </div>

    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        <h2 class="font-display text-lg font-bold text-maroon-900">Leads by status</h2>
        <p class="text-[11px] text-charcoal-400 mt-0.5">Whole pipeline</p>
        @php $statusTotal = collect($byStatus)->sum(); @endphp
        @if ($statusTotal === 0)
        <p class="text-sm text-charcoal-500 py-12 text-center">No leads yet.</p>
        @else
        <div class="mt-4 h-40"><canvas id="statusChart"></canvas></div>
        <ul class="mt-4 space-y-1.5">
            @foreach (\App\Models\Lead::STATUSES as $key => $label)
            @if (($byStatus[$key] ?? 0) > 0)
            <li class="flex items-center justify-between text-sm">
                <span class="inline-flex items-center gap-2 text-charcoal-700"><span class="w-2.5 h-2.5 rounded-full" data-statuscolor="{{ $loop->index }}"></span>{{ $label }}</span>
                <span class="font-semibold text-maroon-900 tabular-nums">{{ $byStatus[$key] }}</span>
            </li>
            @endif
            @endforeach
        </ul>
        @endif
    </div>
</div>

{{-- Pipeline --}}
<div class="mt-6 bg-white rounded-sm shadow-sm border border-beige-200 p-6">
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
<div class="mt-6 bg-white rounded-sm shadow-sm border border-beige-200 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-beige-200">
        <h2 class="font-display text-lg font-semibold text-maroon-900">Latest Leads</h2>
        <a href="{{ route('admin.leads.index') }}" class="text-sm font-semibold text-maroon-800 hover:text-maroon-600">View all &rarr;</a>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
(function () {
    var STATUS_PALETTE = ['#C6A15B', '#7A1F2B', '#3E7C78', '#64748B', '#B08968', '#8E5572', '#4B7BA8'];
    document.querySelectorAll('[data-statuscolor]').forEach(function (el) {
        el.style.background = STATUS_PALETTE[parseInt(el.getAttribute('data-statuscolor'), 10) % STATUS_PALETTE.length];
    });

    if (typeof Chart === 'undefined') { return; }
    Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
    Chart.defaults.color = '#6b6b6b';

    var leadTrend = @json($leadTrend);
    var lctx = document.getElementById('leadsChart');
    if (lctx) {
        new Chart(lctx, {
            type: 'line',
            data: { labels: leadTrend.map(function (r) { return r.label; }),
                    datasets: [{ label: 'Leads', data: leadTrend.map(function (r) { return r.count; }), borderColor: '#7A1F2B', backgroundColor: 'rgba(122,31,43,0.08)', fill: true, tension: 0.35, borderWidth: 2, pointRadius: 0, pointHoverRadius: 4 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip: { backgroundColor: '#2b2320' } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(0,0,0,0.05)' } }, x: { grid: { display: false }, ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 8 } } } }
        });
    }

    var statusData = @json($byStatus);
    var statusLabels = @json(collect(\App\Models\Lead::STATUSES));
    var sctx = document.getElementById('statusChart');
    if (sctx) {
        var keys = Object.keys(statusLabels).filter(function (k) { return (statusData[k] || 0) > 0; });
        if (keys.length) {
            new Chart(sctx, {
                type: 'doughnut',
                data: { labels: keys.map(function (k) { return statusLabels[k]; }),
                        datasets: [{ data: keys.map(function (k) { return statusData[k]; }), backgroundColor: STATUS_PALETTE, borderWidth: 2, borderColor: '#fff' }] },
                options: { responsive: true, maintainAspectRatio: false, cutout: '62%', plugins: { legend: { display: false }, tooltip: { backgroundColor: '#2b2320' } } }
            });
        }
    }
})();
</script>

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
@endsection
