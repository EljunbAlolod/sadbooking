<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable(['boarding_house_id', 'path', 'sort_order'])]
class BoardingHousePhoto extends Model
{
    /**
     * @return BelongsTo<BoardingHouse, $this>
     */
    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function url(): string
    {
        return Storage::disk('public')->url($this->path);
    }
}
