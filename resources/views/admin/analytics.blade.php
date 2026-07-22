@extends('admin.layout')
@section('title', 'Analytics')

@section('content')
<h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900 mb-6">Website Analytics</h1>

{{-- ===== Live now (real-time) ===== --}}
<div class="mb-8 bg-white rounded-sm shadow-sm border border-beige-200 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-3.5 bg-maroon-950">
        <div class="flex items-center gap-2.5">
            <span class="relative flex h-2.5 w-2.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background:#22c55e"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5" style="background:#22c55e"></span></span>
            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-ivory/85">Live now</span>
        </div>
        <span class="text-[11px] text-ivory/45 uppercase tracking-wide">Updates every 15s</span>
    </div>
    <div class="grid sm:grid-cols-[minmax(0,10rem)_1fr] gap-6 p-6">
        <div class="flex sm:flex-col items-center sm:items-start gap-3 sm:gap-1 sm:pr-6 sm:border-r border-beige-200">
            <p class="font-display text-5xl font-bold text-maroon-900 tabular-nums leading-none" id="live-count">{{ $live['count'] }}</p>
            <p class="text-xs text-charcoal-600 uppercase tracking-wide">Visitors on site now</p>
        </div>
        <div class="min-w-0">
            <p class="text-xs text-charcoal-600 uppercase tracking-wide mb-3">Active pages (last 5 min)</p>
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
<div class="space-y-8">

    {{-- ===== Headline cards ===== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cardDefs = [
                ['label' => 'Visitors Today', 'value' => $cards['visitors_today']],
                ['label' => 'Visitors (7 days)', 'value' => $cards['visitors_7d']],
                ['label' => 'Pageviews (7 days)', 'value' => $cards['pageviews_7d']],
                ['label' => 'Leads (7 days)', 'value' => $cards['leads_7d']],
            ];
        @endphp
        @foreach ($cardDefs as $card)
        <div class="bg-white rounded-sm border border-beige-200 shadow-sm p-6">
            <p class="text-xs uppercase tracking-wider text-charcoal-600">{{ $card['label'] }}</p>
            <p class="mt-2 font-display text-4xl font-bold text-maroon-900 tabular-nums">{{ number_format($card['value']) }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        {{-- ===== Funnel ===== --}}
        <section class="bg-white rounded-sm border border-beige-200 shadow-sm p-7">
            <h2 class="font-display text-xl font-semibold text-maroon-900">Admissions Funnel <span class="text-sm font-sans font-normal text-charcoal-600">— last 30 days, unique visitors</span></h2>
            <div class="mt-6 space-y-5">
                @foreach ($funnel as $i => $step)
                @php
                    $pct = $funnelMax ? round($step['count'] / $funnelMax * 100) : 0;
                    $prev = $i > 0 ? $funnel[$i-1]['count'] : null;
                    $conv = $prev ? round($step['count'] / max(1, $prev) * 100) : null;
                @endphp
                <div>
                    <div class="flex items-baseline justify-between gap-4 text-sm">
                        <span class="font-medium text-charcoal-800">{{ $i + 1 }}. {{ $step['label'] }}</span>
                        <span class="tabular-nums font-semibold text-maroon-900">{{ number_format($step['count']) }}
                            @if ($conv !== null)<span class="text-xs font-normal text-charcoal-600">({{ $conv }}% of prev.)</span>@endif
                        </span>
                    </div>
                    <div class="mt-1.5 h-5 bg-beige-100 rounded-sm overflow-hidden" role="img" aria-label="{{ $step['label'] }}: {{ $step['count'] }} visitors, {{ $pct }}% of total">
                        <div class="h-full bg-maroon-800 rounded-sm" style="width: {{ max($pct, $step['count'] > 0 ? 2 : 0) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @if ($funnelMax <= 1)
            <p class="mt-5 text-sm text-charcoal-600">Not enough traffic yet — the funnel fills in as visitors browse the site.</p>
            @endif
        </section>

        {{-- ===== Daily visitors ===== --}}
        <section class="bg-white rounded-sm border border-beige-200 shadow-sm p-7">
            <h2 class="font-display text-xl font-semibold text-maroon-900">Daily Visitors <span class="text-sm font-sans font-normal text-charcoal-600">— last 14 days</span></h2>
            <div class="mt-6 flex items-end gap-1.5 h-44" role="img" aria-label="Daily unique visitors bar chart for the last 14 days">
                @foreach ($days as $day)
                <div class="flex-1 flex flex-col items-center gap-1 min-w-0 group">
                    <span class="text-[10px] tabular-nums text-charcoal-600 opacity-0 group-hover:opacity-100 transition-opacity">{{ $day['visitors'] }}</span>
                    <div class="w-full bg-maroon-800 hover:bg-maroon-700 transition-colors rounded-t-sm" style="height: {{ max(2, round($day['visitors'] / $dailyMax * 130)) }}px" title="{{ $day['date'] }}: {{ $day['visitors'] }} visitors"></div>
                    <span class="text-[9px] text-charcoal-600 whitespace-nowrap {{ $loop->index % 2 ? 'hidden sm:block' : '' }}">{{ $day['date'] }}</span>
                </div>
                @endforeach
            </div>
        </section>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        {{-- ===== Top pages ===== --}}
        <section class="lg:col-span-1 bg-white rounded-sm border border-beige-200 shadow-sm p-7">
            <h2 class="font-display text-xl font-semibold text-maroon-900">Top Pages <span class="text-sm font-sans font-normal text-charcoal-600">— 30 days</span></h2>
            <table class="mt-4 w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider text-charcoal-600 border-b border-beige-200">
                        <th class="py-2.5 font-semibold">Page</th>
                        <th class="py-2.5 font-semibold text-right">Views</th>
                        <th class="py-2.5 font-semibold text-right">Visitors</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topPages as $p)
                    <tr class="border-b border-beige-100 last:border-0">
                        <td class="py-2.5 pr-2 font-medium text-maroon-900 break-all">{{ $p->page }}</td>
                        <td class="py-2.5 text-right tabular-nums">{{ number_format($p->views) }}</td>
                        <td class="py-2.5 text-right tabular-nums text-charcoal-600">{{ number_format($p->visitors) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="py-8 text-center text-charcoal-600">No pageviews recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        {{-- ===== Top interactions ===== --}}
        <section class="lg:col-span-1 bg-white rounded-sm border border-beige-200 shadow-sm p-7">
            <h2 class="font-display text-xl font-semibold text-maroon-900">Top Interactions <span class="text-sm font-sans font-normal text-charcoal-600">— 30 days</span></h2>
            <table class="mt-4 w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider text-charcoal-600 border-b border-beige-200">
                        <th class="py-2.5 font-semibold">Event</th>
                        <th class="py-2.5 font-semibold">Label</th>
                        <th class="py-2.5 font-semibold text-right">Count</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($interactions as $i)
                    <tr class="border-b border-beige-100 last:border-0">
                        <td class="py-2.5 pr-2">
                            <span class="inline-block text-[11px] font-semibold bg-gold-100 text-gold-800 px-2 py-0.5 rounded-full">{{ $i->event }}</span>
                        </td>
                        <td class="py-2.5 pr-2 text-charcoal-700 break-all">{{ $i->label ?: '—' }}</td>
                        <td class="py-2.5 text-right tabular-nums font-semibold text-maroon-900">{{ number_format($i->total) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="py-8 text-center text-charcoal-600">No interactions recorded yet — clicks on CTAs, WhatsApp and calls will appear here.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        {{-- ===== Traffic sources ===== --}}
        <section class="lg:col-span-1 bg-white rounded-sm border border-beige-200 shadow-sm p-7">
            <h2 class="font-display text-xl font-semibold text-maroon-900">Traffic Sources <span class="text-sm font-sans font-normal text-charcoal-600">— 30 days</span></h2>
            @php $srcMax = max(1, $sources->max('visitors') ?? 1); @endphp
            <div class="mt-5 space-y-4">
                @forelse ($sources as $s)
                <div>
                    <div class="flex items-baseline justify-between text-sm">
                        <span class="font-medium text-charcoal-800">{{ $s->source }}</span>
                        <span class="tabular-nums font-semibold text-maroon-900">{{ number_format($s->visitors) }}</span>
                    </div>
                    <div class="mt-1 h-3 bg-beige-100 rounded-sm overflow-hidden">
                        <div class="h-full bg-gold-500 rounded-sm" style="width: {{ max(3, round($s->visitors / $srcMax * 100)) }}%"></div>
                    </div>
                </div>
                @empty
                <p class="py-6 text-center text-sm text-charcoal-600">No traffic recorded yet.</p>
                @endforelse
            </div>
            <p class="mt-6 text-xs text-charcoal-600/80 leading-relaxed">
                Tip: add <code>?utm_source=facebook&amp;utm_medium=cpc&amp;utm_campaign=admissions</code> to your ad links —
                sources will break down automatically here.
            </p>
        </section>
    </div>

</div>
@endsection
