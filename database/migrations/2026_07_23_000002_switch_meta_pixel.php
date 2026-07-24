<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Switch the active Meta Pixel to the verified dataset (869891722809793).
 * Deliberately overwrites any previous value so the Settings page and the
 * live pixel both use the new, verified pixel.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')->updateOrInsert(
            ['key' => 'meta_pixel_id'],
            ['group' => 'integrations', 'type' => 'text', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('settings')
            ->where('key', 'meta_pixel_id')
            ->update(['value' => '869891722809793', 'updated_at' => now()]);
    }

    public function down(): void
    {
        // Non-destructive.
    }
};
