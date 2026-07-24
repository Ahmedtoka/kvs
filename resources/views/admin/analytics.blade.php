@extends('admin.layout')

@section('title', 'Analytics')

@php
    // Small helpers for this view only.
    $rangeLabels = ['today' => 'Today', 'yesterday' => 'Yesterday', '7d' => 'Last 7 days', '30d' => 'Last 30 days', 'custom' => 'Custom'];
    $activeRange = $rangeLabels[$rangeKey] ?? 'Today';
    $deltaBadge = function ($d) {
        if (($d['new'] ?? false)) {
            return ['cls' => 'text-emerald-700 bg-emerald-50', 'txt' => 'New', 'arrow' => 'up'];
        }
        if ($d['pct'] === null || $d['dir'] === 'flat') {
            return ['cls' => 'text-charcoal-500 bg-beige-100', 'txt' => '0%', 'arrow' => 'flat'];
        }
        if ($d['dir'] === 'up') {
            return ['cls' => 'text-emerald-700 bg-emerald-50', 'txt' => '+' . $d['pct'] . '%', 'arrow' => 'up'];
        }
        return ['cls' => 'text-maroon-700 bg-maroon-50', 'txt' => '-' . $d['pct'] . '%', 'arrow' => 'down'];
    };
    $deviceIcons = [
        'mobile'  => 'M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3',
        'desktop' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25',
        'tablet'  => 'M10.5 19.5h3M6 3.75A2.25 2.25 0 018.25 1.5h7.5A2.25 2.25 0 0118 3.75v16.5a2.25 2.25 0 01-2.25 2.25h-7.5A2.25 2.25 0 016 20.25V3.75z',
    ];
@endphp

@section('content')
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
    <div>
        <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Analytics</h1>
        <p class="text-sm text-charcoal-600 mt-1">Real visitor behaviour &middot; showing <span class="font-semibold text-charcoal-700">{{ $activeRange }}</span></p>
    </div>
    <div class="flex items-center gap-3">
        <span class="inline-flex items-center gap-2 text-sm font-semibold text-charcoal-700 bg-white border border-beige-200 rounded-sm px-3 py-2">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-70"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
            </span>
            <span id="live-count">{{ $live['count'] }}</span> online now
        </span>
    </div>
</div>

{{-- Date range filter --}}
<div class="mt-5 flex flex-col sm:flex-row sm:items-center gap-3 flex-wrap">
    <div class="inline-flex rounded-sm border border-beige-200 bg-white p-1 shadow-sm">
        @foreach (['today' => 'Today', 'yesterday' => 'Yesterday', '7d' => '7 days', '30d' => '30 days'] as $k => $lbl)
        <a href="{{ route('admin.analytics', ['range' => $k]) }}"
           class="px-3 py-1.5 text-xs sm:text-sm font-semibold rounded-sm transition-colors {{ $rangeKey === $k ? 'bg-maroon-800 text-ivory' : 'text-charcoal-600 hover:bg-beige-100' }}">
            {{ $lbl }}
        </a>
        @endforeach
    </div>
    <form method="GET" action="{{ route('admin.analytics') }}" class="flex items-center gap-2">
        <input type="hidden" name="range" value="custom">
        <input type="date" name="from" value="{{ $rangeKey === 'custom' ? $from->toDateString() : '' }}" class="h-9 px-2 rounded-sm border border-beige-300 bg-white text-xs">
        <span class="text-charcoal-400 text-xs">to</span>
        <input type="date" name="to" value="{{ $rangeKey === 'custom' ? $to->toDateString() : '' }}" class="h-9 px-2 rounded-sm border border-beige-300 bg-white text-xs">
        <button type="submit" class="h-9 px-3 rounded-sm bg-charcoal-800 text-ivory text-xs font-semibold hover:bg-charcoal-700">Apply</button>
    </form>
</div>

{{-- KPI tiles --}}
<div class="mt-5 grid grid-cols-2 lg:grid-cols-6 gap-3">
    @foreach ($cards as $c)
    @php $badge = $deltaBadge($c['delta']); @endphp
    <div class="bg-white rounded-sm border border-beige-200 shadow-sm p-4">
        <p class="text-[11px] font-semibold uppercase tracking-wide text-charcoal-500">{{ $c['label'] }}</p>
        <div class="mt-2 flex items-end justify-between gap-1">
            <span class="font-display text-2xl font-bold text-maroon-900 tabular-nums">{{ $c['value'] }}</span>
            <span class="inline-flex items-center gap-0.5 text-[11px] font-semibold px-1.5 py-0.5 rounded-full {{ $badge['cls'] }}">
                @if ($badge['arrow'] === 'up')
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
                @elseif ($badge['arrow'] === 'down')
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                @endif
                {{ $badge['txt'] }}
            </span>
        </div>
        <p class="mt-1 text-[11px] text-charcoal-400">{{ $c['hint'] }}</p>
    </div>
    @endforeach
</div>
<p class="mt-2 text-[11px] text-charcoal-400">Deltas compare with the previous equivalent period. Bots &amp; link-preview crawlers are excluded.</p>

{{-- Trend chart --}}
<div class="mt-5 bg-white rounded-sm border border-beige-200 shadow-sm p-5">
    <div class="flex items-center justify-between">
        <h2 class="font-display text-lg font-bold text-maroon-900">Traffic over time</h2>
        <div class="flex items-center gap-4 text-xs text-charcoal-600">
            <span class="inline-flex items-center gap-1.5"><span class="w-3 h-1.5 rounded-full" style="background:#7A1F2B"></span> Visitors</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-3 h-1.5 rounded-full" style="background:#C6A15B"></span> Page views</span>
        </div>
    </div>
    <div class="mt-4 h-64 sm:h-72"><canvas id="trendChart" aria-label="Visitors and page views over time"></canvas></div>
</div>

{{-- Sources + Devices + Audience interest --}}
<div class="mt-5 grid grid-cols-1 lg:grid-cols-3 gap-4">
    {{-- Traffic sources --}}
    <div class="bg-white rounded-sm border border-beige-200 shadow-sm p-5">
        <h2 class="font-display text-lg font-bold text-maroon-900">Where visitors come from</h2>
        <p class="text-[11px] text-charcoal-400 mt-0.5">First visit source &middot; internal clicks excluded</p>
        @if ($sources->isEmpty())
        <p class="text-sm text-charcoal-500 py-10 text-center">No visits in this period yet.</p>
        @else
        <div class="mt-4 h-44"><canvas id="sourcesChart"></canvas></div>
        <ul class="mt-4 space-y-1.5">
            @foreach ($sources as $i => $s)
            <li class="flex items-center justify-between text-sm">
                <span class="inline-flex items-center gap-2 text-charcoal-700">
                    <span class="w-2.5 h-2.5 rounded-full" data-srccolor="{{ $i }}"></span>{{ $s['source'] }}
                </span>
                <span class="font-semibold text-maroon-900 tabular-nums">{{ number_format($s['visitors']) }}</span>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

    {{-- Devices --}}
    <div class="bg-white rounded-sm border border-beige-200 shadow-sm p-5">
        <h2 class="font-display text-lg font-bold text-maroon-900">Devices</h2>
        <p class="text-[11px] text-charcoal-400 mt-0.5">How your audience browses</p>
        @if ($devices->isEmpty())
        <p class="text-sm text-charcoal-500 py-10 text-center">No visits in this period yet.</p>
        @else
        <div class="mt-4 h-44"><canvas id="devicesChart"></canvas></div>
        <ul class="mt-4 space-y-2">
            @php $devTotal = max(1, $devices->sum('visitors')); @endphp
            @foreach ($devices as $d)
            <li class="flex items-center justify-between text-sm">
                <span class="inline-flex items-center gap-2 text-charcoal-700 capitalize">
                    <svg class="w-4 h-4 text-charcoal-500" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $deviceIcons[$d['device']] ?? $deviceIcons['desktop'] }}"/></svg>
                    {{ $d['device'] }}
                </span>
                <span class="font-semibold text-maroon-900 tabular-nums">{{ round($d['visitors'] / $devTotal * 100) }}%</span>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

    {{-- Audience interest --}}
    <div class="bg-gradient-to-br from-maroon-900 to-maroon-950 text-ivory rounded-sm border border-maroon-900 shadow-sm p-5">
        <h2 class="font-display text-lg font-bold">Audience interest</h2>
        <p class="text-[11px] text-ivory/60 mt-0.5">Are people actually engaging?</p>
        <div class="mt-4 flex items-center gap-4">
            <div class="relative w-24 h-24 shrink-0">
                <svg class="w-24 h-24 -rotate-90" viewBox="0 0 36 36">
                    <circle cx="18" cy="18" r="15.9155" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="3.4"></circle>
                    <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#C6A15B" stroke-width="3.4" stroke-linecap="round"
                            stroke-dasharray="{{ $engagement['score'] }} 100"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="font-display text-2xl font-bold">{{ $engagement['score'] }}</span>
                    <span class="text-[9px] text-ivory/60 uppercase tracking-wide">/ 100</span>
                </div>
            </div>
            <div>
                <p class="font-display text-lg font-bold text-gold-300">{{ $engagement['verdict'] }}</p>
                <p class="text-xs text-ivory/70 mt-1 leading-relaxed">Based on scroll depth, engaged visits, and how many people came back.</p>
            </div>
        </div>
        <dl class="mt-5 grid grid-cols-3 gap-3 text-center">
            <div class="bg-white/5 rounded-sm py-2.5">
                <dt class="text-[10px] uppercase tracking-wide text-ivory/50">Bounce</dt>
                <dd class="font-display text-lg font-bold tabular-nums">{{ $engagement['bounce_rate'] }}%</dd>
            </div>
            <div class="bg-white/5 rounded-sm py-2.5">
                <dt class="text-[10px] uppercase tracking-wide text-ivory/50">Read deep</dt>
                <dd class="font-display text-lg font-bold tabular-nums">{{ $engagement['scroll_rate'] }}%</dd>
            </div>
            <div class="bg-white/5 rounded-sm py-2.5">
                <dt class="text-[10px] uppercase tracking-wide text-ivory/50">Returning</dt>
                <dd class="font-display text-lg font-bold tabular-nums">{{ $engagement['returning_rate'] }}%</dd>
            </div>
        </dl>
    </div>
</div>

{{-- Funnel + Top pages --}}
<div class="mt-5 grid grid-cols-1 lg:grid-cols-2 gap-4">
    {{-- Funnel --}}
    <div class="bg-white rounded-sm border border-beige-200 shadow-sm p-5">
        <h2 class="font-display text-lg font-bold text-maroon-900">Journey funnel</h2>
        <p class="text-[11px] text-charcoal-400 mt-0.5">From landing to a submitted request</p>
        <div class="mt-4 space-y-3">
            @foreach ($funnel['steps'] as $i => $step)
            @php $pct = round($step['count'] / $funnel['max'] * 100); @endphp
            <div>
                <div class="flex items-center justify-between text-sm mb-1">
                    <span class="text-charcoal-700">{{ $i + 1 }}. {{ $step['label'] }}</span>
                    <span class="font-semibold text-maroon-900 tabular-nums">{{ number_format($step['count']) }}</span>
                </div>
                <div class="h-2.5 rounded-full bg-beige-100 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-maroon-700 to-gold-500" style="width: {{ max(2, $pct) }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Top pages --}}
    <div class="bg-white rounded-sm border border-beige-200 shadow-sm p-5">
        <h2 class="font-display text-lg font-bold text-maroon-900">Most-viewed pages</h2>
        <p class="text-[11px] text-charcoal-400 mt-0.5">By page views in this period</p>
        @php $pageMax = max(1, optional($topPages->first())->views ?? 1); @endphp
        <div class="mt-4 space-y-2.5">
            @forelse ($topPages as $p)
            <div>
                <div class="flex items-center justify-between text-sm mb-1">
                    <span class="text-charcoal-700 truncate max-w-[70%]" title="{{ $p->page }}">{{ $p->page }}</span>
                    <span class="text-charcoal-500 text-xs tabular-nums">{{ number_format($p->views) }} views &middot; {{ number_format($p->visitors) }} ppl</span>
                </div>
                <div class="h-2 rounded-full bg-beige-100 overflow-hidden">
                    <div class="h-full rounded-full bg-gold-500" style="width: {{ max(3, round($p->views / $pageMax * 100)) }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-sm text-charcoal-500 py-8 text-center">No page views yet.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Entry pages + Interactions --}}
<div class="mt-5 grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="bg-white rounded-sm border border-beige-200 shadow-sm p-5">
        <h2 class="font-display text-lg font-bold text-maroon-900">Landing pages</h2>
        <p class="text-[11px] text-charcoal-400 mt-0.5">Where visits begin</p>
        <ul class="mt-3 divide-y divide-beige-100">
            @forelse ($entryPages as $e)
            <li class="flex items-center justify-between py-2 text-sm">
                <span class="text-charcoal-700 truncate max-w-[75%]" title="{{ $e->page }}">{{ $e->page }}</span>
                <span class="font-semibold text-maroon-900 tabular-nums">{{ number_format($e->total) }}</span>
            </li>
            @empty
            <li class="py-8 text-center text-sm text-charcoal-500">No data yet.</li>
            @endforelse
        </ul>
    </div>

    <div class="bg-white rounded-sm border border-beige-200 shadow-sm p-5">
        <h2 class="font-display text-lg font-bold text-maroon-900">Top interactions</h2>
        <p class="text-[11px] text-charcoal-400 mt-0.5">Clicks on CTAs, WhatsApp, call &amp; nav</p>
        <ul class="mt-3 divide-y divide-beige-100">
            @forelse ($interactions as $it)
            <li class="flex items-center justify-between py-2 text-sm gap-3">
                <span class="inline-flex items-center gap-2 text-charcoal-700 truncate">
                    <span class="text-[10px] font-semibold uppercase tracking-wide text-gold-700 bg-gold-50 px-1.5 py-0.5 rounded shrink-0">{{ str_replace('_', ' ', $it->event) }}</span>
                    <span class="truncate" title="{{ $it->label }}">{{ $it->label ?: '—' }}</span>
                </span>
                <span class="font-semibold text-maroon-900 tabular-nums shrink-0">{{ number_format($it->total) }}</span>
            </li>
            @empty
            <li class="py-8 text-center text-sm text-charcoal-500">No interactions yet.</li>
            @endforelse
        </ul>
    </div>
</div>

{{-- Live active pages --}}
<div class="mt-5 bg-white rounded-sm border border-beige-200 shadow-sm p-5">
    <h2 class="font-display text-lg font-bold text-maroon-900">Live &middot; active in the last 5 minutes</h2>
    <ul id="live-pages" class="mt-3 divide-y divide-beige-100">
        @forelse ($live['pages'] as $lp)
        <li class="flex items-center justify-between py-2 text-sm">
            <span class="text-charcoal-700 truncate max-w-[75%]">{{ $lp->page }}</span>
            <span class="font-semibold text-emerald-700 tabular-nums">{{ $lp->visitors }}</span>
        </li>
        @empty
        <li class="py-6 text-center text-sm text-charcoal-500">No active visitors right now.</li>
        @endforelse
    </ul>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
(function () {
    var PALETTE = ['#C6A15B', '#7A1F2B', '#3E7C78', '#64748B', '#B08968', '#8E5572', '#4B7BA8', '#A8894B'];

    // Tint source legend dots to match the doughnut.
    document.querySelectorAll('[data-srccolor]').forEach(function (el) {
        el.style.background = PALETTE[parseInt(el.getAttribute('data-srccolor'), 10) % PALETTE.length];
    });

    if (typeof Chart === 'undefined') { return; }
    Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
    Chart.defaults.color = '#6b6b6b';

    // ---- Trend line ----
    var trend = @json($trend);
    var tctx = document.getElementById('trendChart');
    if (tctx) {
        new Chart(tctx, {
            type: 'line',
            data: {
                labels: trend.map(function (r) { return r.label; }),
                datasets: [
                    { label: 'Visitors', data: trend.map(function (r) { return r.visitors; }), borderColor: '#7A1F2B', backgroundColor: 'rgba(122,31,43,0.08)', fill: true, tension: 0.35, borderWidth: 2, pointRadius: 0, pointHoverRadius: 4 },
                    { label: 'Page views', data: trend.map(function (r) { return r.pageviews; }), borderColor: '#C6A15B', backgroundColor: 'rgba(198,161,91,0.08)', fill: true, tension: 0.35, borderWidth: 2, pointRadius: 0, pointHoverRadius: 4 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false },
                plugins: { legend: { display: false }, tooltip: { padding: 10, backgroundColor: '#2b2320' } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false }, ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 12 } }
                }
            }
        });
    }

    // ---- Sources doughnut ----
    var sources = @json($sources);
    var sctx = document.getElementById('sourcesChart');
    if (sctx && sources.length) {
        new Chart(sctx, {
            type: 'doughnut',
            data: { labels: sources.map(function (s) { return s.source; }),
                    datasets: [{ data: sources.map(function (s) { return s.visitors; }), backgroundColor: PALETTE, borderWidth: 2, borderColor: '#fff' }] },
            options: { responsive: true, maintainAspectRatio: false, cutout: '62%', plugins: { legend: { display: false }, tooltip: { backgroundColor: '#2b2320' } } }
        });
    }

    // ---- Devices doughnut ----
    var devices = @json($devices);
    var dctx = document.getElementById('devicesChart');
    if (dctx && devices.length) {
        new Chart(dctx, {
            type: 'doughnut',
            data: { labels: devices.map(function (d) { return d.device; }),
                    datasets: [{ data: devices.map(function (d) { return d.visitors; }), backgroundColor: ['#7A1F2B', '#C6A15B', '#3E7C78'], borderWidth: 2, borderColor: '#fff' }] },
            options: { responsive: true, maintainAspectRatio: false, cutout: '62%', plugins: { legend: { display: false }, tooltip: { backgroundColor: '#2b2320' } } }
        });
    }

    // ---- Live poll ----
    var liveCount = document.getElementById('live-count');
    var livePages = document.getElementById('live-pages');
    function refreshLive() {
        fetch('{{ route('admin.analytics.live') }}', { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (d) {
                if (liveCount) { liveCount.textContent = d.count; }
                if (livePages && d.pages) {
                    if (!d.pages.length) {
                        livePages.innerHTML = '<li class="py-6 text-center text-sm text-charcoal-500">No active visitors right now.</li>';
                    } else {
                        livePages.innerHTML = d.pages.map(function (p) {
                            return '<li class="flex items-center justify-between py-2 text-sm"><span class="text-charcoal-700 truncate max-w-[75%]"></span><span class="font-semibold text-emerald-700 tabular-nums"></span></li>';
                        }).join('');
                        var items = livePages.querySelectorAll('li');
                        d.pages.forEach(function (p, i) {
                            items[i].children[0].textContent = p.page;
                            items[i].children[1].textContent = p.visitors;
                        });
                    }
                }
            })
            .catch(function () {});
    }
    setInterval(refreshLive, 15000);
})();
</script>
@endsection
