<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\BoardingHouse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicBoardingHouseController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'location' => ['nullable', 'string', 'max:255'],
            'max_rate' => ['nullable', 'numeric', 'min:0'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['integer', 'exists:amenities,id'],
        ]);

        $boardingHouses = BoardingHouse::query()
            ->with(['landlord', 'amenities', 'photos', 'rooms.photos'])
            ->when($validated['location'] ?? null, function ($query, string $location): void {
                $query->where('address', 'like', '%'.$location.'%');
            })
            ->when($validated['max_rate'] ?? null, function ($query, string|float $maxRate): void {
                $query->whereHas('rooms', fn ($q) => $q->where('monthly_rate', '<=', $maxRate));
            })
            ->when(! empty($validated['amenities'] ?? []), function ($query) use ($validated): void {
                $ids = $validated['amenities'];
                foreach ($ids as $amenityId) {
                    $query->whereHas('amenities', fn ($q) => $q->where('amenities.id', $amenityId));
                }
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('boarding-houses.public.index', [
            'boardingHouses' => $boardingHouses,
            'allAmenities' => Amenity::orderBy('name')->get(),
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

        return view('boarding-houses.public.show', [
            'boardingHouse' => $boarding_house,
        ]);
    }
}
