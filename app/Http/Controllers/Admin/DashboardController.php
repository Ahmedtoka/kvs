<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use App\Models\Lead;
use App\Models\TrackingEvent;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now        = now();
        $todayStart = $now->copy()->startOfDay();
        $weekStart  = $now->copy()->subDays(6)->startOfDay();
        $prevWeekS  = $now->copy()->subDays(13)->startOfDay();
        $prevWeekE  = $now->copy()->subDays(7)->endOfDay();

        $stats = [
            'total'     => Lead::count(),
            'new'       => Lead::where('status', 'new')->count(),
            'this_week' => Lead::where('created_at', '>=', now()->subDays(7))->count(),
            'tours'     => Lead::where('type', 'tour')->count(),
            'enrolled'  => Lead::where('status', 'enrolled')->count(),
            'careers'   => CareerApplication::where('status', 'new')->count(),
        ];

        $byStatus = Lead::selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status');
        $recent = Lead::latest()->limit(10)->get();

        // ---- Snapshot numbers (visitors already exclude bots going forward) ----
        $extra = [
            'visitors_today' => TrackingEvent::where('event', 'pageview')->where('created_at', '>=', $todayStart)->distinct('visitor_id')->count('visitor_id'),
            'visitors_7d'    => TrackingEvent::where('event', 'pageview')->where('created_at', '>=', $weekStart)->distinct('visitor_id')->count('visitor_id'),
            'leads_today'    => Lead::where('created_at', '>=', $todayStart)->count(),
            'leads_week'     => Lead::where('created_at', '>=', $weekStart)->count(),
            'leads_week_prev' => Lead::whereBetween('created_at', [$prevWeekS, $prevWeekE])->count(),
        ];

        // ---- 14-day leads trend ----
        $leadRows = Lead::selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->where('created_at', '>=', $now->copy()->subDays(13)->startOfDay())
            ->groupBy('d')->pluck('c', 'd');
        $leadTrend = collect(range(13, 0))->map(function ($i) use ($leadRows, $now) {
            $key = $now->copy()->subDays($i)->toDateString();
            return ['label' => $now->copy()->subDays($i)->format('d M'), 'count' => (int) ($leadRows[$key] ?? 0)];
        })->all();

        // Live visitors (active in the last 5 minutes)
        $liveWindow = now()->subMinutes(5);
        $live = [
            'count' => TrackingEvent::where('created_at', '>=', $liveWindow)->distinct('visitor_id')->count('visitor_id'),
            'pages' => TrackingEvent::select('page', DB::raw('COUNT(DISTINCT visitor_id) as visitors'))
                ->where('event', 'pageview')->where('created_at', '>=', $liveWindow)
                ->groupBy('page')->orderByDesc('visitors')->limit(8)->get(),
        ];

        return view('admin.dashboard', compact('stats', 'byStatus', 'recent', 'live', 'extra', 'leadTrend'));
    }
}
