<?php

namespace Sfneal\Honeypot\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Sfneal\Honeypot\Middleware\HoneyPot;
use Sfneal\Honeypot\Tests\TestCase;

class MiddlewareTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Enable middleware
        Route::middleware(HoneyPot::class)->any('/', function () {
            return 'OK';
        });
    }

    /** @test */
    public function non_spam_request()
    {
        $response = $this->post('/', [
            'name_first' => 'David',
            'name_last' => 'Patrnak',
        ], ['request_token' => uniqid()]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function spam_request()
    {
        $response = $this->post('/', [
            config('honeypot.name_field_name') => 'David',
        ], ['request_token' => uniqid()]);

        $this->assertEquals(500, $response->getStatusCode());
        $response->assertSee('Server Error');
    }
}
