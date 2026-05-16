<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UserLoginListener
{
    public function handle(Login $event): void
    {
        $event->user->update([
            'is_online' => true
        ]);
    }
}