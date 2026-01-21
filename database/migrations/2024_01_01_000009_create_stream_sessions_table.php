<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stream_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained()->cascadeOnDelete();
            $table->foreignId('streamer_id')->nullable()->constrained('streamers')->nullOnDelete();
            $table->string('status')->default('live');
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->unsignedInteger('listeners_current')->default(0);
            $table->unsignedInteger('listeners_peak')->default(0);
            $table->unsignedInteger('listeners_avg')->default(0);
            $table->unsignedInteger('bitrate_kbps')->default(128);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stream_sessions');
    }
};
