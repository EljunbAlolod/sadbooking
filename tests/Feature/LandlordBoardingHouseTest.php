<?php

use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('allows a landlord to create a boarding house with first room and photo', function (): void {
    Storage::fake('public');

    $landlord = User::factory()->landlord()->create();

    $photo = UploadedFile::fake()->image('house.jpg', 800, 600);

    $this->actingAs($landlord)
        ->post(route('landlord.boarding-houses.store'), [
            'title' => 'Sunset Dorms',
            'description' => 'Near campus.',
            'address' => '123 Main St',
            'room_number' => '101',
            'monthly_rate' => '3500.00',
            'capacity' => '2',
            'photo' => $photo,
        ])
        ->assertRedirect(route('landlord.boarding-houses.index'));

    $house = BoardingHouse::query()->where('title', 'Sunset Dorms')->first();
    expect($house)->not->toBeNull()
        ->and($house->photo_path)->not->toBeNull();

    Storage::disk('public')->assertExists($house->photo_path);

    $room = Room::query()->where('boarding_house_id', $house->id)->first();
    expect($room)->room_number->toBe('101');
    expect((float) $room->monthly_rate)->toBe(3500.0);
});

it('forbids tenants from creating boarding houses', function (): void {
    $tenant = User::factory()->create();

    $this->actingAs($tenant)
        ->post(route('landlord.boarding-houses.store'), [
            'title' => 'X',
            'address' => 'Y',
            'room_number' => '1',
            'monthly_rate' => '100',
        ])
        ->assertForbidden();
});
