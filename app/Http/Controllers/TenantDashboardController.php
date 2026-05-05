<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Enums\RoomStatus;
use App\Models\BoardingHouse;
use App\Models\Reservation;
use App\Models\UtilityBill;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $currentStay = Reservation::query()
            ->where('tenant_id', $user->id)
            ->whereIn('status', [ReservationStatus::Approved, ReservationStatus::Active])
            ->where(function ($query) {
                $query->whereDate('end_date', '>=', now())
                    ->orWhereNull('end_date');
            })
            ->with(['room.boardingHouse.amenities'])
            ->latest('start_date')
            ->first();

        $recommendedBoardingHouses = BoardingHouse::query()
            ->with(['amenities', 'rooms'])
            ->whereHas('rooms', fn ($q) => $q->where('status', RoomStatus::Available))
            ->orderByDesc('boarding_houses.created_at')
            ->limit(8)
            ->get();

        $unseenBillNoticeCount = UtilityBill::query()
            ->where('tenant_id', $user->id)
            ->whereNull('tenant_viewed_at')
            ->count();

        return view('tenant.dashboard', [
            'currentStay' => $currentStay,
            'recommendedBoardingHouses' => $recommendedBoardingHouses,
            'unseenBillNoticeCount' => $unseenBillNoticeCount,
        ]);
    }
}
