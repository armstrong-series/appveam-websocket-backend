<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;



if (!function_exists('mapRoutes')) {
    function mapRoutes()
    {
        $routes = [
            'auth'           => '/../routes/auth/auth.php',
            'payment'        => '/../routes/payment/payment.php',
            'broadcasting'   => '/../routes/broadcasting/broadcasting.php',
        ];
        foreach ($routes as $prefix => $routeFile) {
            if ($prefix === 'broadcasting') {
                require __DIR__ . $routeFile;
            } else {
                Route::prefix($prefix === 'default' ? '' : $prefix)->group(function () use ($routeFile) {
                    require __DIR__ . $routeFile;
                });
            }
        }
    }
}


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->group(function () {
                    mapRoutes();
                });
            require base_path('routes/channels.php');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'broadcasting/auth',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e): JsonResponse {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            return appVeamResponse([], 500, $e->getMessage(), false);
        });
        $exceptions->render(function (AuthenticationException $e): JsonResponse {
            return appVeamResponse([], 401, $e->getMessage(), false);
        });

        $exceptions->render(function (AuthorizationException $e): JsonResponse {
            return appVeamResponse([], 403, $e->getMessage(), false);
        });
    })->create();
