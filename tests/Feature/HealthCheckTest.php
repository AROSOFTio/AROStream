<?php

namespace Tests\Feature;

use App\Jobs\CheckStationHealthJob;
use App\Models\Node;
use App\Models\Station;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Services\Streaming\IcecastStatusClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_check_stores_snapshot(): void
    {
        $tenant = Tenant::create(['name' => 'Tenant']);
        $node = Node::create(['name' => 'Node', 'base_url' => 'http://localhost', 'shared_secret' => 'secret']);
        $station = Station::create([
            'tenant_id' => $tenant->id,
            'node_id' => $node->id,
            'name' => 'Station',
            'slug' => 'station',
            'station_key' => 'key',
            'plan' => 'basic',
            'status' => 'active',
            'status_url' => 'http://status',
            'source_password' => Crypt::encryptString('src'),
            'admin_password' => Crypt::encryptString('adm'),
        ]);

        Subscription::create([
            'station_id' => $station->id,
            'plan' => 'basic',
            'starts_at' => now(),
            'renews_at' => now()->addYear(),
            'status' => 'active',
        ]);

        $mock = Mockery::mock(IcecastStatusClient::class);
        $mock->shouldReceive('fetch')->andReturn([
            'online' => true,
            'listeners' => 42,
            'mount' => '/live',
            'raw' => ['ok' => true],
        ]);
        $this->app->instance(IcecastStatusClient::class, $mock);

        (new CheckStationHealthJob($station->id))->handle(
            app()->make(IcecastStatusClient::class),
            app()->make(\App\Services\Billing\PlanEnforcer::class)
        );

        $this->assertDatabaseHas('station_health_snapshots', [
            'station_id' => $station->id,
            'listeners' => 42,
        ]);

        $this->assertTrue(Cache::has('station_status_' . $station->id));
    }
}
