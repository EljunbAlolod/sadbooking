<?php

namespace Database\Factories;

use App\Enums\RoomStatus;
use App\Models\BoardingHouse;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'boarding_house_id' => BoardingHouse::factory(),
            'room_number' => (string) fake()->unique()->numberBetween(1, 500),
            'capacity' => fake()->numberBetween(1, 4),
            'current_occupants' => 0,
            'monthly_rate' => fake()->randomFloat(2, 2000, 15000),
            'status' => RoomStatus::Available,
            'photo_path' => null,
        ];
    }
}
