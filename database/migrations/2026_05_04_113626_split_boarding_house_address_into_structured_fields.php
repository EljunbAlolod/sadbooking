<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            $table->string('street', 500)->nullable()->after('address');
            $table->string('barangay', 255)->nullable()->after('street');
            $table->string('city', 255)->nullable()->after('barangay');
            $table->string('province', 255)->nullable()->after('city');
        });

        // Copy existing address data into the street column
        DB::table('boarding_houses')->whereNotNull('address')->update([
            'street' => DB::raw('address'),
        ]);

        Schema::table('boarding_houses', function (Blueprint $table) {
            $table->dropColumn('address');
        });
    }

    public function down(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            $table->string('address', 500)->nullable()->after('description');
        });

        DB::table('boarding_houses')->whereNotNull('street')->update([
            'address' => DB::raw('street'),
        ]);

        Schema::table('boarding_houses', function (Blueprint $table) {
            $table->dropColumn(['street', 'barangay', 'city', 'province']);
        });
    }
};
