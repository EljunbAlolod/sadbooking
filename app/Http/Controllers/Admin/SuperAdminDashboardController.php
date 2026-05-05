<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReservationStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class SuperAdminDashboardController extends Controller
{
    /**
     * Handle the incoming request to display the Super Admin dashboard.
     * Aggregates key metrics for users, properties, and reservation trends.
     */
    public function __invoke(): View
    {
        // 1. Prepare Monthly User Registration Data (Last 6 Months for Chart.js)
        $months = collect(range(5, 0))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('M');
        });

        $registrationData = [
            'labels' => $months->toArray(),
            'landlords' => [],
            'tenants' => [],
        ];

        // Query registration counts for each month
        foreach (range(5, 0) as $i) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();

            $registrationData['landlords'][] = User::where('role', UserRole::Landlord)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();

            $registrationData['tenants'][] = User::where('role', UserRole::Tenant)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();
        }

        // 2. Aggregate Reservation Status Distribution for the Doughnut Chart
        $reservationStats = [
            'labels' => ['Active/Approved', 'Pending', 'Canceled/Rejected'],
            'data' => [
                Reservation::whereIn('status', [ReservationStatus::Active, ReservationStatus::Approved])->count(),
                Reservation::where('status', ReservationStatus::Pending)->count(),
                Reservation::whereIn('status', [ReservationStatus::Cancelled, ReservationStatus::Rejected])->count(),
            ],
            // Custom colors for the chart segments (Pink theme)
            'colors' => ['#db2777', '#f59e0b', '#ef4444'],
        ];

        // 3. Return the view with all required dashboard metrics
        return view('admin.dashboard', [
            'userCounts' => [
                'super_admin' => User::where('role', UserRole::SuperAdmin)->count(),
                'landlord' => User::where('role', UserRole::Landlord)->count(),
                'tenant' => User::where('role', UserRole::Tenant)->count(),
            ],
            'boardingHouseCount' => BoardingHouse::count(),
            'activeReservationCount' => $reservationStats['data'][0],
            'registrationTrend' => $registrationData,
            'reservationStats' => $reservationStats,
            'recentLandlords' => User::where('role', UserRole::Landlord)->latest()->take(5)->get(),
            'recentTenants' => User::where('role', UserRole::Tenant)->latest()->take(5)->get(),
        ]);
    }
}
