<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key', 100)->unique();
                $table->text('value')->nullable();
                $table->string('group', 40)->default('general');
                $table->string('type', 20)->default('text'); // text|textarea|tel|email|url
                $table->timestamps();
            });
        }

        $defaults = [
            ['key' => 'phone_admissions', 'value' => '0127 777 1119', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'phone_school',     'value' => '02 3722 1413 · 02 3722 1206', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'whatsapp_number',  'value' => '201277771119', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'email_info',       'value' => 'info@kvs.edu.eg', 'group' => 'contact', 'type' => 'email'],
            ['key' => 'email_admission',  'value' => 'admission@kvs.edu.eg', 'group' => 'contact', 'type' => 'email'],
            ['key' => 'address',          'value' => 'Sherif Ismail Axis, Ring Road, Saft Al Laban, Kerdasa — Giza, Egypt', 'group' => 'contact', 'type' => 'textarea'],
            ['key' => 'working_hours',    'value' => 'Sunday – Thursday · 7:30 AM – 2:45 PM', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'social_facebook',  'value' => 'https://www.facebook.com/kvschools', 'group' => 'social', 'type' => 'url'],
            ['key' => 'social_instagram', 'value' => 'https://www.instagram.com/k.v.schools', 'group' => 'social', 'type' => 'url'],
            ['key' => 'social_linkedin',  'value' => 'https://www.linkedin.com/company/knowledge-valley-schools/', 'group' => 'social', 'type' => 'url'],
            ['key' => 'ga4_id',           'value' => '', 'group' => 'integrations', 'type' => 'text'],
        ];

        foreach ($defaults as $d) {
            DB::table('settings')->updateOrInsert(
                ['key' => $d['key']],
                ['value' => $d['value'], 'group' => $d['group'], 'type' => $d['type'], 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
