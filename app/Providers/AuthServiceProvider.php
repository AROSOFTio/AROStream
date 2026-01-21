<?php

namespace App\Providers;

use App\Models\Domain;
use App\Models\Station;
use App\Models\Tenant;
use App\Policies\DomainPolicy;
use App\Policies\StationPolicy;
use App\Policies\TenantPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Station::class => StationPolicy::class,
        Domain::class => DomainPolicy::class,
        Tenant::class => TenantPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
