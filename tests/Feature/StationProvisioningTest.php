<?php

namespace Tests\Feature;

use App\Jobs\ProvisionStationJob;
use App\Models\Node;
use App\Models\Station;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use App\Services\Provisioning\NodeAgentClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Mockery;
use Tests\TestCase;

class StationProvisioningTest extends TestCase
{
    use RefreshDatabase;

    public function test_provision_job_marks_station_active(): void
    {
        $tenant = Tenant::create(['name' => 'T1']);
        $node = Node::create(['name' => 'Node', 'base_url' => 'http://localhost', 'shared_secret' => 'secret']);
        $station = Station::create([
            'tenant_id' => $tenant->id,
            'node_id' => $node->id,
            'name' => 'Station 1',
            'slug' => 'station-1',
            'station_key' => 'key-1',
            'plan' => 'basic',
            'status' => 'provisioning',
            'source_password' => Crypt::encryptString('src-pass'),
            'admin_password' => Crypt::encryptString('adm-pass'),
        ]);

        Subscription::create([
            'station_id' => $station->id,
            'plan' => 'basic',
            'starts_at' => now(),
            'renews_at' => now()->addYear(),
            'status' => 'active',
        ]);

        $mock = Mockery::mock(NodeAgentClient::class);
        $mock->shouldReceive('createStation')->andReturn([
            'container_id' => 'container-123',
            'status_url' => 'http://status',
            'public_stream_base' => 'http://public',
            'internal_port' => 18001,
        ]);
        $this->app->instance(NodeAgentClient::class, $mock);

        (new ProvisionStationJob($station->id))->handle(
            app()->make(\App\Services\Provisioning\StationProvisioner::class),
            app()->make(\App\Services\Billing\PlanEnforcer::class)
        );

        $station->refresh();

        $this->assertEquals('active', $station->status);
        $this->assertEquals('container-123', $station->container_id);
        $this->assertEquals(18001, $station->internal_port);
    }
}
