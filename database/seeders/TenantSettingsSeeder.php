<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\TenantSetting;
use Illuminate\Database\Seeder;

class TenantSettingsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Tenant::all() as $tenant) {
            TenantSetting::firstOrCreate(
                ['tenant_id' => $tenant->id],
                [
                    'station_name_default' => $tenant->name . ' FM',
                    'frequency_default' => '99.9',
                    'primary_color' => '#ff6b35',
                    'secondary_color' => '#0b0f1a',
                    'logo_url' => null,
                    'slogan' => 'Streaming that never sleeps.',
                ]
            );
        }
    }
}
