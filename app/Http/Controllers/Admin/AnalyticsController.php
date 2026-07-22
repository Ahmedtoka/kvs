<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\TrackingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $today = now()->startOfDay();
        $week = now()->subDays(7);
        $month = now()->subDays(30);

        // ---- Headline cards ----
        $cards = [
            'visitors_today' => TrackingEvent::where('event', 'pageview')->where('created_at', '>=', $today)->distinct('visitor_id')->count('visitor_id'),
            'visitors_7d'    => TrackingEvent::where('event', 'pageview')->where('created_at', '>=', $week)->distinct('visitor_id')->count('visitor_id'),
            'pageviews_7d'   => TrackingEvent::where('event', 'pageview')->where('created_at', '>=', $week)->count(),
            'leads_7d'       => Lead::where('created_at', '>=', $week)->count(),
        ];

        // ---- Funnel (last 30 days, unique visitors per step) ----
        $step1 = TrackingEvent::where('event', 'pageview')->where('created_at', '>=', $month)
            ->distinct('visitor_id')->count('visitor_id');

        $step2 = TrackingEvent::where('event', 'pageview')->where('created_at', '>=', $month)
            ->where(fn ($q) => $q->where('page', 'like', '/academics%')
                ->orWhere('page', 'like', '/admissions%')
                ->orWhere('page', 'like', '/school-life%')
                ->orWhere('page', 'like', '/events%'))
            ->distinct('visitor_id')->count('visitor_id');

        $step3 = TrackingEvent::whereIn('event', ['form_view'])->where('created_at', '>=', $month)
            ->distinct('visitor_id')->count('visitor_id');

        $step4 = TrackingEvent::where('event', 'form_submit')->where('created_at', '>=', $month)
            ->distinct('visitor_id')->count('visitor_id');

        $leadsMonth = Lead::where('created_at', '>=', $month)->count();

        $funnel = [
            ['label' => 'Visited the website',            'count' => $step1],
            ['label' => 'Explored academics / admissions', 'count' => $step2],
            ['label' => 'Viewed the booking form',         'count' => $step3],
            ['label' => 'Submitted a request',             'count' => max($step4, min($leadsMonth, $step1))],
        ];
        $funnelMax = max(1, $step1);

        // ---- Top pages (30d) ----
        $topPages = TrackingEvent::select('page', DB::raw('COUNT(*) as views'), DB::raw('COUNT(DISTINCT visitor_id) as visitors'))
            ->where('event', 'pageview')->where('created_at', '>=', $month)
            ->groupBy('page')->orderByDesc('views')->limit(12)->get();

        // ---- Top interactions (30d) ----
        $interactions = TrackingEvent::select('event', 'label', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $month)
            ->whereIn('event', ['cta_click', 'see_all_click', 'whatsapp_click', 'call_click', 'nav_click'])
            ->groupBy('event', 'label')->orderByDesc('total')->limit(12)->get();

        // ---- Daily unique visitors, last 14 days ----
        $daily = TrackingEvent::select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(DISTINCT visitor_id) as visitors'))
            ->where('event', 'pageview')->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('day')->orderBy('day')->get()->keyBy('day');

        $days = collect(range(13, 0))->map(function ($i) use ($daily) {
            $key = now()->subDays($i)->toDateString();
            return [
                'date'     => now()->subDays($i)->format('d M'),
                'visitors' => (int) ($daily[$key]->visitors ?? 0),
            ];
        });
        $dailyMax = max(1, $days->max('visitors'));

        // ---- Traffic sources (30d) ----
        $sources = TrackingEvent::select(
                DB::raw("COALESCE(NULLIF(utm_source, ''), CASE WHEN referrer IS NULL OR referrer = '' THEN 'Direct' ELSE 'Referral' END) as source"),
                DB::raw('COUNT(DISTINCT visitor_id) as visitors'))
            ->where('event', 'pageview')->where('created_at', '>=', $month)
            ->groupBy('source')->orderByDesc('visitors')->limit(8)->get();

        // ---- Visitors by device (30d) ----
        $devices = TrackingEvent::select('device', DB::raw('COUNT(DISTINCT visitor_id) as visitors'))
            ->where('event', 'pageview')->where('created_at', '>=', $month)
            ->whereNotNull('device')->groupBy('device')->orderByDesc('visitors')->get();

        // ---- Live visitors (active in the last 5 minutes) ----
        $live = $this->liveData();

        return view('admin.analytics', compact('cards', 'funnel', 'funnelMax', 'topPages', 'interactions', 'days', 'dailyMax', 'sources', 'devices', 'live'));
    }

    /**
     * User-Flow report: where visitors enter, where they leave, the journeys
     * they take, and which traffic sources / campaigns actually convert.
     */
    public function flow(Request $request): View
    {
        $from = $request->filled('from')
            ? Carbon::parse($request->input('from'))->startOfDay()
            : now()->subDays(30)->startOfDay();
        $to = $request->filled('to')
            ? Carbon::parse($request->input('to'))->endOfDay()
            : now()->endOfDay();
        if ($from->gt($to)) {
            [$from, $to] = [$to->copy()->startOfDay(), $from->copy()->endOfDay()];
        }
        $between = [$from, $to];

        // ---- Headline KPIs ----
        $visitors = TrackingEvent::where('event', 'pageview')->whereBetween('created_at', $between)
            ->distinct('visitor_id')->count('visitor_id');
        $pageviews = TrackingEvent::where('event', 'pageview')->whereBetween('created_at', $between)->count();
        $conversions = TrackingEvent::where('event', 'conversion')->whereBetween('created_at', $between)->count();

        $kpis = [
            'visitors'    => $visitors,
            'pageviews'   => $pageviews,
            'conversions' => $conversions,
            'rate'        => $visitors > 0 ? round($conversions / $visitors * 100, 1) : 0.0,
            'avg_pages'   => $visitors > 0 ? round($pageviews / $visitors, 1) : 0.0,
        ];

        // ---- Entry pages (first pageview per visitor) ----
        $firstSub = DB::table('tracking_events')
            ->select('visitor_id', DB::raw('MIN(id) as edge_id'))
            ->where('event', 'pageview')->whereBetween('created_at', $between)
            ->groupBy('visitor_id');
        $entryPages = DB::table('tracking_events as e')
            ->joinSub($firstSub, 'f', fn ($j) => $j->on('e.id', '=', 'f.edge_id'))
            ->select('e.page', DB::raw('COUNT(*) as total'))
            ->groupBy('e.page')->orderByDesc('total')->limit(12)->get();

        // ---- Exit pages (last pageview per visitor) ----
        $lastSub = DB::table('tracking_events')
            ->select('visitor_id', DB::raw('MAX(id) as edge_id'))
            ->where('event', 'pageview')->whereBetween('created_at', $between)
            ->groupBy('visitor_id');
        $exitPages = DB::table('tracking_events as e')
            ->joinSub($lastSub, 'l', fn ($j) => $j->on('e.id', '=', 'l.edge_id'))
            ->select('e.page', DB::raw('COUNT(*) as total'))
            ->groupBy('e.page')->orderByDesc('total')->limit(12)->get();

        // ---- Top journeys (page sequences, consecutive duplicates collapsed) ----
        $rows = DB::table('tracking_events')
            ->select('visitor_id', 'page')
            ->where('event', 'pageview')->whereBetween('created_at', $between)
            ->orderBy('visitor_id')->orderBy('id')
            ->limit(20000)->get();

        $paths = [];
        foreach ($rows->groupBy('visitor_id') as $events) {
            $seq = [];
            foreach ($events as $e) {
                if (empty($seq) || end($seq) !== $e->page) {
                    $seq[] = $e->page;
                }
            }
            $seq = array_slice($seq, 0, 5);
            $key = implode('  |  ', $seq);
            $paths[$key] = ($paths[$key] ?? 0) + 1;
        }
        arsort($paths);
        $topPaths = array_slice($paths, 0, 12, true);
        $pathsCapped = $rows->count() >= 20000;

        // ---- Conversions by form type ----
        $convByType = TrackingEvent::select('label', DB::raw('COUNT(*) as total'))
            ->where('event', 'conversion')->whereBetween('created_at', $between)
            ->groupBy('label')->orderByDesc('total')->get();

        // ---- Traffic-source performance (visitors vs conversions vs rate) ----
        $srcVisitors = DB::table('tracking_events')
            ->select(DB::raw("COALESCE(NULLIF(utm_source, ''), 'Direct / Organic') as source"),
                     DB::raw('COUNT(DISTINCT visitor_id) as visitors'))
            ->where('event', 'pageview')->whereBetween('created_at', $between)
            ->groupBy('source')->get()->keyBy('source');

        $srcConversions = DB::table('tracking_events')
            ->select(DB::raw("COALESCE(NULLIF(utm_source, ''), 'Direct / Organic') as source"),
                     DB::raw('COUNT(*) as conversions'))
            ->where('event', 'conversion')->whereBetween('created_at', $between)
            ->groupBy('source')->get()->keyBy('source');

        $adsPerformance = collect($srcVisitors->keys()->merge($srcConversions->keys())->unique())
            ->map(function ($source) use ($srcVisitors, $srcConversions) {
                $v = (int) ($srcVisitors[$source]->visitors ?? 0);
                $c = (int) ($srcConversions[$source]->conversions ?? 0);
                return [
                    'source'      => $source,
                    'visitors'    => $v,
                    'conversions' => $c,
                    'rate'        => $v > 0 ? round($c / $v * 100, 1) : 0.0,
                ];
            })
            ->sortByDesc('visitors')->values()->take(12);

        // ---- Campaign-level conversions (real UTM campaigns only) ----
        $campaigns = DB::table('tracking_events')
            ->select(
                DB::raw("COALESCE(NULLIF(utm_source, ''), 'Direct') as source"),
                DB::raw('utm_campaign as campaign'),
                DB::raw('COUNT(*) as conversions'))
            ->where('event', 'conversion')->whereBetween('created_at', $between)
            ->whereNotNull('utm_campaign')->where('utm_campaign', '!=', '')
            ->groupBy('source', 'campaign')->orderByDesc('conversions')->limit(15)->get();

        // ---- Device split (visitors + conversions) ----
        $deviceVisitors = DB::table('tracking_events')
            ->select('device', DB::raw('COUNT(DISTINCT visitor_id) as v'))
            ->where('event', 'pageview')->whereBetween('created_at', $between)->whereNotNull('device')
            ->groupBy('device')->pluck('v', 'device');
        $deviceConversions = DB::table('tracking_events')
            ->select('device', DB::raw('COUNT(*) as c'))
            ->where('event', 'conversion')->whereBetween('created_at', $between)->whereNotNull('device')
            ->groupBy('device')->pluck('c', 'device');
        $deviceSplit = collect(['mobile', 'desktop', 'tablet'])->map(fn ($d) => [
            'device'      => $d,
            'visitors'    => (int) ($deviceVisitors[$d] ?? 0),
            'conversions' => (int) ($deviceConversions[$d] ?? 0),
        ])->filter(fn ($r) => $r['visitors'] > 0 || $r['conversions'] > 0)->values();

        $typeLabels = Lead::TYPES + ['career' => 'Career Application'];

        return view('admin.flow', compact(
            'from', 'to', 'kpis', 'entryPages', 'exitPages',
            'topPaths', 'pathsCapped', 'convByType', 'adsPerformance', 'campaigns', 'deviceSplit', 'typeLabels'
        ));
    }

    /**
     * Per-visitor device report — one row per anonymous visitor (device),
     * so the media buyer can see visitors one by one.
     */
    public function visitors(Request $request): View
    {
        $device = $request->input('device');

        $query = DB::table('tracking_events')
            ->select(
                'visitor_id',
                DB::raw('MAX(device) as device'),
                DB::raw("SUM(event = 'pageview') as pageviews"),
                DB::raw("SUM(event = 'conversion') as conversions"),
                DB::raw("MAX(NULLIF(utm_source, '')) as utm_source"),
                DB::raw("MAX(NULLIF(referrer, '')) as referrer"),
                DB::raw('MIN(created_at) as first_seen'),
                DB::raw('MAX(created_at) as last_seen'))
            ->groupBy('visitor_id')
            ->orderByRaw('MAX(created_at) DESC');

        if (in_array($device, ['mobile', 'desktop', 'tablet'], true)) {
            $query->havingRaw('MAX(device) = ?', [$device]);
        }

        $visitors = $query->paginate(30)->withQueryString();

        $totals = [
            'all'      => TrackingEvent::distinct('visitor_id')->count('visitor_id'),
            'mobile'   => $this->deviceCount('mobile'),
            'desktop'  => $this->deviceCount('desktop'),
            'tablet'   => $this->deviceCount('tablet'),
        ];

        return view('admin.visitors', compact('visitors', 'totals', 'device'));
    }

    /** Full journey for a single visitor: every action, in order, with dwell time. */
    public function visitorShow(Request $request, string $visitor): View
    {
        $events = TrackingEvent::where('visitor_id', $visitor)->orderBy('id')->get();
        abort_if($events->isEmpty(), 404);

        $first = $events->first();
        $last  = $events->last();
        $pageviews   = $events->where('event', 'pageview');
        $conversions = $events->where('event', 'conversion');

        $device      = $events->pluck('device')->filter()->last() ?? 'unknown';
        $utmSource   = $events->pluck('utm_source')->filter()->first();
        $utmCampaign = $events->pluck('utm_campaign')->filter()->first();
        $referrer    = $events->pluck('referrer')->filter()->first();

        $summary = [
            'total_events' => $events->count(),
            'pageviews'    => $pageviews->count(),
            'conversions'  => $conversions->count(),
            'duration'     => (int) abs($first->created_at->diffInSeconds($last->created_at)),
            'entry'        => optional($pageviews->first())->page,
            'exit'         => optional($pageviews->last())->page,
            'source'       => $utmSource ?: ($referrer ? 'Referral' : 'Direct'),
            'campaign'     => $utmCampaign,
        ];

        // Timeline with dwell time (gap to next event); a gap > 30 min starts a new session.
        $list = $events->values();
        $timeline = [];
        foreach ($list as $i => $e) {
            $next = $list[$i + 1] ?? null;
            $gap  = $next ? (int) abs($e->created_at->diffInSeconds($next->created_at)) : null;
            $break = $gap !== null && $gap > 1800;
            $timeline[] = [
                'event'  => $e->event,
                'page'   => $e->page,
                'label'  => $e->label,
                'at'     => $e->created_at,
                'dwell'  => ($gap !== null && ! $break) ? $gap : null,
                'break'  => $break,
            ];
        }

        return view('admin.visitor-show', compact('visitor', 'device', 'summary', 'timeline', 'first', 'last'));
    }

    private function deviceCount(string $device): int
    {
        return TrackingEvent::where('device', $device)->distinct('visitor_id')->count('visitor_id');
    }

    /** JSON endpoint polled by the dashboard for real-time visitor counts. */
    public function live(): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->liveData());
    }

    private function liveData(): array
    {
        $window = now()->subMinutes(5);

        return [
            'count' => TrackingEvent::where('created_at', '>=', $window)->distinct('visitor_id')->count('visitor_id'),
            'pages' => TrackingEvent::select('page', DB::raw('COUNT(DISTINCT visitor_id) as visitors'))
                ->where('event', 'pageview')->where('created_at', '>=', $window)
                ->groupBy('page')->orderByDesc('visitors')->limit(10)->get(),
        ];
    }
}
