<?php

namespace App\Models;

use App\Enums\RoomStatus;
use Database\Factories\BoardingHouseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable(['landlord_id', 'title', 'description', 'street', 'barangay', 'city', 'province', 'photo_path'])]
class BoardingHouse extends Model
{
    /** @use HasFactory<BoardingHouseFactory> */
    use HasFactory;

    /**
     * Get the full formatted address.
     */
    public function getFullAddressAttribute(): string
    {
        return collect([$this->street, $this->barangay, $this->city, $this->province])
            ->filter()
            ->implode(', ');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function landlord(): BelongsTo
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    /**
     * @return HasMany<Room, $this>
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * @return BelongsToMany<Amenity, $this>
     */
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class)->withTimestamps();
    }

    /**
     * @return HasMany<BoardingHousePhoto, $this>
     */
    public function photos(): HasMany
    {
        return $this->hasMany(BoardingHousePhoto::class)->orderBy('sort_order');
    }

    /**
     * Get the accessible cover photo URL for the boarding house.
     */
    public function photoUrl(): ?string
    {
        $firstPhoto = $this->photos->first();
        if ($firstPhoto) {
            return $firstPhoto->url();
        }

        if ($this->photo_path === null || $this->photo_path === '') {
            return null;
        }

        return Storage::disk('public')->url($this->photo_path);
    }

    /**
     * Get the count of rooms that currently have available capacity.
     */
    public function availableRoomsCount(): int
    {
        return $this->rooms()
            ->where('status', RoomStatus::Available)
            ->whereColumn('current_occupants', '<', 'capacity')
            ->count();
    }
}
