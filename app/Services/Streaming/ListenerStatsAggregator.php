<?php

namespace App\Services\Streaming;

use App\Models\StationHealthSnapshot;

class ListenerStatsAggregator
{
    public function totalForSnapshot(?StationHealthSnapshot $snapshot): int
    {
        return $snapshot?->listeners ?? 0;
    }
}
