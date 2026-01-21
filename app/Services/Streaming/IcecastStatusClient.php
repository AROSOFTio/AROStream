<?php

namespace App\Services\Streaming;

use App\Models\Station;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class IcecastStatusClient
{
    public function fetch(Station $station): array
    {
        $url = $station->status_url ?: rtrim($station->node?->base_url ?? '', '/') .
            config('streaming.icecast_status_path_default') .
            '?station_key=' . $station->station_key;

        if (!$url) {
            throw new RuntimeException('Status URL missing for station ' . $station->id);
        }

        $response = Http::timeout(config('streaming.node_agent.timeout_total_seconds'))
            ->get($url);

        if ($response->failed()) {
            Log::warning('Icecast status fetch failed', [
                'station' => $station->id,
                'url' => $url,
                'body' => $response->json(),
            ]);
            $response->throw();
        }

        $payload = $response->json();
        $icestats = $payload['icestats'] ?? [];
        $source = $icestats['source'] ?? [];

        if (isset($source['listeners'])) {
            $sources = [$source];
        } elseif (is_array($source)) {
            $sources = $source;
        } else {
            $sources = [];
        }

        $first = $sources[0] ?? [];
        $listeners = $first['listeners'] ?? 0;
        $mount = $first['listenurl'] ?? null;
        $online = isset($first['server_name']) || isset($first['listenurl']);

        return [
            'online' => (bool) $online,
            'listeners' => (int) $listeners,
            'mount' => $mount,
            'raw' => $payload,
        ];
    }
}
