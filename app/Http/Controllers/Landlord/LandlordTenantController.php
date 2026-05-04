<?php

namespace App\Http\Controllers\Landlord;

use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandlordTenantController extends Controller
{
    public function index(Request $request): View
    {
        $landlordId = $request->user()->id;

        $reservations = Reservation::query()
            ->with(['tenant', 'room.boardingHouse'])
            ->whereHas('room.boardingHouse', fn($q) => $q->where('landlord_id', $landlordId))
            ->whereIn('status', [ReservationStatus::Approved, ReservationStatus::Active])
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->latest('start_date')
            ->get();

        return view('landlord.tenants.index', ['reservations' => $reservations]);
    }

    public function remove(Request $request, Reservation $reservation): RedirectResponse
    {
        // Authorize that the landlord owns this reservation
        $reservation->load('room.boardingHouse');
        if ((int) $reservation->room->boardingHouse->landlord_id !== (int) $request->user()->id) {
            abort(403);
        }

        // Set status to Completed or Cancelled and set end_date to now
        $reservation->update([
            'status' => ReservationStatus::Completed,
            'end_date' => now(),
        ]);

        // Sync room occupancy
        $reservation->room->syncOccupantCountFromReservations();

        return back()->with('status', __('Tenant removed successfully. Their stay has been marked as completed.'));
    }
}
