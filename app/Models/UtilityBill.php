<?php

namespace App\Models;

use App\Enums\UtilityBillStatus;
use App\Enums\UtilityBillType;
use Database\Factories\UtilityBillFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['tenant_id', 'room_id', 'bill_type', 'amount', 'billing_month', 'due_date', 'status', 'tenant_viewed_at'])]
class UtilityBill extends Model
{
    /** @use HasFactory<UtilityBillFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'bill_type' => UtilityBillType::class,
            'status' => UtilityBillStatus::class,
            'amount' => 'decimal:2',
            'billing_month' => 'date',
            'due_date' => 'date',
            'tenant_viewed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * @return BelongsTo<Room, $this>
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
