<?php

namespace Sfneal\Honeypot\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Support\Facades\View;
use Sfneal\Honeypot\HoneypotServiceProvider;
use Sfneal\Honeypot\Tests\TestClasses\FakeEncrypter;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithContainer;

    protected $testNow = true;

    public function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__.'/views');

        $this->swap('encrypter', new FakeEncrypter());
    }

    protected function getPackageProviders($app)
    {
        return [HoneypotServiceProvider::class];
    }
}
