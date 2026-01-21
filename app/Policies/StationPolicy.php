<?php

namespace App\Policies;

use App\Models\Station;
use App\Models\User;

class StationPolicy
{
    public function view(User $user, Station $station): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $station->tenant_id === $user->tenant_id;
    }

    public function update(User $user, Station $station): bool
    {
        return $this->view($user, $station);
    }

    public function delete(User $user, Station $station): bool
    {
        return $user->isAdmin();
    }
}
