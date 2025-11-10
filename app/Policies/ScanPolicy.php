<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Scan;
use App\Models\User;

class ScanPolicy
{
    public function view(User $user, Scan $scan): bool
    {
        return $scan->user_id === $user->getKey();
    }

    public function delete(User $user, Scan $scan): bool
    {
        return false;
    }
}
