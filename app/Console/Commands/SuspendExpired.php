<?php

namespace App\Console\Commands;

use App\Jobs\SuspendExpiredStationsJob;
use Illuminate\Console\Command;

class SuspendExpired extends Command
{
    protected $signature = 'stream:suspend-expired';
    protected $description = 'Suspend stations with expired subscriptions';

    public function handle(): void
    {
        SuspendExpiredStationsJob::dispatch();
        $this->info('Suspend expired job dispatched');
    }
}
