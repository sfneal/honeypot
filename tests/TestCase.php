<?php

namespace Sfneal\Honeypot\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sfneal\Honeypot\Tests\TestClasses\FakeEncrypter;
use Spatie\Honeypot\HoneypotServiceProvider;

abstract class TestCase extends OrchestraTestCase
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
