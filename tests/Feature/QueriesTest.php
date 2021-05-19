<?php

namespace Sfneal\Honeypot\Tests\Feature;

use Illuminate\Database\Eloquent\Collection;
use Sfneal\Honeypot\Models\TrackSpam;
use Sfneal\Honeypot\Queries\TrackSpamQuery;
use Sfneal\Honeypot\Tests\Database\Seeders\DatabaseSeeder;
use Sfneal\Honeypot\Tests\TestCase;
use Sfneal\Tracking\Models\TrackTraffic;

class QueriesTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Run seeder
        $this->seed(DatabaseSeeder::class);
    }

    /** @test */
    public function track_spam_query_returns_expected()
    {
        $expected = TrackSpam::query()
            ->limit(200)
            ->get();

        $result = (new TrackSpamQuery())->execute();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($expected->count(), $result->count());
        $this->assertEquals($expected->pluck('track_spam_id'), $result->pluck('track_spam_id'));
        $this->assertEquals($expected, $result);
        $result->each(function (TrackSpam $trackSpam) {
            $this->assertNotNull($trackSpam->tracking);
            $this->assertInstanceOf(TrackTraffic::class, $trackSpam->tracking);
        });
    }

    /** @test */
    public function track_spam_query_is_cacheable()
    {
        $query = new TrackSpamQuery();

        $this->assertIsString($query->cacheKey());
        $this->assertFalse($query->isCached());

        $nonCached = $query->execute();
        $cached = $query->fetch();

        $this->assertInstanceOf(Collection::class, $nonCached);
        $this->assertInstanceOf(Collection::class, $cached);
        $this->assertSame($nonCached->count(), $cached->count());
        $this->assertEquals($nonCached, $cached);
        $this->assertTrue($query->isCached());
    }

    /** @test */
    public function track_spam_query_can_be_invalidated()
    {
        $query = new TrackSpamQuery();

        $query->fetch();

        $this->assertTrue($query->isCached());

        $query->invalidateCache();
        $this->assertFalse($query->isCached());
    }
}
