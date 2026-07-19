<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadAdminController extends Controller
{
    /**
     * The lead pipeline statuses.
     *
     * @var list<string>
     */
    public const STATUSES = ['new', 'contacted', 'toured', 'enrolled', 'closed'];

    /**
     * List leads with stats and an optional status filter.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');

        if (! in_array($status, self::STATUSES, true)) {
            $status = null;
        }

        $leads = Lead::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $counts = ['total' => Lead::count()];
        foreach (self::STATUSES as $s) {
            $counts[$s] = Lead::where('status', $s)->count();
        }

        return view('admin.leads', [
            'leads'    => $leads,
            'counts'   => $counts,
            'active'   => $status,
            'statuses' => self::STATUSES,
        ]);
    }

    /**
     * Update a lead's pipeline status.
     */
    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', self::STATUSES)],
        ]);

        $lead->update($validated);

        return back()->with('success', "Lead \"{$lead->parent_name}\" updated to \"{$validated['status']}\".");
    }

    /**
     * Delete a lead.
     */
    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return back()->with('success', "Lead \"{$lead->parent_name}\" deleted.");
    }
}
