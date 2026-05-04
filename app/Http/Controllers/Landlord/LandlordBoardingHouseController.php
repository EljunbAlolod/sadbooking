<?php

namespace App\Http\Controllers\Landlord;

use App\Enums\RoomStatus;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\BoardingHouse;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

class LandlordBoardingHouseController extends Controller
{
    public function index(Request $request): View
    {
        $houses = BoardingHouse::query()
            ->where('landlord_id', $request->user()->id)
            ->withCount('rooms')
            ->with(['amenities', 'photos'])
            ->latest()
            ->get();

        return view('landlord.boarding-houses.index', ['boardingHouses' => $houses]);
    }

    public function create(): View
    {
        return view('landlord.boarding-houses.create', [
            'amenities' => Amenity::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'street' => ['nullable', 'string', 'max:500'],
            'barangay' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['nullable', File::image()->max(4096)],
            'amenity_ids' => ['nullable', 'array'],
            'amenity_ids.*' => ['integer', 'exists:amenities,id'],
            'new_amenities' => ['nullable', 'string', 'max:2000'],
            'room_number' => ['required', 'string', 'max:50'],
            'monthly_rate' => ['required', 'numeric', 'min:0'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:50'],
            'room_amenity_ids' => ['nullable', 'array'],
            'room_amenity_ids.*' => ['integer', 'exists:amenities,id'],
            'room_new_amenities' => ['nullable', 'string', 'max:2000'],
            'room_photos' => ['nullable', 'array', 'max:10'],
            'room_photos.*' => ['nullable', File::image()->max(4096)],
        ]);

        $capacity = $validated['capacity'] ?? 1;

        DB::transaction(function () use ($request, $validated, $capacity): void {
            $house = BoardingHouse::create([
                'landlord_id' => $request->user()->id,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'street' => $validated['street'] ?? null,
                'barangay' => $validated['barangay'] ?? null,
                'city' => $validated['city'],
                'province' => $validated['province'],
            ]);

            $houseAmenityIds = $this->mergeAmenityIds(
                $validated['amenity_ids'] ?? [],
                $validated['new_amenities'] ?? null,
            );
            $house->amenities()->sync($houseAmenityIds);

            $this->storeBoardingHousePhotos($house, $request->file('photos', []));
            $house->saveQuietly();

            $room = Room::create([
                'boarding_house_id' => $house->id,
                'room_number' => $validated['room_number'],
                'capacity' => $capacity,
                'current_occupants' => 0,
                'monthly_rate' => $validated['monthly_rate'],
                'status' => RoomStatus::Available,
            ]);

            $roomAmenityIds = $this->mergeAmenityIds(
                $validated['room_amenity_ids'] ?? [],
                $validated['room_new_amenities'] ?? null,
            );
            $room->amenities()->sync($roomAmenityIds);

            $this->storeRoomPhotos($room, $request->file('room_photos', []));
        });

        return redirect()->route('landlord.boarding-houses.index')->with('status', __('Boarding house created.'));
    }

    public function show(Request $request, BoardingHouse $boarding_house): View
    {
        $this->authorizeLandlord($request, $boarding_house);

        $boarding_house->load([
            'amenities',
            'photos',
            'rooms.amenities',
            'rooms.photos',
        ]);

        return view('landlord.boarding-houses.show', ['boardingHouse' => $boarding_house]);
    }

    public function edit(Request $request, BoardingHouse $boarding_house): View
    {
        $this->authorizeLandlord($request, $boarding_house);

        return view('landlord.boarding-houses.edit', [
            'boardingHouse' => $boarding_house->load('amenities', 'photos'),
            'amenities' => Amenity::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, BoardingHouse $boarding_house): RedirectResponse
    {
        $this->authorizeLandlord($request, $boarding_house);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'street' => ['nullable', 'string', 'max:500'],
            'barangay' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['nullable', File::image()->max(4096)],
            'remove_photo_ids' => ['nullable', 'array'],
            'remove_photo_ids.*' => ['integer'],
            'remove_photo' => ['nullable', 'boolean'],
            'amenity_ids' => ['nullable', 'array'],
            'amenity_ids.*' => ['integer', 'exists:amenities,id'],
            'new_amenities' => ['nullable', 'string', 'max:2000'],
        ]);

        $boarding_house->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'street' => $validated['street'] ?? null,
            'barangay' => $validated['barangay'] ?? null,
            'city' => $validated['city'],
            'province' => $validated['province'],
        ]);

        if ($request->boolean('remove_photo')) {
            $this->deleteStoredPhoto($boarding_house);
            $boarding_house->photo_path = null;
        }

        $removePhotoIds = array_map('intval', $validated['remove_photo_ids'] ?? []);
        if ($removePhotoIds !== []) {
            $photosToRemove = $boarding_house->photos()->whereIn('id', $removePhotoIds)->get();
            foreach ($photosToRemove as $photo) {
                Storage::disk('public')->delete($photo->path);
                $photo->delete();
            }
        }

        $this->storeBoardingHousePhotos($boarding_house, $request->file('photos', []));

        $houseAmenityIds = $this->mergeAmenityIds(
            $validated['amenity_ids'] ?? [],
            $validated['new_amenities'] ?? null,
        );
        $boarding_house->amenities()->sync($houseAmenityIds);

        $boarding_house->photo_path = $boarding_house->photos()->orderBy('sort_order')->value('path');
        $boarding_house->save();

        return redirect()->route('landlord.boarding-houses.show', $boarding_house)->with('status', __('Boarding house updated.'));
    }

    public function destroy(Request $request, BoardingHouse $boarding_house): RedirectResponse
    {
        $this->authorizeLandlord($request, $boarding_house);

        $boarding_house->load('photos');

        $this->deleteStoredPhoto($boarding_house);

        foreach ($boarding_house->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }

        $boarding_house->delete();

        return redirect()->route('landlord.boarding-houses.index')->with('status', __('Boarding house removed.'));
    }

    /**
     * @param  array<int, int|string>  $amenityIds
     * @return array<int, int>
     */
    private function mergeAmenityIds(array $amenityIds, ?string $newAmenitiesInput): array
    {
        $merged = array_map('intval', $amenityIds);

        if ($newAmenitiesInput !== null && trim($newAmenitiesInput) !== '') {
            $parts = preg_split('/[\r\n,]+/', $newAmenitiesInput) ?: [];
            foreach ($parts as $rawName) {
                $name = trim($rawName);
                if ($name === '') {
                    continue;
                }

                $amenity = Amenity::query()->firstOrCreate(['name' => $name]);
                $merged[] = $amenity->id;
            }
        }

        return array_values(array_unique($merged));
    }

    /**
     * @param  array<int, UploadedFile|null>  $photos
     */
    private function storeBoardingHousePhotos(BoardingHouse $boardingHouse, array $photos): void
    {
        $order = (int) $boardingHouse->photos()->max('sort_order');

        foreach ($photos as $photo) {
            if (! $photo instanceof UploadedFile) {
                continue;
            }

            $path = $photo->store('boarding-houses', 'public');
            $order++;

            $created = $boardingHouse->photos()->create([
                'path' => $path,
                'sort_order' => $order,
            ]);

            if (! $boardingHouse->photo_path) {
                $boardingHouse->photo_path = $created->path;
            }
        }
    }

    /**
     * @param  array<int, UploadedFile|null>  $photos
     */
    private function storeRoomPhotos(Room $room, array $photos): void
    {
        $order = (int) $room->photos()->max('sort_order');

        foreach ($photos as $photo) {
            if (! $photo instanceof UploadedFile) {
                continue;
            }

            $path = $photo->store('rooms', 'public');
            $order++;

            $created = $room->photos()->create([
                'path' => $path,
                'sort_order' => $order,
            ]);

            if (! $room->photo_path) {
                $room->photo_path = $created->path;
                $room->saveQuietly();
            }
        }
    }

    private function deleteStoredPhoto(BoardingHouse $boarding_house): void
    {
        if ($boarding_house->photo_path) {
            Storage::disk('public')->delete($boarding_house->photo_path);
        }
    }

    private function authorizeLandlord(Request $request, BoardingHouse $boarding_house): void
    {
        if ((int) $boarding_house->landlord_id !== (int) $request->user()->id) {
            abort(403);
        }
    }
}
