<?php

use App\Enums\RoomStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boarding_house_id')->constrained()->cascadeOnDelete();
            $table->string('room_number');
            $table->unsignedInteger('capacity')->default(1);
            $table->unsignedInteger('current_occupants')->default(0);
            $table->decimal('monthly_rate', 10, 2);
            $table->enum('status', array_map(fn (RoomStatus $s) => $s->value, RoomStatus::cases()))->default(RoomStatus::Available->value);
            $table->timestamps();

            $table->unique(['boarding_house_id', 'room_number']);
            $table->index('monthly_rate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
