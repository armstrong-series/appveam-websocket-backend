<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use Illuminate\Support\Facades\Log;



Broadcast::channel('customer.{customerId}', function (User $user, string $customerId) {
    $user->load('role');

    if ($user->role && $user->role->name === 'admin') {
        return true;
    }

    if ($user->role && $user->role->name === 'customer' && (string) $user->id === (string) $customerId) {
        return true;
    }

    return false;
});
