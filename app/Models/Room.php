<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use App\Enums\RoomStatus;
use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable(['boarding_house_id', 'room_number', 'capacity', 'current_occupants', 'monthly_rate', 'status', 'photo_path'])]
class Room extends Model
{
    /** @use HasFactory<RoomFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => RoomStatus::class,
            'monthly_rate' => 'decimal:2',
            'capacity' => 'integer',
            'current_occupants' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<BoardingHouse, $this>
     */
    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    /**
     * @return HasMany<Reservation, $this>
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * @return HasMany<UtilityBill, $this>
     */
    public function utilityBills(): HasMany
    {
        return $this->hasMany(UtilityBill::class);
    }

    /**
     * @return HasMany<RoomPhoto, $this>
     */
    public function photos(): HasMany
    {
        return $this->hasMany(RoomPhoto::class)->orderBy('sort_order');
    }

    /**
     * @return BelongsToMany<Amenity, $this>
     */
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class)->withTimestamps();
    }

    public function photoUrl(): ?string
    {
        $first = $this->photos->first();
        if ($first) {
            return $first->url();
        }

        if (!$this->photo_path) {
            return null;
        }

        return Storage::disk('public')->url($this->photo_path);
    }

    public function occupiedSlots(): int
    {
        return (int) $this->reservations()
            ->whereIn('status', [ReservationStatus::Approved, ReservationStatus::Active])
            ->where(function ($query) {
                $query->whereDate('end_date', '>=', now())
                    ->orWhereNull('end_date');
            })
            ->count();
    }

    public function hasAvailableCapacity(): bool
    {
        return $this->status === RoomStatus::Available && $this->current_occupants < $this->capacity;
    }

    public function syncOccupantCountFromReservations(): void
    {
        $this->current_occupants = $this->occupiedSlots();
        if ($this->current_occupants >= $this->capacity) {
            $this->status = RoomStatus::Full;
        } else {
            $this->status = RoomStatus::Available;
        }

        $this->saveQuietly();
    }

    protected static function booted(): void
    {
        static::saving(function (Room $room): void {
            if ($room->current_occupants >= $room->capacity) {
                $room->status = RoomStatus::Full;
            } elseif ($room->status === RoomStatus::Full && $room->current_occupants < $room->capacity) {
                $room->status = RoomStatus::Available;
            }
        });
    }
}
