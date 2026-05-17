<?php

namespace App\Console\Commands;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Illuminate\Console\Command;

class ActivateApprovedReservations extends Command
{
    /**
     * @var string
     */
    protected $signature = 'reservations:activate';

    /**
     * @var string
     */
    protected $description = 'Activate approved reservations whose start date has been reached';

    public function handle(): int
    {
        $updated = Reservation::where('status', ReservationStatus::Approved)
            ->whereDate('start_date', '<=', now()->toDateString())
            ->update(['status' => ReservationStatus::Active]);

        $this->info("Activated {$updated} reservation(s).");

        return self::SUCCESS;
    }
}
