<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\TrackingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    /** Advanced analytics dashboard with a date-range filter (defaults to today). */
    public function index(Request $request): View
    {
        [$from, $to, $rangeKey, $prevFrom, $prevTo] = $this->resolveRange($request);
        $cur  = [$from, $to];
        $prev = [$prevFrom, $prevTo];

        // ---- Core metrics (current + previous period for deltas) ----
        $visitors      = $this->uniqueVisitors($cur);
        $visitorsPrev  = $this->uniqueVisitors($prev);
        $visits        = $this->visits($cur);
        $visitsPrev    = $this->visits($prev);
        $pageviews     = TrackingEvent::where('event', 'pageview')->whereBetween('created_at', $cur)->count();
        $pageviewsPrev = TrackingEvent::where('event', 'pageview')->whereBetween('created_at', $prev)->count();
        $leads         = Lead::whereBetween('created_at', $cur)->count();
        $leadsPrev     = Lead::whereBetween('created_at', $prev)->count();

        $ppv     = $visits > 0 ? round($pageviews / $visits, 1) : 0.0;
        $ppvPrev = $visitsPrev > 0 ? round($pageviewsPrev / $visitsPrev, 1) : 0.0;
        $conv     = $visitors > 0 ? round($leads / $visitors * 100, 1) : 0.0;
        $convPrev = $visitorsPrev > 0 ? round($leadsPrev / $visitorsPrev * 100, 1) : 0.0;

        $cards = [
            ['key' => 'visitors',  'label' => 'Unique Visitors', 'value' => number_format($visitors),  'delta' => $this->delta($visitors, $visitorsPrev),   'hint' => 'Distinct devices'],
            ['key' => 'visits',    'label' => 'Visits',          'value' => number_format($visits),    'delta' => $this->delta($visits, $visitsPrev),       'hint' => 'Browsing sessions'],
            ['key' => 'pageviews', 'label' => 'Page Views',      'value' => number_format($pageviews), 'delta' => $this->delta($pageviews, $pageviewsPrev), 'hint' => 'Pages opened'],
            ['key' => 'ppv',       'label' => 'Pages / Visit',   'value' => number_format($ppv, 1),    'delta' => $this->delta($ppv, $ppvPrev),             'hint' => 'Depth of interest'],
            ['key' => 'leads',     'label' => 'Leads',           'value' => number_format($leads),     'delta' => $this->delta($leads, $leadsPrev),         'hint' => 'Form submissions'],
            ['key' => 'conv',      'label' => 'Conversion Rate', 'value' => $conv . '%',               'delta' => $this->delta($conv, $convPrev),           'hint' => 'Leads / visitors'],
        ];

        $trend       = $this->trend($from, $to);
        $sources     = $this->sources($cur);
        $devices     = $this->devices($cur);
        $topPages    = $this->topPages($cur);
        $entryPages  = $this->entryPages($cur);
        $interactions = TrackingEvent::select('event', 'label', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', $cur)
            ->whereIn('event', ['cta_click', 'see_all_click', 'whatsapp_click', 'call_click', 'nav_click'])
            ->groupBy('event', 'label')->orderByDesc('total')->limit(12)->get();
        $funnel      = $this->funnel($cur);
        $engagement  = $this->engagement($cur, $from, $visitors);
        $live        = $this->liveData();

        return view('admin.analytics', compact(
            'cards', 'trend', 'sources', 'devices', 'topPages', 'entryPages',
            'interactions', 'funnel', 'engagement', 'live', 'from', 'to', 'rangeKey'
        ));
    }

    /* ===================== Metric helpers ===================== */

    /** @return array{0:Carbon,1:Carbon,2:string,3:Carbon,4:Carbon} */
    private function resolveRange(Request $request): array
    {
        $key = (string) $request->input('range', 'today');
        $now = now();

        switch ($key) {
            case 'yesterday':
                $from = $now->copy()->subDay()->startOfDay();
                $to   = $now->copy()->subDay()->endOfDay();
                break;
            case '7d':
                $from = $now->copy()->subDays(6)->startOfDay();
                $to   = $now->copy()->endOfDay();
                break;
            case '30d':
                $from = $now->copy()->subDays(29)->startOfDay();
                $to   = $now->copy()->endOfDay();
                break;
            case 'custom':
                $from = $request->filled('from') ? Carbon::parse($request->input('from'))->startOfDay() : $now->copy()->startOfDay();
                $to   = $request->filled('to') ? Carbon::parse($request->input('to'))->endOfDay() : $now->copy()->endOfDay();
                if ($from->gt($to)) {
                    [$from, $to] = [$to->copy()->startOfDay(), $from->copy()->endOfDay()];
                }
                break;
            case 'today':
            default:
                $key  = 'today';
                $from = $now->copy()->startOfDay();
                $to   = $now->copy()->endOfDay();
                break;
        }

        // Previous comparable window (same length, immediately before).
        $lengthSec = $to->getTimestamp() - $from->getTimestamp();
        $prevTo    = $from->copy()->subSecond();
        $prevFrom  = $prevTo->copy()->subSeconds($lengthSec);

        return [$from, $to, $key, $prevFrom, $prevTo];
    }

    private function uniqueVisitors(array $between): int
    {
        return TrackingEvent::where('event', 'pageview')->whereBetween('created_at', $between)
            ->distinct('visitor_id')->count('visitor_id');
    }

    /** A "visit" = a browsing session. Falls back to unique visitors if sessions are absent. */
    private function visits(array $between): int
    {
        $sessions = TrackingEvent::where('event', 'pageview')->whereBetween('created_at', $between)
            ->whereNotNull('session_id')->distinct('session_id')->count('session_id');

        return $sessions > 0 ? $sessions : $this->uniqueVisitors($between);
    }

    /** @return array{dir:string,pct:?int,new:bool} */
    private function delta($cur, $prev): array
    {
        $cur = (float) $cur;
        $prev = (float) $prev;
        if ($prev <= 0) {
            return ['dir' => $cur > 0 ? 'up' : 'flat', 'pct' => null, 'new' => $cur > 0];
        }
        $change = (int) round(($cur - $prev) / $prev * 100);

        return ['dir' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'flat'), 'pct' => abs($change), 'new' => false];
    }

    private function trend(Carbon $from, Carbon $to): array
    {
        $hourly = $from->diffInHours($to) <= 26;

        if ($hourly) {
            $rows = TrackingEvent::where('event', 'pageview')->whereBetween('created_at', [$from, $to])
                ->selectRaw('HOUR(created_at) as slot, COUNT(DISTINCT visitor_id) as visitors, COUNT(*) as pageviews')
                ->groupBy('slot')->get()->keyBy('slot');

            return collect(range(0, 23))->map(fn ($h) => [
                'label'     => sprintf('%02d:00', $h),
                'visitors'  => (int) ($rows[$h]->visitors ?? 0),
                'pageviews' => (int) ($rows[$h]->pageviews ?? 0),
            ])->all();
        }

        $rows = TrackingEvent::where('event', 'pageview')->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as slot, COUNT(DISTINCT visitor_id) as visitors, COUNT(*) as pageviews')
            ->groupBy('slot')->get()->keyBy('slot');

        $out = [];
        $cursor = $from->copy()->startOfDay();
        $endDay = $to->copy()->startOfDay();
        $guard = 0;
        while ($cursor->lte($endDay) && $guard < 400) {
            $key = $cursor->toDateString();
            $out[] = [
                'label'     => $cursor->format('d M'),
                'visitors'  => (int) ($rows[$key]->visitors ?? 0),
                'pageviews' => (int) ($rows[$key]->pageviews ?? 0),
            ];
            $cursor->addDay();
            $guard++;
        }

        return $out;
    }

    /** First-touch traffic sources, classified into channels (internal navigation excluded). */
    private function sources(array $between): Collection
    {
        $firstSub = DB::table('tracking_events')
            ->select('visitor_id', DB::raw('MIN(id) as edge_id'))
            ->where('event', 'pageview')->whereBetween('created_at', $between)
            ->groupBy('visitor_id');

        $rows = DB::table('tracking_events as e')
            ->joinSub($firstSub, 'f', fn ($j) => $j->on('e.id', '=', 'f.edge_id'))
            ->select('e.referrer', 'e.utm_source')
            ->get();

        $host = request()->getHost();
        $tally = [];
        foreach ($rows as $r) {
            $channel = $this->classifyChannel($r->referrer, $r->utm_source, $host);
            if ($channel === 'Internal') {
                continue;
            }
            $tally[$channel] = ($tally[$channel] ?? 0) + 1;
        }
        arsort($tally);

        return collect($tally)->map(fn ($v, $k) => ['source' => $k, 'visitors' => $v])->values();
    }

    private function classifyChannel(?string $ref, ?string $utm, string $host): string
    {
        $utm = trim((string) $utm);
        if ($utm !== '') {
            return ucfirst(strtolower($utm)); // paid / campaign (e.g. facebook, google, tiktok)
        }
        $ref = trim((string) $ref);
        if ($ref === '') {
            return 'Direct';
        }
        $h = strtolower((string) parse_url($ref, PHP_URL_HOST));
        $h = (string) preg_replace('/^www\./', '', $h);
        if ($h === '') {
            return 'Direct';
        }
        if ($h === strtolower($host)) {
            return 'Internal';
        }
        if (preg_match('/(google|bing|yahoo|duckduckgo|ecosia|yandex)\./', $h)) {
            return 'Organic Search';
        }
        if (preg_match('/facebook|fb\.|instagram|t\.co|twitter|x\.com|tiktok|youtube|youtu\.be|linkedin|wa\.me|whatsapp|t\.me|telegram|pinterest/', $h)) {
            return 'Social';
        }

        return 'Referral';
    }

    private function devices(array $between): Collection
    {
        $rows = DB::table('tracking_events')
            ->select('device', DB::raw('COUNT(DISTINCT visitor_id) as v'))
            ->where('event', 'pageview')->whereBetween('created_at', $between)->whereNotNull('device')
            ->groupBy('device')->pluck('v', 'device');

        return collect(['mobile', 'desktop', 'tablet'])
            ->map(fn ($d) => ['device' => $d, 'visitors' => (int) ($rows[$d] ?? 0)])
            ->filter(fn ($r) => $r['visitors'] > 0)->values();
    }

    private function topPages(array $between): Collection
    {
        return TrackingEvent::select('page', DB::raw('COUNT(*) as views'), DB::raw('COUNT(DISTINCT visitor_id) as visitors'))
            ->where('event', 'pageview')->whereBetween('created_at', $between)
            ->groupBy('page')->orderByDesc('views')->limit(10)->get();
    }

    private function entryPages(array $between): Collection
    {
        $firstSub = DB::table('tracking_events')
            ->select('visitor_id', DB::raw('MIN(id) as edge_id'))
            ->where('event', 'pageview')->whereBetween('created_at', $between)
            ->groupBy('visitor_id');

        return DB::table('tracking_events as e')
            ->joinSub($firstSub, 'f', fn ($j) => $j->on('e.id', '=', 'f.edge_id'))
            ->select('e.page', DB::raw('COUNT(*) as total'))
            ->groupBy('e.page')->orderByDesc('total')->limit(8)->get();
    }

    private function funnel(array $between): array
    {
        $step1 = $this->uniqueVisitors($between);
        $step2 = TrackingEvent::where('event', 'pageview')->whereBetween('created_at', $between)
            ->where(fn ($q) => $q->where('page', 'like', '/academics%')
                ->orWhere('page', 'like', '/admissions%')
                ->orWhere('page', 'like', '/school-life%')
                ->orWhere('page', 'like', '/events%')
                ->orWhere('page', 'like', '/fees%'))
            ->distinct('visitor_id')->count('visitor_id');
        $step3 = TrackingEvent::where('event', 'form_view')->whereBetween('created_at', $between)
            ->distinct('visitor_id')->count('visitor_id');
        $step4 = TrackingEvent::whereIn('event', ['form_submit', 'conversion'])->whereBetween('created_at', $between)
            ->distinct('visitor_id')->count('visitor_id');

        return [
            'max'   => max(1, $step1),
            'steps' => [
                ['label' => 'Visited the site',        'count' => $step1],
                ['label' => 'Explored key pages',      'count' => $step2],
                ['label' => 'Viewed the booking form', 'count' => $step3],
                ['label' => 'Submitted a request',     'count' => $step4],
            ],
        ];
    }

    private function engagement(array $between, Carbon $from, int $visitors): array
    {
        // Bounce: sessions with a single pageview.
        $sessionCounts = DB::table('tracking_events')
            ->select('session_id', DB::raw('COUNT(*) as c'))
            ->where('event', 'pageview')->whereBetween('created_at', $between)
            ->whereNotNull('session_id')->groupBy('session_id');
        $b = DB::query()->fromSub($sessionCounts, 's')
            ->selectRaw('SUM(CASE WHEN c = 1 THEN 1 ELSE 0 END) as bounces, COUNT(*) as total')->first();
        $bounceRate = ($b && $b->total > 0) ? (int) round($b->bounces / $b->total * 100) : 0;

        // Deep scroll: visitors who reached 75% of a page.
        $scrollers = TrackingEvent::where('event', 'scroll_75')->whereBetween('created_at', $between)
            ->distinct('visitor_id')->count('visitor_id');
        $scrollRate = $visitors > 0 ? (int) round($scrollers / $visitors * 100) : 0;

        // New vs returning (first-ever pageview inside this window = new).
        $newVisitors = DB::query()->fromSub(
            DB::table('tracking_events')->select('visitor_id')
                ->where('event', 'pageview')->groupBy('visitor_id')
                ->havingRaw('MIN(created_at) >= ?', [$from]),
            'n'
        )->count();
        $newVisitors = min($newVisitors, $visitors);
        $returning = max(0, $visitors - $newVisitors);
        $returningRate = $visitors > 0 ? (int) round($returning / $visitors * 100) : 0;

        // Blended interest score (0-100): scroll depth + engaged (non-bounce) + loyalty.
        $score = (int) round(min(100, ($scrollRate * 0.4) + ((100 - $bounceRate) * 0.4) + (min(100, $returningRate) * 0.2)));
        if ($score >= 66) {
            $verdict = 'High interest';
        } elseif ($score >= 40) {
            $verdict = 'Moderate interest';
        } else {
            $verdict = 'Low interest';
        }

        return [
            'bounce_rate'    => $bounceRate,
            'scroll_rate'    => $scrollRate,
            'returning'      => $returning,
            'returning_rate' => $returningRate,
            'new_visitors'   => $newVisitors,
            'score'          => $score,
            'verdict'        => $verdict,
        ];
    }

    /* ===================== User-Flow report (unchanged) ===================== */

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
