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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

class LandlordRoomController extends Controller
{
    public function index(Request $request, BoardingHouse $boarding_house): View
    {
        $this->authorizeLandlord($request, $boarding_house);

        $boarding_house->load([
            'rooms' => fn ($q) => $q->with(['photos', 'amenities'])->orderBy('room_number'),
        ]);

        return view('landlord.rooms.index', ['boardingHouse' => $boarding_house]);
    }

    public function create(Request $request, BoardingHouse $boarding_house): View
    {
        $this->authorizeLandlord($request, $boarding_house);

        return view('landlord.rooms.create', [
            'boardingHouse' => $boarding_house,
            'amenities' => Amenity::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request, BoardingHouse $boarding_house): RedirectResponse
    {
        $this->authorizeLandlord($request, $boarding_house);

        $validated = $request->validate([
            'room_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms')->where(fn ($q) => $q->where('boarding_house_id', $boarding_house->id)),
            ],
            'capacity' => ['required', 'integer', 'min:1', 'max:50'],
            'current_occupants' => ['required', 'integer', 'min:0'],
            'monthly_rate' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::enum(RoomStatus::class)],
            'amenity_ids' => ['nullable', 'array'],
            'amenity_ids.*' => ['integer', 'exists:amenities,id'],
            'new_amenities' => ['nullable', 'string', 'max:2000'],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['nullable', File::image()->max(4096)],
        ]);

        if ($validated['current_occupants'] > $validated['capacity']) {
            return back()->withInput()->with('error', __('Occupants cannot exceed capacity.'));
        }

        $room = Room::create([
            'boarding_house_id' => $boarding_house->id,
            'room_number' => $validated['room_number'],
            'capacity' => $validated['capacity'],
            'current_occupants' => $validated['current_occupants'],
            'monthly_rate' => $validated['monthly_rate'],
            'status' => $validated['status'],
        ]);

        $roomAmenityIds = $this->mergeAmenityIds(
            $validated['amenity_ids'] ?? [],
            $validated['new_amenities'] ?? null,
        );
        $room->amenities()->sync($roomAmenityIds);

        $this->storeRoomPhotos($room, $request->file('photos', []));
        $room->photo_path = $room->photos()->orderBy('sort_order')->value('path');
        $room->save();

        return redirect()->route('landlord.boarding-houses.rooms.index', $boarding_house)->with('status', __('Room added.'));
    }

    public function edit(Request $request, BoardingHouse $boarding_house, Room $room): View
    {
        $this->authorizeLandlord($request, $boarding_house, $room);

        return view('landlord.rooms.edit', [
            'boardingHouse' => $boarding_house,
            'room' => $room->load('amenities', 'photos'),
            'amenities' => Amenity::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, BoardingHouse $boarding_house, Room $room): RedirectResponse
    {
        $this->authorizeLandlord($request, $boarding_house, $room);

        $validated = $request->validate([
            'room_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms')
                    ->where(fn ($q) => $q->where('boarding_house_id', $boarding_house->id))
                    ->ignore($room->id),
            ],
            'capacity' => ['required', 'integer', 'min:1', 'max:50'],
            'current_occupants' => ['required', 'integer', 'min:0'],
            'monthly_rate' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::enum(RoomStatus::class)],
            'amenity_ids' => ['nullable', 'array'],
            'amenity_ids.*' => ['integer', 'exists:amenities,id'],
            'new_amenities' => ['nullable', 'string', 'max:2000'],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['nullable', File::image()->max(4096)],
            'remove_photo_ids' => ['nullable', 'array'],
            'remove_photo_ids.*' => ['integer'],
            'remove_photo' => ['nullable', 'boolean'],
        ]);

        if ($validated['current_occupants'] > $validated['capacity']) {
            return back()->withInput()->with('error', __('Occupants cannot exceed capacity.'));
        }

        $room->update([
            'room_number' => $validated['room_number'],
            'capacity' => $validated['capacity'],
            'current_occupants' => $validated['current_occupants'],
            'monthly_rate' => $validated['monthly_rate'],
            'status' => $validated['status'],
        ]);

        if ($request->boolean('remove_photo')) {
            if ($room->photo_path) {
                Storage::disk('public')->delete($room->photo_path);
            }
            $room->photo_path = null;
            $room->save();
        }

        $removePhotoIds = array_map('intval', $validated['remove_photo_ids'] ?? []);
        if ($removePhotoIds !== []) {
            $photosToRemove = $room->photos()->whereIn('id', $removePhotoIds)->get();
            foreach ($photosToRemove as $photo) {
                Storage::disk('public')->delete($photo->path);
                $photo->delete();
            }
        }

        $this->storeRoomPhotos($room, $request->file('photos', []));

        $roomAmenityIds = $this->mergeAmenityIds(
            $validated['amenity_ids'] ?? [],
            $validated['new_amenities'] ?? null,
        );
        $room->amenities()->sync($roomAmenityIds);

        return redirect()->route('landlord.boarding-houses.rooms.index', $boarding_house)->with('status', __('Room updated.'));
    }

    public function destroy(Request $request, BoardingHouse $boarding_house, Room $room): RedirectResponse
    {
        $this->authorizeLandlord($request, $boarding_house, $room);

        foreach ($room->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }

        if ($room->photo_path) {
            Storage::disk('public')->delete($room->photo_path);
        }

        $room->delete();

        return redirect()->route('landlord.boarding-houses.rooms.index', $boarding_house)->with('status', __('Room removed.'));
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

    private function authorizeLandlord(Request $request, BoardingHouse $boarding_house, ?Room $room = null): void
    {
        if ((int) $boarding_house->landlord_id !== (int) $request->user()->id) {
            abort(403);
        }

        if ($room !== null && (int) $room->boarding_house_id !== (int) $boarding_house->id) {
            abort(404);
        }
    }
}
