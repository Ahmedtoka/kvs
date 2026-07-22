<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (! Schema::hasColumn('leads', 'follow_up_at')) {
                $table->dateTime('follow_up_at')->nullable()->after('preferred_date');
            }
            if (! Schema::hasColumn('leads', 'tour_at')) {
                $table->dateTime('tour_at')->nullable()->after('follow_up_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            foreach (['follow_up_at', 'tour_at'] as $col) {
                if (Schema::hasColumn('leads', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
