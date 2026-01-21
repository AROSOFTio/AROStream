<?php

namespace App\Services\Provisioning;

use App\Models\Node;
use App\Models\Station;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NodeAgentClient
{
    public function createStation(Node $node, Station $station, array $payload): array
    {
        $body = [
            'station_key' => $station->station_key,
            'slug' => $station->slug,
            'icecast' => $payload,
        ];

        $response = Http::withHeaders([
                'X-Signature' => $this->signature($node, $body),
            ])
            ->timeout(config('streaming.node_agent.timeout_total_seconds'))
            ->asJson()
            ->post(rtrim($node->base_url, '/') . '/api/v1/stations', $body);

        if ($response->failed()) {
            Log::error('Node agent createStation failed', [
                'node' => $node->id,
                'station' => $station->id,
                'body' => $response->json(),
            ]);
            $response->throw();
        }

        return $response->json();
    }

    public function deleteStation(Node $node, Station $station): void
    {
        Http::withHeaders([
                'X-Signature' => $this->signature($node, ['station_key' => $station->station_key]),
            ])
            ->timeout(config('streaming.node_agent.timeout_total_seconds'))
            ->delete(rtrim($node->base_url, '/') . '/api/v1/stations/' . $station->station_key);
    }

    protected function signature(Node $node, array $payload): string
    {
        $json = json_encode($payload);
        return hash_hmac('sha256', $json, $node->shared_secret);
    }
}
