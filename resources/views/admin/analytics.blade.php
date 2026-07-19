<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Analytics — KVS Admin</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/favicon.ico" sizes="any">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-beige-100 text-charcoal-800">

<header class="bg-maroon-950 text-ivory">
    <div class="container-site flex items-center justify-between py-3.5">
        <div class="flex items-center gap-3">
            <img src="/images/logo-mark.png" alt="" class="h-10 w-auto">
            <span class="leading-tight">
                <span class="block font-display font-bold text-lg">KVS Admin</span>
                <span class="block text-[11px] tracking-[0.2em] uppercase text-gold-400">Website Analytics</span>
            </span>
        </div>
        <nav class="flex items-center gap-5 text-sm">
            <a href="{{ route('admin.leads') }}" class="text-ivory/70 hover:text-gold-300 transition-colors">Leads</a>
            <a href="{{ route('admin.analytics') }}" class="font-semibold text-gold-400">Analytics</a>
            <a href="{{ route('home') }}" class="text-ivory/70 hover:text-gold-300 transition-colors">View website</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="font-semibold text-gold-400 hover:text-gold-300 transition-colors cursor-pointer">Log out</button>
            </form>
        </nav>
    </div>
</header>

<main class="container-site py-8 sm:py-10 space-y-8">

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

</main>

</body>
</html>
