<?php

namespace Database\Factories;

use App\Models\BoardingHouse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BoardingHouse>
 */
class BoardingHouseFactory extends Factory
{
    protected $model = BoardingHouse::class;

    public function definition(): array
    {
        return [
            'landlord_id' => User::factory()->landlord(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'address' => fake()->address(),
            'photo_path' => null,
        ];
    }
}
