<?php

namespace App\Models\Contracts;

use App\Models\User;

interface AccessibleByUser
{
    public function scopeAccessibleBy($query, User $user);
}
