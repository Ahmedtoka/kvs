<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Surface the manually-configured Meta Pixel ID inside the Settings page.
 *
 * The pixel already fires (via a code fallback), but the Settings field read
 * empty because the DB value was never populated. This writes the real ID so
 * admins can see and manage it from Settings — only if it is still blank, so a
 * value the admin already typed is never overwritten.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Make sure the row exists.
        DB::table('settings')->updateOrInsert(
            ['key' => 'meta_pixel_id'],
            ['group' => 'integrations', 'type' => 'text', 'updated_at' => now(), 'created_at' => now()]
        );

        // Populate the known pixel ID only when the field is still empty.
        DB::table('settings')
            ->where('key', 'meta_pixel_id')
            ->where(function ($q) {
                $q->whereNull('value')->orWhere('value', '');
            })
            ->update(['value' => '1363243909311016', 'updated_at' => now()]);
    }

    public function down(): void
    {
        // Non-destructive: leave the admin-visible value in place.
    }
};
