<?php

namespace Sfneal\Honeypot\Tests\Unit;

use Sfneal\Honeypot\Middleware\HoneyPot;
use Sfneal\Honeypot\Models\TrackSpam;
use Sfneal\Honeypot\Tests\TestCase;
use Sfneal\Testing\Utils\Interfaces\MiddlewareEnabler;
use Sfneal\Testing\Utils\Traits\EnableMiddleware;
use Sfneal\Tracking\Middleware\TrackTrafficMiddleware;
use Sfneal\Tracking\Models\TrackTraffic;

class HoneypotTest extends TestCase implements MiddlewareEnabler
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
    public function spam_is_being_tracked()
    {
        // Assert that no `TrackTraffic` or `TrackSpam` models exist
        $this->assertEquals(0, TrackTraffic::query()->count());
        $this->assertEquals(0, TrackSpam::query()->count());

        $data = [
            'name_first' => 'Patrice',
            'name_last' => 'Bergeron',
            config('honeypot.name_field_name') => 'Patrice',
        ];
        $response = $this->post('/', $data);

        // Response assertions
        $this->assertStringContainsString("If you're a robot, you've been caught by a human.", $response->content());
        $this->assertEquals(200, $response->getStatusCode());

        // Confirm a `TrackTraffic` and a `TrackSpam` model was created
        $this->assertEquals(1, TrackTraffic::query()->count());
        $this->assertEquals(1, TrackSpam::query()->count());

        // Get the created `TrackSpam` model
        $trackSpam = TrackSpam::query()->first();

        $this->assertNotNull($trackSpam->tracking);
        $this->assertInstanceOf(TrackTraffic::class, $trackSpam->tracking);
        $this->assertEquals($data, $trackSpam->tracking->request_payload);
    }

    /** @test */
    public function spam_is_not_being_tracked()
    {
        // Assert that no `TrackTraffic` or `TrackSpam` models exist
        $this->assertEquals(0, TrackTraffic::query()->count());
        $this->assertEquals(0, TrackSpam::query()->count());

        $data = [
            'name_first' => 'Patrice',
            'name_last' => 'Bergeron',
        ];
        $response = $this->post('/', $data);

        // Response assertions
        $this->assertEquals(200, $response->getStatusCode());
        $response->assertSee('OK');

        // Confirm a `TrackTraffic` and a `TrackSpam` model was created
        $this->assertEquals(1, TrackTraffic::query()->count());
        $this->assertEquals(0, TrackSpam::query()->count());

        $traffic = TrackTraffic::query()->first();
        $this->assertEquals($data, $traffic->request_payload);
    }
}
