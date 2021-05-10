<?php

namespace Sfneal\Honeypot\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Sfneal\Helpers\Redis\Providers\RedisHelpersServiceProvider;
use Sfneal\Honeypot\Providers\HoneypotServiceProvider;
use Sfneal\Tracking\Providers\TrackingServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    /**
     * Register package service providers.
     *
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            HoneypotServiceProvider::class,
            TrackingServiceProvider::class,
            RedisHelpersServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        if (! defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }

        // Set config values
        $app['config']->set('tracking.traffic.track', true);
        $app['config']->set('tracking.driver', 'sync');


        // Migrate 'track_traffic' table
        include_once __DIR__.'/../vendor/sfneal/tracking/database/migrations/create_track_traffic_table.php.stub';
        (new \CreateTrackTrafficTable())->up();

        // Migrate 'track_spam' table
        include_once __DIR__.'/../database/migrations/create_track_spam_table.php.stub';
        (new \CreateTrackSpamTable())->up();
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__.'/views');
    }
}
