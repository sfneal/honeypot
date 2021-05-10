<?php

namespace Sfneal\Honeypot\Tests\Feature;

use Sfneal\Honeypot\Middleware\HoneyPot;
use Sfneal\Honeypot\Tests\TestCase;
use Sfneal\Testing\Utils\Interfaces\MiddlewareEnabler;
use Sfneal\Testing\Utils\Traits\EnableMiddleware;
use Sfneal\Tracking\Middleware\TrackTrafficMiddleware;

class MiddlewareTest extends TestCase implements MiddlewareEnabler
{
    use EnableMiddleware;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Enable middleware
        $this->enableMiddleware([TrackTrafficMiddleware::class, HoneyPot::class]);
    }

    /** @test */
    public function non_spam_request()
    {
        $response = $this->post('/', [
            'name_first' => 'David',
            'name_last' => 'Patrnak',
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $response->assertSee('OK');
    }

    /** @test */
    public function spam_request()
    {
        $response = $this->post('/', [
            'name_first' => 'David',
            'name_last' => 'Patrnak',
            config('honeypot.name_field_name') => 'David',
        ]);

        $this->assertStringContainsString("If you're a robot, you've been caught by a human.", $response->content());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function spam_request_with_repeated_inputs()
    {
        $response = $this->post('/', [
            'data.name_first' => 'David',
            'data.name_last' => 'David',
        ]);

        $this->assertStringContainsString("If you're a robot, you've been caught by a human.", $response->content());
        $this->assertEquals(200, $response->getStatusCode());
    }
}
