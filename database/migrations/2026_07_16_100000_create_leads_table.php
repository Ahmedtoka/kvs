<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name', 120);
            $table->string('phone', 20);
            $table->unsignedTinyInteger('child_age');
            $table->string('stage', 30)->nullable();
            $table->string('status', 20)->default('new'); // new | contacted | toured | enrolled | closed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
