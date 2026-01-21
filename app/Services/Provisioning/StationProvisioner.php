<?php

namespace App\Services\Provisioning;

use App\Models\Station;
use Illuminate\Support\Facades\Log;
use Throwable;

class StationProvisioner
{
    public function __construct(
        protected NodeAgentClient $client,
        protected IcecastConfigTemplate $template,
    ) {
    }

    public function provision(Station $station): array
    {
        $payload = $this->template->build($station);

        $response = $this->client->createStation($station->node, $station, $payload);

        $station->forceFill([
            'container_id' => $response['container_id'] ?? null,
            'status_url' => $response['status_url'] ?? null,
            'public_stream_base' => $response['public_stream_base'] ?? null,
            'internal_port' => $response['internal_port'] ?? null,
            'status' => Station::STATUS_ACTIVE,
            'last_provisioned_at' => now(),
        ])->save();

        return $response;
    }

    public function deprovision(Station $station): void
    {
        try {
            $this->client->deleteStation($station->node, $station);
        } catch (Throwable $e) {
            Log::warning('Failed to deprovision station', [
                'station' => $station->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
