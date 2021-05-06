<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sfneal\Honeypot\Models\TrackSpam;

class TrackSpamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrackSpam::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'request_token' => $this->faker->uuid,
        ];
    }
}
