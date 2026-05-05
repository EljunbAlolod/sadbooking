<?php

use App\Http\Controllers\Admin\SuperAdminDashboardController;
use App\Http\Controllers\Admin\SuperAdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Landlord\LandlordBoardingHouseController;
use App\Http\Controllers\Landlord\LandlordDashboardController;
use App\Http\Controllers\Landlord\LandlordReservationController;
use App\Http\Controllers\Landlord\LandlordRoomController;
use App\Http\Controllers\Landlord\LandlordTenantController;
use App\Http\Controllers\Landlord\LandlordUtilityBillController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBoardingHouseController;
use App\Http\Controllers\TenantBillNoticeController;
use App\Http\Controllers\TenantDashboardController;
use App\Http\Controllers\TenantReservationController;
use App\Http\Controllers\TenantReservationManagementController;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Marketplace & Property Discovery (Tenants Only)
Route::middleware(['auth', 'verified', 'role:tenant'])->group(function () {
    Route::get('/boarding-houses', [PublicBoardingHouseController::class, 'index'])->name('boarding-houses.index');
    Route::get('/boarding-houses/{boarding_house}', [PublicBoardingHouseController::class, 'show'])->name('boarding-houses.show');
});

// General Dashboard Redirector
Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

// User Profile Management
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Tenant Specific Routes (Dashboard, Reservations, Bill Notices)
Route::middleware(['auth', 'verified', 'role:tenant'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/dashboard', TenantDashboardController::class)->name('dashboard');
    Route::get('/boarding-houses/{boarding_house}/rooms/{room}/reserve', [TenantReservationController::class, 'create'])->name('reservations.create');
    Route::post('/boarding-houses/{boarding_house}/rooms/{room}/reserve', [TenantReservationController::class, 'store'])->name('reservations.store');

    Route::get('/reservations', [TenantReservationManagementController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [TenantReservationManagementController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{reservation}/edit', [TenantReservationManagementController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{reservation}', [TenantReservationManagementController::class, 'update'])->name('reservations.update');
    Route::post('/reservations/{reservation}/cancel', [TenantReservationManagementController::class, 'cancel'])->name('reservations.cancel');

    Route::get('/bill-notices', [TenantBillNoticeController::class, 'index'])->name('bill-notices.index');
});

// Landlord Specific Routes (Dashboard, Properties, Rooms, Tenants, Bills)
Route::middleware(['auth', 'verified', 'role:landlord'])->prefix('landlord')->name('landlord.')->group(function () {
    Route::get('/dashboard', LandlordDashboardController::class)->name('dashboard');
    Route::resource('boarding-houses', LandlordBoardingHouseController::class)->except(['show']);

    // Room Management under a specific Boarding House
    Route::get('boarding-houses/{boarding_house}/rooms', [LandlordRoomController::class, 'index'])->name('boarding-houses.rooms.index');
    Route::get('boarding-houses/{boarding_house}/rooms/create', [LandlordRoomController::class, 'create'])->name('boarding-houses.rooms.create');
    Route::post('boarding-houses/{boarding_house}/rooms', [LandlordRoomController::class, 'store'])->name('boarding-houses.rooms.store');
    Route::get('boarding-houses/{boarding_house}/rooms/{room}/edit', [LandlordRoomController::class, 'edit'])->name('boarding-houses.rooms.edit');
    Route::put('boarding-houses/{boarding_house}/rooms/{room}', [LandlordRoomController::class, 'update'])->name('boarding-houses.rooms.update');
    Route::delete('boarding-houses/{boarding_house}/rooms/{room}', [LandlordRoomController::class, 'destroy'])->name('boarding-houses.rooms.destroy');

    Route::get('boarding-houses/{boarding_house}', [LandlordBoardingHouseController::class, 'show'])->name('boarding-houses.show');

    // Tenant and Reservation Review Management
    Route::get('/tenants', [LandlordTenantController::class, 'index'])->name('tenants.index');
    Route::post('/tenants/{reservation}/remove', [LandlordTenantController::class, 'remove'])->name('tenants.remove');
    Route::get('/reservations', [LandlordReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/history', [LandlordReservationController::class, 'history'])->name('reservations.history');
    Route::get('/reservations/{reservation}', [LandlordReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{reservation}/approve', [LandlordReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('/reservations/{reservation}/reject', [LandlordReservationController::class, 'reject'])->name('reservations.reject');
    Route::delete('/reservations/{reservation}', [LandlordReservationController::class, 'destroy'])->name('reservations.destroy');

    // Utility Bill Issuance
    Route::get('/bills', [LandlordUtilityBillController::class, 'index'])->name('bills.index');
    Route::get('/bills/create', [LandlordUtilityBillController::class, 'create'])->name('bills.create');
    Route::post('/bills', [LandlordUtilityBillController::class, 'store'])->name('bills.store');
    Route::get('/bills/{utility_bill}/edit', [LandlordUtilityBillController::class, 'edit'])->name('bills.edit');
    Route::put('/bills/{utility_bill}', [LandlordUtilityBillController::class, 'update'])->name('bills.update');
    Route::delete('/bills/{utility_bill}', [LandlordUtilityBillController::class, 'destroy'])->name('bills.destroy');
    Route::patch('/bills/{utility_bill}/paid', [LandlordUtilityBillController::class, 'markPaid'])->name('bills.paid');
});

// Super Admin Specific Routes (Global Dashboard, User Management)
Route::middleware(['auth', 'verified', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', SuperAdminDashboardController::class)->name('dashboard');
    Route::get('/landlords', [SuperAdminUserController::class, 'indexLandlords'])->name('landlords.index');
    Route::get('/tenants', [SuperAdminUserController::class, 'indexTenants'])->name('tenants.index');
    Route::get('/users/{user}/edit', [SuperAdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [SuperAdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [SuperAdminUserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
