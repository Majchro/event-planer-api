<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::guessPolicyNamesUsing(function (string $modelClass) {
            $path = str_replace('App\\Models\\', '', $modelClass);

            return "App\\Policies\\{$path}Policy";
        });
    }
}
