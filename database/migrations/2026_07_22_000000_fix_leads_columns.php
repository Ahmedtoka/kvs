<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'type'))           { $table->string('type', 20)->default('callback')->after('id'); }
            if (!Schema::hasColumn('leads', 'student_name'))   { $table->string('student_name')->nullable()->after('parent_name'); }
            if (!Schema::hasColumn('leads', 'email'))          { $table->string('email')->nullable()->after('phone'); }
            if (!Schema::hasColumn('leads', 'year_group'))     { $table->string('year_group', 20)->nullable()->after('stage'); }
            if (!Schema::hasColumn('leads', 'preferred_date')) { $table->date('preferred_date')->nullable()->after('year_group'); }
            if (!Schema::hasColumn('leads', 'message'))        { $table->text('message')->nullable()->after('preferred_date'); }
            if (!Schema::hasColumn('leads', 'source'))         { $table->string('source')->nullable()->after('status'); }
            if (!Schema::hasColumn('leads', 'notes'))          { $table->text('notes')->nullable()->after('source'); }
        });

        // Older table made child_age a required tiny-integer; the tour form doesn't send it.
        if (Schema::hasColumn('leads', 'child_age')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->string('child_age', 10)->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // no-op: additive repair migration
    }
};
