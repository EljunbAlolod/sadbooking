<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Models\Amenity;
use App\Models\BoardingHouse;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicBoardingHouseController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'location' => ['nullable', 'string', 'max:255'],
            'budget_range' => ['nullable', 'string'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['integer', 'exists:amenities,id'],
        ]);

        $boardingHouses = BoardingHouse::query()
            ->with(['landlord', 'amenities', 'photos', 'rooms.photos'])
            ->when($validated['location'] ?? null, function ($query, string $location): void {
                $searchTerm = '%'.trim($location).'%';
                $query->where(function ($q) use ($searchTerm): void {
                    $q->where('street', 'like', $searchTerm)
                        ->orWhere('barangay', 'like', $searchTerm)
                        ->orWhere('city', 'like', $searchTerm)
                        ->orWhere('province', 'like', $searchTerm);
                });
            })
            ->when($validated['budget_range'] ?? null, function ($query, string $budgetRange): void {
                if ($budgetRange === '5001+') {
                    $min = 5001;
                    $max = 999999;
                } else {
                    $parts = explode('-', $budgetRange);
                    if (count($parts) === 2) {
                        $min = (int) $parts[0];
                        $max = (int) $parts[1];
                    } else {
                        return;
                    }
                }

                $query->whereHas('rooms', function ($q) use ($min, $max) {
                    $q->whereBetween('monthly_rate', [$min, $max]);
                });
            })
            ->when(! empty($validated['amenities'] ?? []), function ($query) use ($validated): void {
                foreach ($validated['amenities'] as $amenityId) {
                    $query->whereHas('amenities', fn ($q) => $q->where('amenities.id', $amenityId));
                }
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $boardingAmenities = Amenity::whereHas('boardingHouses')
            ->orderBy('name')
            ->get();

        return view('boarding-houses.public.index', [
            'boardingHouses' => $boardingHouses,
            'allAmenities' => $boardingAmenities,
            'filters' => $validated,
        ]);
    }

    public function show(BoardingHouse $boarding_house): View
    {
        $boarding_house->load([
            'amenities',
            'photos',
            'rooms.amenities',
            'rooms.photos',
            'rooms.boardingHouse',
        ]);

        $tenantHasActiveStay = false;

        if (auth()->check() && auth()->user()->isTenant()) {
            $tenantHasActiveStay = Reservation::where('tenant_id', auth()->id())
                ->whereIn('status', [ReservationStatus::Active, ReservationStatus::Approved])
                ->exists();
        }

        return view('boarding-houses.public.show', [
            'boardingHouse' => $boarding_house,
            'tenantHasActiveStay' => $tenantHasActiveStay,
        ]);
    }
}
