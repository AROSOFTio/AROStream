<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\Node;
use App\Models\Station;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        $node = Node::first();
        if (!$node) {
            return;
        }

        $plans = array_keys(config('streaming.plans'));
        $suffix = config('streaming.station_default_domain_suffix', 'stream.arostream.io');

        foreach (Tenant::all() as $tenant) {
            $stations = [
                "{$tenant->name} Live",
                "{$tenant->name} Chill",
            ];

            foreach ($stations as $index => $name) {
                $slug = Str::slug($name);
                $station = Station::firstOrCreate(
                    ['slug' => $slug],
                    [
                        'tenant_id' => $tenant->id,
                        'node_id' => $node->id,
                        'name' => $name,
                        'station_key' => Str::random(24),
                        'plan' => $plans[$index % count($plans)],
                        'status' => Station::STATUS_ACTIVE,
                        'source_password' => Crypt::encryptString(Str::random(12)),
                        'admin_password' => Crypt::encryptString(Str::random(12)),
                        'public_stream_base' => "https://{$slug}.{$suffix}/stream",
                        'status_url' => "https://{$slug}.{$suffix}/status-json.xsl",
                        'mount_normal' => '/live',
                        'mount_low' => '/live-low',
                        'bitrate_normal' => 128,
                        'bitrate_low' => 64,
                        'last_provisioned_at' => now()->subDays(3),
                    ]
                );

                Domain::firstOrCreate(
                    ['station_id' => $station->id, 'hostname' => "{$slug}.{$suffix}"],
                    [
                        'type' => 'default',
                        'verification_token' => Str::random(32),
                        'verified_at' => now()->subDays(2),
                        'ssl_status' => 'active',
                    ]
                );

                Subscription::firstOrCreate(
                    ['station_id' => $station->id],
                    [
                        'plan' => $station->plan,
                        'starts_at' => now()->subMonths(2),
                        'renews_at' => now()->addMonths(10),
                        'status' => 'active',
                    ]
                );
            }
        }
    }
}
