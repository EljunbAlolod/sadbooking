<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReservationStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\View\View;

class SuperAdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'userCounts' => [
                'super_admin' => User::where('role', UserRole::SuperAdmin)->count(),
                'landlord' => User::where('role', UserRole::Landlord)->count(),
                'tenant' => User::where('role', UserRole::Tenant)->count(),
            ],
            'boardingHouseCount' => BoardingHouse::count(),
            'activeReservationCount' => Reservation::whereIn('status', [
                ReservationStatus::Active,
                ReservationStatus::Approved,
            ])->count(),
        ]);
    }
}
