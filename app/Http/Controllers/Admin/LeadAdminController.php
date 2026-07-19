<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::query()->latest();

        if ($request->filled('status') && array_key_exists($request->status, Lead::STATUSES)) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type') && array_key_exists($request->type, Lead::TYPES)) {
            $query->where('type', $request->type);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('parent_name', 'like', "%{$q}%")
                  ->orWhere('student_name', 'like', "%{$q}%")
                  ->orWhere('phone', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $leads = $query->paginate(20)->withQueryString();

        return view('admin.leads.index', compact('leads'));
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'status' => ['nullable', 'in:' . implode(',', array_keys(Lead::STATUSES))],
            'notes'  => ['nullable', 'string', 'max:5000'],
        ]);

        $lead->update(array_filter([
            'status' => $data['status'] ?? null,
            'notes'  => $data['notes'] ?? null,
        ], fn ($v) => ! is_null($v)));

        return back()->with('success', "Lead #{$lead->id} updated.");
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return back()->with('success', 'Lead deleted.');
    }

    public function export()
    {
        $filename = 'kvs-leads-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputs($out, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
            fputcsv($out, ['ID', 'Date', 'Type', 'Parent', 'Student', 'Phone', 'Email', 'Age', 'Stage', 'Year Group', 'Preferred Date', 'Status', 'Source', 'Message', 'Notes']);
            \App\Models\Lead::latest()->chunk(200, function ($leads) use ($out) {
                foreach ($leads as $l) {
                    fputcsv($out, [
                        $l->id, $l->created_at->format('Y-m-d H:i'),
                        \App\Models\Lead::TYPES[$l->type] ?? $l->type,
                        $l->parent_name, $l->student_name, $l->phone, $l->email,
                        $l->child_age, $l->stage, $l->year_group,
                        optional($l->preferred_date)->format('Y-m-d'),
                        \App\Models\Lead::STATUSES[$l->status] ?? $l->status,
                        $l->source, $l->message, $l->notes,
                    ]);
                }
            });
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
