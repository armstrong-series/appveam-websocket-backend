<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Actions\LoginAction;
use Symfony\Component\HttpFoundation\JsonResponse;


class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __construct(private LoginAction $loginAction) {}


    public function signIn(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        return appVeamResponse(
            $this->loginAction->execute($credentials),
            200,
            'Authenticated!'
        );
    }
}