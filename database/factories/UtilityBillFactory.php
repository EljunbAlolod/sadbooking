<?php

namespace Database\Factories;

use App\Enums\UtilityBillStatus;
use App\Enums\UtilityBillType;
use App\Models\Room;
use App\Models\User;
use App\Models\UtilityBill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UtilityBill>
 */
class UtilityBillFactory extends Factory
{
    protected $model = UtilityBill::class;

    public function definition(): array
    {
        return [
            'tenant_id' => User::factory(),
            'room_id' => Room::factory(),
            'bill_type' => fake()->randomElement(UtilityBillType::cases()),
            'amount' => fake()->randomFloat(2, 100, 5000),
            'billing_month' => now()->startOfMonth(),
            'due_date' => now()->addDays(14),
            'status' => UtilityBillStatus::Unpaid,
        ];
    }
}
