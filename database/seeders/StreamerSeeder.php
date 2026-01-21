<?php

namespace Database\Seeders;

use App\Models\Station;
use App\Models\Streamer;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StreamerSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            ['name' => 'DJ Nova', 'handle' => 'dj-nova', 'status' => 'live'],
            ['name' => 'Luna Beats', 'handle' => 'luna-beats', 'status' => 'live'],
            ['name' => 'Atlas FM', 'handle' => 'atlas-fm', 'status' => 'offline'],
            ['name' => 'Echo Host', 'handle' => 'echo-host', 'status' => 'offline'],
        ];

        $stations = Station::with('tenant')->get();

        foreach ($profiles as $index => $profile) {
            $station = $stations[$index % max(1, $stations->count())] ?? null;
            $tenant = $station?->tenant ?? Tenant::first();

            Streamer::firstOrCreate(
                ['handle' => $profile['handle']],
                [
                    'tenant_id' => $tenant?->id,
                    'station_id' => $station?->id,
                    'name' => $profile['name'],
                    'status' => $profile['status'],
                    'bio' => Str::ucfirst($profile['name']) . ' hosts daily mixes and curated sets.',
                    'last_seen_at' => now()->subMinutes(rand(3, 90)),
                ]
            );
        }
    }
}
