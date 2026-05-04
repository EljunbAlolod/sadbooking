<?php

use App\Enums\UtilityBillStatus;
use App\Enums\UtilityBillType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utility_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->enum('bill_type', array_map(fn (UtilityBillType $t) => $t->value, UtilityBillType::cases()));
            $table->decimal('amount', 10, 2);
            $table->date('billing_month');
            $table->date('due_date');
            $table->enum('status', array_map(fn (UtilityBillStatus $s) => $s->value, UtilityBillStatus::cases()))->default(UtilityBillStatus::Unpaid->value);
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utility_bills');
    }
};
