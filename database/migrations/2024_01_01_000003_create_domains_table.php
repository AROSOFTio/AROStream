<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained();
            $table->string('hostname')->unique();
            $table->enum('type', ['custom', 'default']);
            $table->string('verification_token');
            $table->timestamp('verified_at')->nullable();
            $table->enum('ssl_status', ['pending', 'active', 'error'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
