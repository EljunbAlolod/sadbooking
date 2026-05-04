<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add room') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('landlord.boarding-houses.rooms.store', $boardingHouse) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="room_number" :value="__('Room number')" />
                        <x-text-input id="room_number" name="room_number" class="block mt-1 w-full" :value="old('room_number')" required />
                        <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="capacity" :value="__('Capacity')" />
                        <x-text-input id="capacity" name="capacity" type="number" min="1" class="block mt-1 w-full" :value="old('capacity', 1)" required />
                        <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="current_occupants" :value="__('Current occupants')" />
                        <x-text-input id="current_occupants" name="current_occupants" type="number" min="0" class="block mt-1 w-full" :value="old('current_occupants', 0)" required />
                        <x-input-error :messages="$errors->get('current_occupants')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="monthly_rate" :value="__('Monthly rate')" />
                        <x-text-input id="monthly_rate" name="monthly_rate" type="number" step="0.01" min="0" class="block mt-1 w-full" :value="old('monthly_rate')" required />
                        <x-input-error :messages="$errors->get('monthly_rate')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach (\App\Enums\RoomStatus::cases() as $status)
                                <option value="{{ $status->value }}" @selected(old('status', \App\Enums\RoomStatus::Available->value) === $status->value)>{{ $status->value }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-slate-500">{{ __('Status auto-switches to full when occupants hit capacity.') }}</p>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label :value="__('Room amenities')" />
                        <div class="mt-2 grid gap-2 sm:grid-cols-2">
                            @foreach ($amenities as $amenity)
                                <label class="inline-flex items-center gap-2 rounded-lg border border-slate-100 bg-slate-50/80 px-3 py-2 text-sm hover:border-slate-200">
                                    <input type="checkbox" name="amenity_ids[]" value="{{ $amenity->id }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(in_array($amenity->id, old('amenity_ids', []), true))>
                                    <span>{{ $amenity->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <x-input-label for="new_amenities" :value="__('Add new room amenities')" />
                        <textarea id="new_amenities" name="new_amenities" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('new_amenities') }}</textarea>
                    </div>
                    <div>
                        <x-input-label for="photos" :value="__('Room pictures (multiple)')" />
                        <input id="photos" name="photos[]" type="file" accept="image/*" multiple class="mt-1 block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                        <x-input-error :messages="\Illuminate\Support\Arr::flatten($errors->get('photos.*'))" class="mt-2" />
                    </div>
                    <div class="flex gap-2">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                        <a href="{{ route('landlord.boarding-houses.rooms.index', $boardingHouse) }}" class="px-4 py-2 text-sm text-gray-700">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
