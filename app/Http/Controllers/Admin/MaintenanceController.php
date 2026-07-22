<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MaintenanceController extends Controller
{
    /** Operational / test data cleared on reset. */
    private const WIPE = ['lead_activities', 'leads', 'tracking_events', 'career_applications'];

    /** Core data always kept. */
    private const KEEP = ['users', 'settings', 'content_items', 'events'];

    public function index()
    {
        $counts     = $this->countRows(self::WIPE);
        $keepCounts = $this->countRows(self::KEEP);

        return view('admin.reset', compact('counts', 'keepCounts'));
    }

    public function reset(Request $request)
    {
        $request->validate(
            ['confirmation' => ['required', 'string', 'in:RESET']],
            ['confirmation.in' => 'Please type RESET exactly to confirm.']
        );

        Schema::disableForeignKeyConstraints();
        foreach (self::WIPE as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }
        Schema::enableForeignKeyConstraints();

        return back()->with('success', 'Done — all leads, submissions and analytics were cleared. Your users, settings and content are untouched. The site is ready to record real data.');
    }

    private function countRows(array $tables): array
    {
        $out = [];
        foreach ($tables as $t) {
            $out[$t] = Schema::hasTable($t) ? DB::table($t)->count() : 0;
        }

        return $out;
    }
}
