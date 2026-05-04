<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantReservationManagementController extends Controller
{
    public function index(Request $request): View
    {
        $reservations = Reservation::query()
            ->where('tenant_id', $request->user()->id)
            ->with(['room.boardingHouse'])
            ->latest()
            ->paginate(15);

        return view('tenant.reservations.index', [
            'reservations' => $reservations,
        ]);
    }

    public function show(Request $request, Reservation $reservation): View
    {
        $this->authorizeTenant($request, $reservation);

        $reservation->load(['room.boardingHouse']);

        return view('tenant.reservations.show', [
            'reservation' => $reservation,
        ]);
    }

    public function edit(Request $request, Reservation $reservation): View|RedirectResponse
    {
        $this->authorizeTenant($request, $reservation);

        if ($reservation->status !== ReservationStatus::Pending) {
            return redirect()
                ->route('tenant.reservations.show', $reservation)
                ->with('error', __('Only pending reservations can be edited.'));
        }

        $reservation->load(['room.boardingHouse']);

        return view('tenant.reservations.edit', [
            'reservation' => $reservation,
        ]);
    }

    public function update(Request $request, Reservation $reservation): RedirectResponse
    {
        $this->authorizeTenant($request, $reservation);

        if ($reservation->status !== ReservationStatus::Pending) {
            return redirect()
                ->route('tenant.reservations.show', $reservation)
                ->with('error', __('Only pending reservations can be edited.'));
        }

        $validated = $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
        ]);

        $reservation->update([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return redirect()
            ->route('tenant.reservations.show', $reservation)
            ->with('status', __('Reservation updated.'));
    }

    public function cancel(Request $request, Reservation $reservation): RedirectResponse
    {
        $this->authorizeTenant($request, $reservation);

        if ($reservation->status !== ReservationStatus::Pending) {
            return redirect()
                ->route('tenant.reservations.show', $reservation)
                ->with('error', __('Only pending reservations can be cancelled.'));
        }

        $reservation->update(['status' => ReservationStatus::Cancelled]);
        $reservation->room->syncOccupantCountFromReservations();

        return redirect()
            ->route('tenant.reservations.index')
            ->with('status', __('Reservation cancelled.'));
    }

    private function authorizeTenant(Request $request, Reservation $reservation): void
    {
        abort_unless((int) $reservation->tenant_id === (int) $request->user()->id, 403);
    }
}
