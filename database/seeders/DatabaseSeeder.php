<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
            AdminUserSeeder::class,
            ExampleNodeSeeder::class,
            TenantSeeder::class,
            StationSeeder::class,
            StreamerSeeder::class,
            StreamSessionSeeder::class,
            TenantSettingsSeeder::class,
        ]);
    }
}
