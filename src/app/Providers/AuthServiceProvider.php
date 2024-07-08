<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected function registered(Request $request, $user)
    {
        event(new Registered($user));

        if (config('fortify.features.emailVerification') &&
            $user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }
    }
}
