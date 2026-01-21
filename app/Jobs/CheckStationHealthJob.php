<?php

namespace App\Jobs;

use App\Models\Station;
use App\Services\Billing\PlanEnforcer;
use App\Services\Streaming\IcecastStatusClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class CheckStationHealthJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $stationId)
    {
    }

    public function handle(IcecastStatusClient $client, PlanEnforcer $enforcer): void
    {
        $station = Station::with('subscription')->find($this->stationId);

        if (!$station) {
            return;
        }

        if ($enforcer->shouldSuspend($station)) {
            $station->update(['status' => Station::STATUS_SUSPENDED]);
            return;
        }

        try {
            $status = $client->fetch($station);
        } catch (Throwable $e) {
            Log::warning('Health check failed', [
                'station' => $station->id,
                'error' => $e->getMessage(),
            ]);
            return;
        }

        $snapshot = $station->healthSnapshots()->create([
            'online' => $status['online'],
            'listeners' => $status['listeners'],
            'mount' => $status['mount'],
            'raw' => $status['raw'],
            'checked_at' => now(),
        ]);

        Cache::put(
            'station_status_' . $station->id,
            [
                'online' => $snapshot->online,
                'listeners' => $snapshot->listeners,
                'checked_at' => $snapshot->checked_at,
            ],
            config('streaming.health_check_cache_seconds')
        );
    }
}
