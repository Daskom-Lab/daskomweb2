<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\InertiaServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

];
