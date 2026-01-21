<?php

namespace App\Jobs;

use App\Models\Station;
use App\Services\Billing\PlanEnforcer;
use App\Services\Provisioning\StationProvisioner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProvisionStationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $stationId)
    {
    }

    public function handle(StationProvisioner $provisioner, PlanEnforcer $enforcer): void
    {
        $station = Station::with(['node', 'subscription'])->find($this->stationId);

        if (!$station) {
            return;
        }

        try {
            $provisioner->provision($station);
            $enforcer->enforce($station);
        } catch (Throwable $e) {
            Log::error('Provision station failed', [
                'station' => $station->id,
                'error' => $e->getMessage(),
            ]);

            $station->update(['status' => Station::STATUS_ERRORED]);
        }
    }
}
