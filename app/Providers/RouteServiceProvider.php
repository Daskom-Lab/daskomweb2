<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    public const ASSISTANT = '/assistant';
    public const PRAKTIKAN = '/praktikan';
    public function register(): void
    {
        Model::unguard();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
