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

        // Live visitors (active in the last 5 minutes)
        $liveWindow = now()->subMinutes(5);
        $live = [
            'count' => TrackingEvent::where('created_at', '>=', $liveWindow)->distinct('visitor_id')->count('visitor_id'),
            'pages' => TrackingEvent::select('page', DB::raw('COUNT(DISTINCT visitor_id) as visitors'))
                ->where('event', 'pageview')->where('created_at', '>=', $liveWindow)
                ->groupBy('page')->orderByDesc('visitors')->limit(8)->get(),
        ];

        return view('admin.dashboard', compact('stats', 'byStatus', 'recent', 'live'));
    }
}
