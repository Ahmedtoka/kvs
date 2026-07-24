<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MaintenanceController extends Controller
{
    /**
     * Selectable groups of operational / test data.
     * Tables are truncated in the order listed (children before parents).
     */
    private const GROUPS = [
        'analytics' => [
            'label'  => 'Visitors, User Flow & all Analytics',
            'note'   => 'Every tracked page view, session and behaviour event.',
            'tables' => ['tracking_events'],
        ],
        'leads' => [
            'label'  => 'Leads + their history',
            'note'   => 'All Book-a-Tour / Call-back / Fees requests, plus feedback, schedules & tours.',
            'tables' => ['lead_activities', 'leads'],
        ],
        'careers' => [
            'label'  => 'Career applications',
            'note'   => 'Submitted CVs and applicant details.',
            'tables' => ['career_applications'],
        ],
    ];

    /** Core data always kept, whatever is selected. */
    private const KEEP = [
        'users'         => 'Admin accounts & roles',
        'settings'      => 'Site settings (contact, social, tracking IDs)',
        'content_items' => 'FAQs & Parent Services',
        'events'        => 'Events & gallery',
    ];

    public function index()
    {
        $groups = [];
        foreach (self::GROUPS as $key => $meta) {
            $groups[$key] = [
                'label' => $meta['label'],
                'note'  => $meta['note'],
                'rows'  => $this->rowsIn($meta['tables']),
            ];
        }

        $keep = [];
        foreach (self::KEEP as $table => $label) {
            $keep[$table] = ['label' => $label, 'rows' => $this->rowsIn([$table])];
        }

        return view('admin.reset', compact('groups', 'keep'));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'confirmation' => ['required', 'string', 'in:RESET'],
            'targets'      => ['required', 'array', 'min:1'],
            'targets.*'    => ['string', 'in:' . implode(',', array_keys(self::GROUPS))],
        ], [
            'confirmation.in' => 'Please type RESET exactly to confirm.',
            'targets.required' => 'Choose at least one type of data to clear.',
            'targets.min'      => 'Choose at least one type of data to clear.',
        ]);

        $targets = (array) $request->input('targets', []);
        $tables = [];
        $labels = [];
        foreach ($targets as $key) {
            if (isset(self::GROUPS[$key])) {
                $tables = array_merge($tables, self::GROUPS[$key]['tables']);
                $labels[] = self::GROUPS[$key]['label'];
            }
        }

        Schema::disableForeignKeyConstraints();
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }
        Schema::enableForeignKeyConstraints();

        $what = count($labels) === count(self::GROUPS) ? 'all selected data' : implode(' + ', $labels);

        return back()->with('success', 'Done — cleared: ' . $what . '. Your users, settings and content are untouched.');
    }

    private function rowsIn(array $tables): int
    {
        $total = 0;
        foreach ($tables as $t) {
            $total += Schema::hasTable($t) ? DB::table($t)->count() : 0;
        }

        return $total;
    }
}
