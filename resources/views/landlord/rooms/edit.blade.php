<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-pink-600">{{ $boardingHouse->title }}</p>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">{{ __('Edit Room') }} {{ $room->room_number }}</h2>
            </div>
            <a href="{{ route('landlord.boarding-houses.show', $boardingHouse) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-pink-600 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                {{ __('Back to listing') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-3xl border border-slate-200/80 p-6 sm:p-10">
                <form method="POST" action="{{ route('landlord.boarding-houses.rooms.update', [$boardingHouse, $room]) }}" enctype="multipart/form-data" 
                    x-data="{ 
                        newPhotos: [], 
                        customAmenities: @js(old('new_amenities') ? explode(',', old('new_amenities')) : []),
                        newAmenityInput: '',
                        addAmenity() {
                            if (this.newAmenityInput.trim() !== '') {
                                this.customAmenities.push(this.newAmenityInput.trim());
                                this.newAmenityInput = '';
                            }
                        },
                        removeAmenity(index) {
                            this.customAmenities.splice(index, 1);
                        },
                        handleFileSelect(event) {
                            const files = Array.from(event.target.files);
                            files.forEach(file => {
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    this.newPhotos.push(e.target.result);
                                };
                                reader.readAsDataURL(file);
                            });
                        }
                    }" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('Room Information') }}</h3>
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <x-input-label for="room_number" :value="__('Room Number or Name')" />
                                <x-text-input id="room_number" name="room_number" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('room_number', $room->room_number)" required />
                                <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="capacity" :value="__('Total Capacity')" />
                                <x-text-input id="capacity" name="capacity" type="number" min="1" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('capacity', $room->capacity)" required />
                                <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="current_occupants" :value="__('Current Occupants')" />
                                <x-text-input id="current_occupants" name="current_occupants" type="number" min="0" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('current_occupants', $room->current_occupants)" required />
                                <x-input-error :messages="$errors->get('current_occupants')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="monthly_rate" :value="__('Monthly Rate (PHP)')" />
                                <x-text-input id="monthly_rate" name="monthly_rate" type="number" step="0.01" min="0" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('monthly_rate', $room->monthly_rate)" required />
                                <x-input-error :messages="$errors->get('monthly_rate')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm">
                                    @foreach (\App\Enums\RoomStatus::cases() as $status)
                                        <option value="{{ $status->value }}" @selected(old('status', $room->status->value) === $status->value)>{{ ucfirst($status->value) }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2 pt-4">
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('Media Management') }}</h3>
                        </div>

                        @if ($room->photos->isNotEmpty())
                            <div class="space-y-4">
                                <x-input-label :value="__('Current Photos (Select to remove)')" />
                                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                                    @foreach ($room->photos as $photo)
                                        <label class="group relative aspect-square overflow-hidden rounded-2xl border border-slate-200 cursor-pointer shadow-sm">
                                            <img src="{{ $photo->url() }}" alt="" class="h-full w-full object-cover transition-transform group-hover:scale-110">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <input type="checkbox" name="remove_photo_ids[]" value="{{ $photo->id }}" class="h-6 w-6 rounded border-slate-300 text-red-600 focus:ring-red-500">
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="space-y-4">
                            <x-input-label for="photos" :value="__('Add New Photos')" />
                            <div class="flex items-center justify-center w-full">
                                <label for="photos" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="mb-2 text-sm text-slate-500 font-semibold">{{ __('Click to upload') }}</p>
                                    </div>
                                    <input id="photos" name="photos[]" type="file" accept="image/*" multiple class="hidden" @change="handleFileSelect($event)" />
                                </label>
                            </div>
                            
                            <!-- New Preview Grid -->
                            <div x-show="newPhotos.length > 0" class="grid grid-cols-2 gap-4 sm:grid-cols-4 mt-4">
                                <template x-for="(photo, index) in newPhotos" :key="index">
                                    <div class="relative group aspect-square rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                                        <img :src="photo" class="h-full w-full object-cover">
                                        <button type="button" @click="newPhotos.splice(index, 1)" class="absolute top-2 right-2 rounded-full bg-red-500 p-1 text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L12 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                        </div>

                        @if ($room->photo_path)
                            <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700 cursor-pointer hover:bg-slate-100 transition-colors">
                                <input type="checkbox" name="remove_photo" value="1" class="h-5 w-5 rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                                <div class="flex flex-col">
                                    <span class="font-bold">{{ __('Remove legacy primary photo') }}</span>
                                </div>
                            </label>
                        @endif

                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2 pt-4">
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('Amenities') }}</h3>
                        </div>

                        <div>
                            <x-input-label :value="__('Select Room Amenities')" />
                            @php $selectedAmenities = old('amenity_ids', $room->amenities->pluck('id')->all()); @endphp
                            <div class="mt-2 grid gap-3 sm:grid-cols-2">
                                @foreach ($amenities as $amenity)
                                    <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-3 shadow-sm hover:border-pink-200 transition-all">
                                        <input type="checkbox" name="amenity_ids[]" value="{{ $amenity->id }}" class="sr-only peer" @checked(in_array($amenity->id, $selectedAmenities, true))>
                                        <div class="flex w-full items-center justify-between peer-checked:text-pink-600">
                                            <span class="text-sm font-medium">{{ $amenity->name }}</span>
                                            <svg class="h-5 w-5 opacity-0 peer-checked:opacity-100 transition-opacity text-pink-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                        </div>
                                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-pink-600 pointer-events-none"></div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <x-input-label for="new_amenity_field" :value="__('Add Custom Amenities')" />
                            <div class="mt-1 flex gap-2">
                                <x-text-input id="new_amenity_field" x-model="newAmenityInput" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="{{ __('e.g. Memory foam mattress') }}" @keydown.enter.prevent="addAmenity()" />
                                <button type="button" @click="addAmenity()" class="inline-flex items-center rounded-xl bg-pink-50 px-4 py-2 text-sm font-bold text-pink-600 hover:bg-pink-100 transition-all active:scale-95">
                                    {{ __('Add') }}
                                </button>
                            </div>
                            
                            <div class="mt-3 flex flex-wrap gap-2">
                                <template x-for="(amenity, index) in customAmenities" :key="index">
                                    <div class="inline-flex items-center gap-1.5 rounded-lg bg-pink-50 px-3 py-1.5 text-xs font-bold text-pink-700 border border-pink-100">
                                        <span x-text="amenity"></span>
                                        <button type="button" @click="removeAmenity(index)" class="text-pink-400 hover:text-pink-600">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L12 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            
                            <input type="hidden" name="new_amenities" :value="customAmenities.join(',')">
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-4 border-t border-slate-100 pt-8">
                        <a href="{{ route('landlord.boarding-houses.show', $boardingHouse) }}" class="inline-flex items-center rounded-xl px-6 py-3 text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors">{{ __('Cancel') }}</a>
                        <x-primary-button class="rounded-2xl px-8 py-3 bg-pink-600 hover:bg-pink-700 shadow-lg shadow-pink-200 transition-all active:scale-95">
                            {{ __('Update Room') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
