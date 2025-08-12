<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{


    public function login(array $credentials): string
    {
        if (! $token = Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid email or password.'],
            ]);
        }

        return $token;
    }


    public function logout(): void
    {
        Auth::logout();
    }

    /**
     * Refresh JWT token.
     */
    public function refresh(): string
    {
        return Auth::refresh();
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function me()
    {
        return Auth::user();
    }
}