<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $totals = [
            'total'       => Lead::count(),
            'new'         => Lead::where('status', 'new')->count(),
            'working'     => Lead::whereIn('status', ['contacted', 'applied'])->count(),
            'tour_booked' => Lead::where('status', 'tour_booked')->count(),
            'toured'      => Lead::where('status', 'toured')->count(),
            'enrolled'    => Lead::where('status', 'enrolled')->count(),
            'lost'        => Lead::where('status', 'lost')->count(),
            'this_week'   => Lead::where('created_at', '>=', now()->subDays(7))->count(),
            'this_month'  => Lead::where('created_at', '>=', now()->subDays(30))->count(),
        ];
        $conv = $totals['total'] ? round($totals['enrolled'] / max(1, $totals['total']) * 100, 1) : 0;

        $byType = Lead::selectRaw('type, count(*) as c')->groupBy('type')->pluck('c', 'type');

        $bySource = Lead::selectRaw("COALESCE(NULLIF(source, ''), 'Direct') as s, count(*) as c")
            ->groupBy('s')->orderByDesc('c')->limit(10)->get();

        $agents = User::whereIn('role', ['sales_agent', 'super_admin'])
            ->withCount([
                'leads',
                'leads as new_count'      => fn ($q) => $q->where('status', 'new'),
                'leads as working_count'  => fn ($q) => $q->whereIn('status', ['contacted', 'applied']),
                'leads as booked_count'   => fn ($q) => $q->where('status', 'tour_booked'),
                'leads as toured_count'   => fn ($q) => $q->where('status', 'toured'),
                'leads as enrolled_count' => fn ($q) => $q->where('status', 'enrolled'),
            ])
            ->orderByDesc('leads_count')->get();

        return view('admin.reports.index', compact('totals', 'conv', 'byType', 'bySource', 'agents'));
    }
}
