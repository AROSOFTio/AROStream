<?php

namespace App\Services\Billing;

use App\Models\Station;
use Carbon\Carbon;

class PlanEnforcer
{
    public function shouldSuspend(Station $station): bool
    {
        $subscription = $station->subscription;

        if (!$subscription) {
            return true;
        }

        if ($subscription->status === 'cancelled') {
            return true;
        }

        if ($subscription->status === 'expired' || Carbon::parse($subscription->renews_at)->isPast()) {
            return true;
        }

        return $station->status === Station::STATUS_SUSPENDED;
    }

    public function isOverListenerLimit(Station $station, ?int $listeners): bool
    {
        $plan = config('streaming.plans')[$station->plan] ?? null;

        if (!$plan || $listeners === null) {
            return false;
        }

        return $listeners > ($plan['max_listeners'] ?? PHP_INT_MAX);
    }

    public function enforce(Station $station): void
    {
        if ($this->shouldSuspend($station)) {
            if ($station->status !== Station::STATUS_SUSPENDED) {
                $station->update(['status' => Station::STATUS_SUSPENDED]);
            }
        } elseif ($station->status === Station::STATUS_SUSPENDED) {
            $station->update(['status' => Station::STATUS_ACTIVE]);
        }
    }
}
