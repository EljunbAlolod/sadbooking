<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Amenity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        foreach (
            [
                ['name' => 'Wi‑Fi', 'icon' => 'wifi'],
                ['name' => 'Air conditioning', 'icon' => 'ac'],
                ['name' => 'Shared kitchen', 'icon' => 'kitchen'],
                ['name' => 'Laundry', 'icon' => 'laundry'],
                ['name' => 'Parking', 'icon' => 'parking'],
            ] as $amenity
        ) {
            Amenity::query()->firstOrCreate(
                ['name' => $amenity['name']],
                ['icon' => $amenity['icon']]
            );
        }

        User::factory()->create([
            'name' => 'Test Tenant',
            'email' => 'tenant@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Tenant,
        ]);

        User::factory()->landlord()->create([
            'name' => 'Test Landlord',
            'email' => 'landlord@example.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->superAdmin()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
