<?php

namespace App\Jobs;

use App\Models\Station;
use App\Services\Billing\PlanEnforcer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SuspendExpiredStationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(PlanEnforcer $enforcer): void
    {
        Station::with('subscription')->chunk(100, function ($stations) use ($enforcer) {
            foreach ($stations as $station) {
                $enforcer->enforce($station);
            }
        });
    }
}
