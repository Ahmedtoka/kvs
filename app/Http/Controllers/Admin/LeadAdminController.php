<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LeadAdminController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Lead::query()->with(['assignedAgent', 'activities.user'])->latest();

        if ($user->role === 'sales_agent') {
            $query->where('assigned_to', $user->id);
        }

        if ($request->filled('status') && array_key_exists($request->status, Lead::STATUSES)) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type') && array_key_exists($request->type, Lead::TYPES)) {
            $query->where('type', $request->type);
        }
        if ($request->filled('agent') && $user->role !== 'sales_agent') {
            $query->where('assigned_to', $request->agent === 'unassigned' ? null : (int) $request->agent);
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

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $leads  = $query->paginate(20)->withQueryString();
        $agents = User::whereIn('role', ['sales_agent', 'super_admin'])->where('is_active', true)->orderBy('name')->get();

        return view('admin.leads.index', compact('leads', 'agents'));
    }

    public function update(Request $request, Lead $lead)
    {
        $user = $request->user();
        if ($user->role === 'sales_agent' && (int) $lead->assigned_to !== (int) $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'status'      => ['nullable', 'in:' . implode(',', array_keys(Lead::STATUSES))],
            'notes'       => ['nullable', 'string', 'max:5000'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'feedback'    => ['nullable', 'string', 'max:2000'],
            'follow_up_at' => ['nullable', 'date'],
            'tour_at'      => ['nullable', 'date'],
        ]);

        if (! empty($data['status']) && $data['status'] !== $lead->status) {
            LeadActivity::create(['lead_id' => $lead->id, 'user_id' => $user->id, 'type' => 'status',
                'body' => 'Status changed to ' . (Lead::STATUSES[$data['status']] ?? $data['status'])]);
            $lead->status = $data['status'];
        }

        if ($user->role !== 'sales_agent' && $request->has('assigned_to')) {
            $newAgent = $data['assigned_to'] ?: null;
            if ((int) $newAgent !== (int) $lead->assigned_to) {
                $name = $newAgent ? optional(User::find($newAgent))->name : 'Unassigned';
                LeadActivity::create(['lead_id' => $lead->id, 'user_id' => $user->id, 'type' => 'assign', 'body' => 'Assigned to ' . $name]);
                $lead->assigned_to = $newAgent;
            }
        }

        if ($request->has('notes')) {
            $lead->notes = $data['notes'] ?? null;
        }

        // Schedule next call-back
        if ($request->has('follow_up_at')) {
            $new = ! empty($data['follow_up_at']) ? Carbon::parse($data['follow_up_at']) : null;
            if (optional($new)->format('Y-m-d H:i') !== optional($lead->follow_up_at)->format('Y-m-d H:i')) {
                $lead->follow_up_at = $new;
                LeadActivity::create(['lead_id' => $lead->id, 'user_id' => $user->id, 'type' => 'schedule',
                    'body' => $new ? 'Follow-up call scheduled for ' . $new->format('D, d M Y \a\t H:i') : 'Follow-up cleared']);
            }
        }

        // Confirm tour appointment (date + time)
        if ($request->has('tour_at')) {
            $new = ! empty($data['tour_at']) ? Carbon::parse($data['tour_at']) : null;
            if (optional($new)->format('Y-m-d H:i') !== optional($lead->tour_at)->format('Y-m-d H:i')) {
                $lead->tour_at = $new;
                LeadActivity::create(['lead_id' => $lead->id, 'user_id' => $user->id, 'type' => 'tour',
                    'body' => $new ? 'Tour appointment set for ' . $new->format('D, d M Y \a\t H:i') : 'Tour appointment cleared']);
            }
        }

        $lead->save();

        if (! empty($data['feedback'])) {
            LeadActivity::create(['lead_id' => $lead->id, 'user_id' => $user->id, 'type' => 'note', 'body' => $data['feedback']]);
        }

        return back()->with('success', "Lead #{$lead->id} updated.");
    }

    /** "My Schedule" — this agent's due call-backs and tour appointments. */
    public function agenda(Request $request)
    {
        $user = $request->user();
        $open = ['new', 'contacted', 'tour_booked', 'toured', 'applied'];

        $base = fn () => Lead::query()->with(['assignedAgent', 'activities'])->whereIn('status', $open)
            ->when($user->role === 'sales_agent', fn ($q) => $q->where('assigned_to', $user->id))
            ->when($user->role !== 'sales_agent' && $request->filled('agent'),
                fn ($q) => $q->where('assigned_to', $request->agent === 'unassigned' ? null : (int) $request->agent));

        $calls = $base()->whereNotNull('follow_up_at')->orderBy('follow_up_at')->get();
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        $overdue    = $calls->filter(fn ($l) => $l->follow_up_at->lt($todayStart))->values();
        $todayCalls = $calls->filter(fn ($l) => $l->follow_up_at->between($todayStart, $todayEnd))->values();
        $upcoming   = $calls->filter(fn ($l) => $l->follow_up_at->gt($todayEnd))->values();

        $tours = $base()->whereNotNull('tour_at')->where('tour_at', '>=', $todayStart)
            ->orderBy('tour_at')->get();

        $agents = User::whereIn('role', ['sales_agent', 'super_admin'])->where('is_active', true)->orderBy('name')->get();

        return view('admin.leads.agenda', compact('overdue', 'todayCalls', 'upcoming', 'tours', 'agents'));
    }

    public function destroy(Request $request, Lead $lead)
    {
        if ($request->user()->role === 'sales_agent') {
            abort(403);
        }
        $lead->delete();

        return back()->with('success', 'Lead deleted.');
    }

    public function export(Request $request)
    {
        $user = $request->user();
        $filename = 'kvs-leads-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($user) {
            $out = fopen('php://output', 'w');
            fputs($out, "\xEF\xBB\xBF");
            fputcsv($out, ['ID', 'Date', 'Type', 'Parent', 'Student', 'Phone', 'Email', 'Age', 'Stage', 'Year Group', 'Preferred Date', 'Status', 'Assigned To', 'Source', 'Message', 'Notes']);
            Lead::with('assignedAgent')->when($user->role === 'sales_agent', fn ($q) => $q->where('assigned_to', $user->id))
                ->latest()->chunk(200, function ($leads) use ($out) {
                    foreach ($leads as $l) {
                        fputcsv($out, [
                            $l->id, $l->created_at->format('Y-m-d H:i'),
                            Lead::TYPES[$l->type] ?? $l->type,
                            $l->parent_name, $l->student_name, $l->phone, $l->email,
                            $l->child_age, $l->stage, $l->year_group,
                            optional($l->preferred_date)->format('Y-m-d'),
                            Lead::STATUSES[$l->status] ?? $l->status,
                            optional($l->assignedAgent)->name,
                            $l->source, $l->message, $l->notes,
                        ]);
                    }
                });
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
