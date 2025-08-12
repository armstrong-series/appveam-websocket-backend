<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use Illuminate\Support\Facades\Log;



Broadcast::channel(
    'customer.{customerId}',
    function (User $user, string $customerId) {
        $user->loadMissing('role');
        Log::emergency('Channel check', [
            'auth_user_id' => $user->id,
            'customerId' => $customerId,
            'equal' => (string) $user->id === (string) $customerId,
            'role' => $user->role?->name
        ]);

        if ($user->role?->name === 'admin') {
            return true;
        }

        return (string) $user->id === (string) $customerId;
        // return (string) $user->id === (string) $customerId || $user->role?->name === 'admin';
    },
);
