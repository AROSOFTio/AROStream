<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained()->unique();
            $table->enum('plan', ['basic', 'standard', 'pro']);
            $table->timestamp('starts_at');
            $table->timestamp('renews_at');
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->string('last_payment_reference')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
