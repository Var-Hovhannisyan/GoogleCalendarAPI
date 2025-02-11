<?php

namespace App\Providers;

use App\Interfaces\AuthInterface;
use App\Interfaces\EventInterface;
use App\Interfaces\GoogleCalendarInterface;
use App\Services\AuthService;
use App\Services\EventService;
use App\Services\GoogleCalendarService;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(GoogleCalendarInterface::class, GoogleCalendarService::class);
        $this->app->bind(AuthInterface::class, AuthService::class);
        $this->app->bind(EventInterface::class, EventService::class);
    }
}
