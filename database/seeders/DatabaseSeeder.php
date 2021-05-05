<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        print_r(['seeding']);
        $this->call([
            TrackSpamSeeder::class,
        ]);
        print_r(['seeded']);
    }
}
