<?php

namespace Sfneal\Honeypot\Tests\Spatie;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Support\Facades\View;
use Sfneal\Honeypot\Tests\Spatie\TestClasses\FakeEncrypter;
use Spatie\Honeypot\HoneypotServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithContainer;

    protected $testNow = true;

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

        View::addLocation(__DIR__.'/../views');

        $this->swap('encrypter', new FakeEncrypter());
    }
}
