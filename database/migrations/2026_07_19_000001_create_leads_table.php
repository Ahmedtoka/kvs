<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->default('callback');   // callback | tour | fees
            $table->string('parent_name');
            $table->string('student_name')->nullable();
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->string('child_age', 10)->nullable();
            $table->string('stage', 30)->nullable();
            $table->string('year_group', 20)->nullable();
            $table->date('preferred_date')->nullable();
            $table->text('message')->nullable();
            $table->string('status', 20)->default('new');      // new | contacted | tour_booked | toured | applied | enrolled | lost
            $table->string('source')->nullable();              // page the lead came from
            $table->text('notes')->nullable();                 // internal admissions notes
            $table->timestamps();

            $table->index(['status', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
