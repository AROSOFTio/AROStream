<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Services\Billing\PlanEnforcer;
use App\Services\Streaming\ListenerStatsAggregator;
use Illuminate\Support\Facades\Cache;

class StationStatusController extends Controller
{
    public function __invoke(Station $station, PlanEnforcer $enforcer, ListenerStatsAggregator $aggregator)
    {
        $cached = Cache::get('station_status_' . $station->id);

        $latest = $station->healthSnapshots()->latest('checked_at')->first();

        $overLimit = $enforcer->isOverListenerLimit($station, $latest?->listeners);
        $shouldSuspend = $enforcer->shouldSuspend($station);

        return response()->json([
            'station_id' => $station->id,
            'status' => $station->status,
            'online' => $cached['online'] ?? $latest?->online ?? false,
            'listeners' => $cached['listeners'] ?? $aggregator->totalForSnapshot($latest),
            'checked_at' => $cached['checked_at'] ?? optional($latest?->checked_at)->toIso8601String(),
            'over_listener_limit' => $overLimit,
            'should_suspend' => $shouldSuspend,
            'plan' => $station->plan,
        ]);
    }
}
