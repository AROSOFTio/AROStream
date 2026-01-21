<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = [
            [
                'name' => 'Aurora Media',
                'contact_name' => 'Rina Patel',
                'contact_email' => 'rina@auroramedia.test',
                'status' => 'active',
            ],
            [
                'name' => 'BlueWave Radio',
                'contact_name' => 'Marcus Hill',
                'contact_email' => 'marcus@bluewave.test',
                'status' => 'active',
            ],
            [
                'name' => 'Echo Peaks',
                'contact_name' => 'Amara Cole',
                'contact_email' => 'amara@echopeaks.test',
                'status' => 'trial',
            ],
        ];

        foreach ($tenants as $tenant) {
            Tenant::firstOrCreate(['name' => $tenant['name']], $tenant);
        }
    }
}
