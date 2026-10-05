<?php

return [
    // Application Service Providers...
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    // App\Providers\BroadcastServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    SantiGraviano\LaravelMercadoPago\Providers\MercadoPagoServiceProvider::class,
];
