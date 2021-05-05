<?php

namespace Sfneal\Honeypot\Providers;

use Illuminate\Support\ServiceProvider;

class HoneypotServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any Honeypot services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config file
        $this->publishes([
            __DIR__.'/../../config/honeypot.php' => config_path('honeypot.php'),
        ], 'config');
    }

    /**
     * Register any Honeypot services.
     *
     * @return void
     */
    public function register()
    {
        // Load config file
        $this->mergeConfigFrom(__DIR__.'/../../config/honeypot.php', 'honeypot');
    }
}
