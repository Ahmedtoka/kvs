<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $keys = [
            ['key' => 'meta_pixel_id',    'value' => '', 'group' => 'integrations', 'type' => 'text'],
            ['key' => 'tiktok_pixel_id',  'value' => '', 'group' => 'integrations', 'type' => 'text'],
            ['key' => 'google_ads_id',    'value' => '', 'group' => 'integrations', 'type' => 'text'],
            ['key' => 'google_ads_label', 'value' => '', 'group' => 'integrations', 'type' => 'text'],
        ];

        foreach ($keys as $d) {
            DB::table('settings')->updateOrInsert(
                ['key' => $d['key']],
                ['value' => $d['value'], 'group' => $d['group'], 'type' => $d['type'], 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['meta_pixel_id', 'tiktok_pixel_id', 'google_ads_id', 'google_ads_label'])->delete();
    }
};
