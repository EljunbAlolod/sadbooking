<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Enums\RoomStatus;
use App\Models\BoardingHouse;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantReservationController extends Controller
{
    public function create(BoardingHouse $boarding_house, Room $room): View|RedirectResponse
    {
        if ($room->boarding_house_id !== $boarding_house->id) {
            abort(404);
        }

        if ($this->tenantHasActiveStay(request()->user()->id)) {
            return redirect()
                ->route('boarding-houses.show', $boarding_house)
                ->with('error', __('You already have an active stay at a boarding house. Please complete your current stay before making a new reservation.'));
        }

        if ($room->status !== RoomStatus::Available || ! $room->hasAvailableCapacity()) {
            return redirect()
                ->route('boarding-houses.show', $boarding_house)
                ->with('error', __('This room is at full capacity.'));
        }

        return view('tenant.reservations.create', [
            'boardingHouse' => $boarding_house,
            'room' => $room,
        ]);
    }

    public function store(Request $request, BoardingHouse $boarding_house, Room $room): RedirectResponse
    {
        if ($room->boarding_house_id !== $boarding_house->id) {
            abort(404);
        }

        if ($this->tenantHasActiveStay($request->user()->id)) {
            return back()->withInput()->with('error', __('You already have an active stay at a boarding house. Please complete your current stay before making a new reservation.'));
        }

        $validated = $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
        ]);

        if ($room->status !== RoomStatus::Available || ! $room->hasAvailableCapacity()) {
            return back()->withInput()->with('error', __('This room is at full capacity.'));
        }

        Reservation::create([
            'tenant_id' => $request->user()->id,
            'room_id' => $room->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => ReservationStatus::Pending,
        ]);

        return redirect()
            ->route('tenant.reservations.index')
            ->with('status', __('Reservation request submitted.'));
    }

    private function tenantHasActiveStay(int $tenantId): bool
    {
        return Reservation::where('tenant_id', $tenantId)
            ->whereIn('status', [ReservationStatus::Active, ReservationStatus::Approved])
            ->exists();
    }
}
