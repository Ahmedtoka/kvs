<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Point the site at the current Meta Pixel / dataset: 1886023012802497.
 *
 * Deliberately overwrites whatever was stored before (1363243909311016 and
 * 869891722809793 are both retired) so the Settings page, the rendered Pixel
 * and the Conversions API all speak to exactly one dataset.
 */
return new class extends Migration
{
    private const PIXEL_ID = '1886023012802497';

    public function up(): void
    {
        DB::table('settings')->updateOrInsert(
            ['key' => 'meta_pixel_id'],
            ['group' => 'integrations', 'type' => 'text', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('settings')
            ->where('key', 'meta_pixel_id')
            ->update(['value' => self::PIXEL_ID, 'updated_at' => now()]);
    }

    public function down(): void
    {
        // Non-destructive: keep the pixel ID in place on rollback.
    }
};
