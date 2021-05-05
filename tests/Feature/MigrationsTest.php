<?php

namespace Sfneal\Honeypot\Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Sfneal\Honeypot\Models\TrackSpam;
use Sfneal\Honeypot\Tests\TestCase;
use Sfneal\Testing\Utils\Traits\ModelAttributeAssertions;

class MigrationsTest extends TestCase
{
    use ModelAttributeAssertions;

    /** @test  */
    public function track_spam_table_is_exists()
    {
        $this->assertTrue(Schema::hasTable(TrackSpam::getTableName()));
    }

    /** @test  */
    public function track_spam_table_is_accessible()
    {
        $data = [
            'request_token' => uniqid()
        ];

        $createdModel = TrackSpam::query()->create($data);
        $foundModel = TrackSpam::query()->find($createdModel->getKey());

        $this->assertModelAttributesSame($data, $foundModel);
    }
}
