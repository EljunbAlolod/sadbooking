<?php

namespace Database\Factories;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 month', '+1 month');
        $end = (clone $start)->modify('+'.fake()->numberBetween(1, 6).' months');

        return [
            'tenant_id' => User::factory(),
            'room_id' => Room::factory(),
            'start_date' => $start,
            'end_date' => $end,
            'status' => ReservationStatus::Pending,
        ];
    }
}
