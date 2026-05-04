<?php

namespace App\Http\Controllers\Landlord;

use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandlordDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $landlord = $request->user();

        $boardingHouseCount = BoardingHouse::where('landlord_id', $landlord->id)->count();
        $pendingReservations = Reservation::query()
            ->whereHas('room.boardingHouse', fn ($q) => $q->where('landlord_id', $landlord->id))
            ->where('status', ReservationStatus::Pending)
            ->count();

        $boardingHouses = BoardingHouse::query()
            ->where('landlord_id', $landlord->id)
            ->withCount('rooms')
            ->with('amenities')
            ->latest()
            ->limit(8)
            ->get();

        $recentReservations = Reservation::query()
            ->whereHas('room.boardingHouse', fn ($q) => $q->where('landlord_id', $landlord->id))
            ->with(['tenant', 'room.boardingHouse'])
            ->latest()
            ->limit(12)
            ->get();

        return view('landlord.dashboard', [
            'boardingHouseCount' => $boardingHouseCount,
            'pendingReservations' => $pendingReservations,
            'boardingHouses' => $boardingHouses,
            'recentReservations' => $recentReservations,
        ]);
    }
}
