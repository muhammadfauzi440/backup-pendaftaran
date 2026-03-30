<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Policies\PendaftaranPolicy;
use App\Policies\UserPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // if (str_contains(request()->getHost(), 'ngrok-free.dev')) {
        //     URL::forceScheme('https');
        // }
        Gate::policy(Pendaftaran::class, PendaftaranPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
