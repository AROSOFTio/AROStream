<?php

namespace App\Console\Commands;

use App\Jobs\CheckStationHealthJob;
use App\Models\Station;
use Illuminate\Console\Command;

class RunHealthChecks extends Command
{
    protected $signature = 'stream:health-check';
    protected $description = 'Dispatch health checks for active stations';

    public function handle(): void
    {
        Station::where('status', 'active')->pluck('id')->each(function ($id) {
            CheckStationHealthJob::dispatch($id);
        });

        $this->info('Health checks dispatched');
    }
}
