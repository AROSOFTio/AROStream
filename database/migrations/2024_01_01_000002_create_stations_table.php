<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->foreignId('node_id')->constrained();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('station_key')->unique();
            $table->enum('status', ['provisioning', 'active', 'suspended', 'errored'])->default('provisioning');
            $table->enum('plan', ['basic', 'standard', 'pro']);
            $table->text('source_password');
            $table->text('admin_password');
            $table->string('mount_low')->default('/live-low');
            $table->string('mount_normal')->default('/live');
            $table->integer('bitrate_low')->default(48);
            $table->integer('bitrate_normal')->default(64);
            $table->string('container_id')->nullable();
            $table->integer('internal_port')->nullable();
            $table->string('status_url')->nullable();
            $table->string('public_stream_base')->nullable();
            $table->timestamp('last_provisioned_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stations');
    }
};
