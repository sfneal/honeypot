<?php

namespace Sfneal\Honeypot\Tests\Spatie;

use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Sfneal\Honeypot\Tests\Spatie\TestClasses\FakeEncrypter;

abstract class TestCase extends \Sfneal\Honeypot\Tests\TestCase
{
    use InteractsWithContainer;

    protected $testNow = true;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->swap('encrypter', new FakeEncrypter());
    }
}
