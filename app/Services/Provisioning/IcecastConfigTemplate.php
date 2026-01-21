<?php

namespace App\Services\Provisioning;

use App\Models\Station;
use Illuminate\Support\Facades\Crypt;

class IcecastConfigTemplate
{
    public function build(Station $station): array
    {
        $plans = config('streaming.plans');
        $plan = $plans[$station->plan] ?? [];

        return [
            'source_password' => Crypt::decryptString($station->source_password),
            'admin_user' => 'admin',
            'admin_password' => Crypt::decryptString($station->admin_password),
            'mount_low' => $station->mount_low,
            'mount_normal' => $station->mount_normal,
            'bitrate_low' => $station->bitrate_low,
            'bitrate_normal' => $station->bitrate_normal,
            'max_listeners' => $plan['max_listeners'] ?? 300,
        ];
    }
}
