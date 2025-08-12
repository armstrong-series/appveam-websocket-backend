<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->loadHelpers();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function loadHelpers()
    {
        $helperFile = app_path('Helpers/Helper.php');

        if (file_exists($helperFile)) {
            require_once $helperFile;
        }
    }
}