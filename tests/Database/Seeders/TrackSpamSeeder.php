<?php

namespace Sfneal\Honeypot\Tests\Database\Seeders;

use Illuminate\Database\Seeder;
use Sfneal\Honeypot\Models\TrackSpam;
use Sfneal\Tracking\Models\TrackTraffic;

class TrackSpamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrackSpam::factory()
            ->count(100)
            ->for(TrackTraffic::factory(), 'tracking')
            ->create();
    }
}
