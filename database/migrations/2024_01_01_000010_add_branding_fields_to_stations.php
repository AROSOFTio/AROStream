<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->string('frequency')->nullable()->after('name');
            $table->string('branding_primary_color')->nullable()->after('frequency');
            $table->string('branding_secondary_color')->nullable()->after('branding_primary_color');
            $table->string('branding_logo_url')->nullable()->after('branding_secondary_color');
            $table->string('branding_slogan')->nullable()->after('branding_logo_url');
        });
    }

    public function down(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->dropColumn([
                'frequency',
                'branding_primary_color',
                'branding_secondary_color',
                'branding_logo_url',
                'branding_slogan',
            ]);
        });
    }
};
