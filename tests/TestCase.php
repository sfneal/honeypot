<?php

namespace Sfneal\Honeypot\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\View;
use Sfneal\Honeypot\Providers\HoneypotServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Register package service providers.
     *
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            HoneypotServiceProvider::class
        ];
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
