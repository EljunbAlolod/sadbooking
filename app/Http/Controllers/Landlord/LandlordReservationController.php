<?php

namespace App\Http\Controllers\Landlord;

use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandlordReservationController extends Controller
{
    public function index(Request $request): View
    {
        $landlordId = $request->user()->id;

        $reservations = Reservation::query()
            ->with(['tenant', 'room.boardingHouse'])
            ->whereHas('room.boardingHouse', fn ($q) => $q->where('landlord_id', $landlordId))
            ->where('status', ReservationStatus::Pending)
            ->latest()
            ->paginate(15);

        return view('landlord.reservations.index', ['reservations' => $reservations]);
    }

    public function history(Request $request): View
    {
        $landlordId = $request->user()->id;

        $reservations = Reservation::query()
            ->with(['tenant', 'room.boardingHouse'])
            ->whereHas('room.boardingHouse', fn ($q) => $q->where('landlord_id', $landlordId))
            ->where('status', '!=', ReservationStatus::Pending)
            ->latest()
            ->paginate(15);

        return view('landlord.reservations.history', ['reservations' => $reservations]);
    }

    public function approve(Request $request, Reservation $reservation): RedirectResponse
    {
        $this->authorizeLandlordReservation($request, $reservation);

        $reservation->load('room');
        $room = $reservation->room;

        if (! $room->hasAvailableCapacity()) {
            return back()->with('error', __('Room is at full capacity.'));
        }

        $reservation->update(['status' => ReservationStatus::Approved]);
        $room->syncOccupantCountFromReservations();

        return back()->with('status', __('Reservation approved.'));
    }

    public function reject(Request $request, Reservation $reservation): RedirectResponse
    {
        $this->authorizeLandlordReservation($request, $reservation);

        $reservation->update(['status' => ReservationStatus::Rejected]);
        $reservation->room->syncOccupantCountFromReservations();

        return back()->with('status', __('Reservation rejected.'));
    }

    private function authorizeLandlordReservation(Request $request, Reservation $reservation): void
    {
        $reservation->load('room.boardingHouse');
        if ((int) $reservation->room->boardingHouse->landlord_id !== (int) $request->user()->id) {
            abort(403);
        }

        if ($reservation->status !== ReservationStatus::Pending) {
            abort(403);
        }
    }
}
