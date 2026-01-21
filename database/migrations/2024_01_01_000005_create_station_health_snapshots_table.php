<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('station_health_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained();
            $table->boolean('online');
            $table->integer('listeners')->nullable();
            $table->string('mount')->nullable();
            $table->json('raw')->nullable();
            $table->timestamp('checked_at');
            $table->timestamps();

            $table->index(['station_id', 'checked_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('station_health_snapshots');
    }
};
