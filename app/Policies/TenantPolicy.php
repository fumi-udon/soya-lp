<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;

class TenantPolicy
{
    public function update(User $user, Tenant $tenant): bool
    {
        return true;
    }
}
