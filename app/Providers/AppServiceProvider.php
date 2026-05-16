<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

use App\Listeners\UserLoginListener;
use App\Listeners\UserLogoutListener;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        Login::class => [
            UserLoginListener::class,
        ],

        Logout::class => [
            UserLogoutListener::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}