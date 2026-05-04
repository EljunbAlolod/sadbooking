<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE reservations MODIFY COLUMN status ENUM('pending','approved','rejected','active','completed','cancelled') NOT NULL DEFAULT 'pending'");
            DB::statement("ALTER TABLE utility_bills MODIFY COLUMN bill_type ENUM('electric','water','monthly_bh') NOT NULL");
        }

        Schema::table('utility_bills', function (Blueprint $table): void {
            $table->timestamp('tenant_viewed_at')->nullable()->after('updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('utility_bills', function (Blueprint $table): void {
            $table->dropColumn('tenant_viewed_at');
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE reservations MODIFY COLUMN status ENUM('pending','approved','rejected','active','completed') NOT NULL DEFAULT 'pending'");
            DB::statement("ALTER TABLE utility_bills MODIFY COLUMN bill_type ENUM('electric','water') NOT NULL");
        }
    }
};
