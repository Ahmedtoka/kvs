<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_events', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_id', 36)->index();     // anonymous cookie UUID (1 year)
            $table->string('session_id', 64)->nullable();
            $table->string('event', 40)->index();          // pageview, cta_click, form_view, ...
            $table->string('page', 191);                   // path, e.g. /academics/primary
            $table->string('label', 191)->nullable();      // e.g. which CTA / which link
            $table->string('referrer', 191)->nullable();
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->string('device', 10)->nullable();      // mobile | desktop
            $table->timestamp('created_at')->useCurrent()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_events');
    }
};
