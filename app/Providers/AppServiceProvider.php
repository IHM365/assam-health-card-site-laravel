<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Console\Scheduling\Schedule;

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
        // Register custom notification channels
        $this->app->make(ChannelManager::class)->extend('sms', function ($app) {
            return $app->make(\App\Notifications\Channels\SmsChannel::class);
        });

        $this->app->make(ChannelManager::class)->extend('whatsapp', function ($app) {
            return $app->make(\App\Notifications\Channels\WhatsAppChannel::class);
        });

        // Schedule tasks
        $this->app->afterResolving(Schedule::class, function (Schedule $schedule) {
            // Auto-inactivate expired patient cards daily at 00:01
            $schedule->command('app:expire-patient-cards')->dailyAt('00:01');
        });
    }
}
