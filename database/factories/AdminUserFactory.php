<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => 1,
            'name' => 'ross',
            'password' => bcrypt('asdfasdf'),
            'ip_address' => $this->faker->ipv4(),
            'remember_token' => Str::random(10),
        ];
    }
}
