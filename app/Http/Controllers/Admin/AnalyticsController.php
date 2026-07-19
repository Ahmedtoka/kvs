<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\TrackingEvent;
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

        return view('admin.analytics', compact('cards', 'funnel', 'funnelMax', 'topPages', 'interactions', 'days', 'dailyMax', 'sources'));
    }
}
