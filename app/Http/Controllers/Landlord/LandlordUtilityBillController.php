<?php

namespace App\Http\Controllers\Landlord;

use App\Enums\ReservationStatus;
use App\Enums\UtilityBillStatus;
use App\Enums\UtilityBillType;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Models\UtilityBill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LandlordUtilityBillController extends Controller
{
    public function index(Request $request): View
    {
        $landlordId = $request->user()->id;

        $bills = UtilityBill::query()
            ->with(['tenant', 'room.boardingHouse'])
            ->whereHas('room.boardingHouse', fn ($q) => $q->where('landlord_id', $landlordId))
            ->latest('due_date')
            ->paginate(15);

        return view('landlord.bills.index', ['bills' => $bills]);
    }

    public function create(Request $request): View
    {
        $landlordId = $request->user()->id;

        $tenantOptions = Reservation::query()
            ->with(['tenant', 'room.boardingHouse'])
            ->whereHas('room.boardingHouse', fn ($q) => $q->where('landlord_id', $landlordId))
            ->whereIn('status', [ReservationStatus::Approved, ReservationStatus::Active])
            ->get()
            ->unique('tenant_id');

        $rooms = Room::query()
            ->with('boardingHouse')
            ->whereHas('boardingHouse', fn ($q) => $q->where('landlord_id', $landlordId))
            ->orderBy('boarding_house_id')
            ->orderBy('room_number')
            ->get();

        return view('landlord.bills.create', [
            'tenantOptions' => $tenantOptions,
            'rooms' => $rooms,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $landlordId = $request->user()->id;

        $validated = $request->validate([
            'tenant_id' => ['required', 'integer', 'exists:users,id'],
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'bill_type' => ['required', Rule::enum(UtilityBillType::class)],
            'amount' => ['required', 'numeric', 'min:0'],
            'billing_month' => ['required', 'date'],
            'due_date' => ['required', 'date'],
        ]);

        $room = Room::query()
            ->whereKey($validated['room_id'])
            ->whereHas('boardingHouse', fn ($q) => $q->where('landlord_id', $landlordId))
            ->firstOrFail();

        $tenant = User::query()->whereKey($validated['tenant_id'])->firstOrFail();

        $hasStay = Reservation::query()
            ->where('tenant_id', $tenant->id)
            ->where('room_id', $room->id)
            ->whereIn('status', [ReservationStatus::Approved, ReservationStatus::Active])
            ->exists();

        if (! $hasStay) {
            return back()->withInput()->with('error', __('Selected tenant is not assigned to that room.'));
        }

        UtilityBill::create([
            'tenant_id' => $validated['tenant_id'],
            'room_id' => $validated['room_id'],
            'bill_type' => $validated['bill_type'],
            'amount' => $validated['amount'],
            'billing_month' => $validated['billing_month'],
            'due_date' => $validated['due_date'],
            'status' => UtilityBillStatus::Unpaid,
        ]);

        return redirect()->route('landlord.bills.index')->with('status', __('Bill notice created.'));
    }

    public function markPaid(Request $request, UtilityBill $utility_bill): RedirectResponse
    {
        $landlordId = $request->user()->id;

        $utility_bill->load('room.boardingHouse');
        if ((int) $utility_bill->room->boardingHouse->landlord_id !== (int) $landlordId) {
            abort(403);
        }

        $utility_bill->update(['status' => UtilityBillStatus::Paid]);

        return back()->with('status', __('Bill marked as paid.'));
    }
}
