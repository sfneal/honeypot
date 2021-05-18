<?php

namespace Sfneal\Honeypot\Tests\Feature;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sfneal\Honeypot\Models\TrackSpam;
use Sfneal\Honeypot\Tests\Database\Seeders\DatabaseSeeder;
use Sfneal\Honeypot\Tests\TestCase;
use Sfneal\Queries\RandomModelAttributeQuery;
use Sfneal\Testing\Utils\Interfaces\Factory\FillablesTest;
use Sfneal\Testing\Utils\Interfaces\ModelRelationshipsTest;
use Sfneal\Tracking\Models\TrackTraffic;

class FactoriesTest extends TestCase implements FillablesTest, ModelRelationshipsTest
{
    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * @var TrackSpam
     */
    public $model;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        // Find a random TrackSpam model
        $this->model = TrackSpam::query()->find(
            (new RandomModelAttributeQuery(
                TrackSpam::class,
                TrackSpam::getPrimaryKeyName()
            ))->execute()
        );
    }

    /** @test */
    public function fillables_are_correct_types()
    {
        $this->assertIsInt($this->model->getKey());
        $this->assertIsString($this->model->request_token);
    }

    /** @test */
    public function relationships_are_accessible()
    {
        $this->assertEquals($this->model->tracking->request_token, $this->model->request_token);
        $this->assertNotNull($this->model->tracking);
        $this->assertNotNull($this->model->tracking());
        $this->assertInstanceOf(TrackTraffic::class, $this->model->tracking);
        $this->assertInstanceOf(BelongsTo::class, $this->model->tracking());
    }
}
