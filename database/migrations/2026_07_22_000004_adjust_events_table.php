<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('excerpt', 300)->nullable()->change();
            $table->text('body')->nullable()->change();
            $table->dateTime('starts_at')->nullable()->change();
            if (! Schema::hasColumn('events', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('is_featured');
            }
            if (! Schema::hasColumn('events', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('sort_order');
            }
        });

        $events = [
            ['science-fair', 'KVS Science Fair', 'Student-led experiments and projects presented to parents and judges.', '/img/event-science-fair.jpg', 1, 1],
            ['graduation-2026', 'Graduation 2026', 'Celebrating our graduates and the journey that brought them here.', '/img/event-graduation-2026.jpg', 2, 1],
            ['art-exhibition-2026', 'Art Exhibition 2026', 'A gallery of student creativity — painting, sculpture and design.', '/img/event-art-exhibition-2026.jpg', 3, 1],
            ['senior-walk-2026', 'Senior Walk 2026', 'A cherished tradition as our senior students mark their final chapter.', '/img/event-senior-walk-2026.jpg', 4, 1],
            ['6th-october-celebration', '6th of October Celebration', 'Honouring a proud national day with remembrance and school spirit.', '/img/event-6th-october-celebration.jpg', 5, 1],
            ['international-peace-day', 'International Peace Day', 'A whole-school celebration of tolerance and global citizenship.', '/img/event-international-peace-day.jpg', 6, 1],
            ['end-of-year-performance-2026', 'End of Year Performance 2026', 'Music, drama and dance — the stage belongs to our students.', '/img/event-end-of-year-performance-2026.jpg', 7, 0],
            ['back-to-school-2026', 'Back to School 2026', 'Welcoming our families into a new academic year together.', '/img/event-back-to-school-2026.jpg', 8, 0],
            ['french-institute-delf', 'French Institute Delf Certificates', 'Students earn internationally recognised DELF certificates in partnership with the Institut Français.', '/img/event-french-institute-delf.jpg', 9, 0],
        ];

        foreach ($events as [$slug, $title, $desc, $image, $order, $featured]) {
            DB::table('events')->updateOrInsert(
                ['slug' => $slug],
                ['title' => $title, 'excerpt' => $desc, 'image' => $image, 'sort_order' => $order,
                 'is_featured' => $featured, 'is_active' => 1, 'updated_at' => now(),
                 'created_at' => DB::raw('COALESCE(created_at, NOW())')]
            );
        }
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
            if (Schema::hasColumn('events', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
