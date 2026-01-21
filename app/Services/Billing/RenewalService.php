<?php

namespace App\Services\Billing;

use App\Models\Subscription;
use Carbon\Carbon;

class RenewalService
{
    public function extendOneYear(Subscription $subscription): Subscription
    {
        $subscription->forceFill([
            'renews_at' => Carbon::parse($subscription->renews_at ?? now())->addYear(),
            'status' => 'active',
        ])->save();

        return $subscription;
    }
}
