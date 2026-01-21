<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\Node;
use App\Models\Station;
use App\Models\Tenant;
use App\Models\User;
use App\Services\Domains\DomainVerifier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Tests\TestCase;

class DomainVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_domain_verification_sets_verified_at(): void
    {
        $tenant = Tenant::create(['name' => 'Test Tenant']);
        $node = Node::create(['name' => 'Node', 'base_url' => 'http://localhost', 'shared_secret' => 'secret']);
        $station = Station::create([
            'tenant_id' => $tenant->id,
            'node_id' => $node->id,
            'name' => 'Station',
            'slug' => 'station',
            'station_key' => 'key',
            'plan' => 'basic',
            'status' => 'active',
            'source_password' => Crypt::encryptString('src'),
            'admin_password' => Crypt::encryptString('admin'),
        ]);

        $domain = Domain::create([
            'station_id' => $station->id,
            'hostname' => 'stream.example.com',
            'type' => 'custom',
            'verification_token' => 'token-123',
            'ssl_status' => 'pending',
        ]);

        $this->be(User::factory()->create(['role' => 'admin', 'tenant_id' => $tenant->id]));

        $this->app->bind(DomainVerifier::class, function () {
            return new class extends DomainVerifier {
                public function verify(Domain $domain): bool
                {
                    $domain->forceFill(['verified_at' => now(), 'ssl_status' => 'pending'])->save();
                    return true;
                }
            };
        });

        $response = $this->post(route('admin.domains.verify', $domain));
        $response->assertRedirect();

        $this->assertNotNull($domain->fresh()->verified_at);
    }
}
