<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-pink-600">{{ __('Boarding house') }}</p>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Add a new listing') }}</h2>
            <p class="mt-1 text-sm text-slate-600">{{ __('Name, location, photos, amenities, and your first room in one step.') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                <form method="POST" action="{{ route('landlord.boarding-houses.store') }}" enctype="multipart/form-data" 
                    x-data="{ 
                        bhPhotos: [], 
                        roomPhotos: [],
                        customAmenities: @js(old('new_amenities') ? explode(',', old('new_amenities')) : []),
                        roomCustomAmenities: @js(old('room_new_amenities') ? explode(',', old('room_new_amenities')) : []),
                        newAmenityInput: '',
                        roomNewAmenityInput: '',
                        addAmenity(type) {
                            const input = type === 'bh' ? this.newAmenityInput : this.roomNewAmenityInput;
                            const list = type === 'bh' ? this.customAmenities : this.roomCustomAmenities;
                            if (input.trim() !== '') {
                                list.push(input.trim());
                                if (type === 'bh') this.newAmenityInput = '';
                                else this.roomNewAmenityInput = '';
                            }
                        },
                        removeAmenity(type, index) {
                            const list = type === 'bh' ? this.customAmenities : this.roomCustomAmenities;
                            list.splice(index, 1);
                        },
                        handleFileSelect(event, type) {
                            const files = Array.from(event.target.files);
                            files.forEach(file => {
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    if(type === 'bh') this.bhPhotos.push(e.target.result);
                                    else this.roomPhotos.push(e.target.result);
                                };
                                reader.readAsDataURL(file);
                            });
                        }
                    }" class="space-y-8">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('Basic Information') }}</h3>
                        </div>

                        <div>
                            <x-input-label for="title" :value="__('Listing Title')" />
                            <x-text-input id="title" name="title" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('title')" required autofocus placeholder="{{ __('e.g. Sunny Male Dormitory') }}" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="{{ __('Tell potential tenants about your boarding house...') }}">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2 pt-4">
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('Location Details') }}</h3>
                        </div>

                        <div>
                            <x-input-label for="province" :value="__('Province')" />
                            <x-text-input id="province" name="province" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('province')" required autocomplete="off" placeholder="{{ __('Start typing to search...') }}" />
                            <x-input-error :messages="$errors->get('province')" class="mt-2" />
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <x-input-label for="city" :value="__('City / Municipality')" />
                                <x-text-input id="city" name="city" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('city')" required autocomplete="off" placeholder="{{ __('Start typing to search...') }}" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="barangay" :value="__('Barangay')" />
                                <x-text-input id="barangay" name="barangay" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('barangay')" autocomplete="off" placeholder="{{ __('Start typing to search...') }}" />
                                <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="street" :value="__('Street / Landmark (optional)')" />
                            <x-text-input id="street" name="street" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('street')" placeholder="{{ __('e.g. 123 Rizal St, near public market') }}" />
                            <x-input-error :messages="$errors->get('street')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2 pt-4">
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('Media') }}</h3>
                        </div>

                        <div class="space-y-4">
                            <x-input-label for="photos" :value="__('Boarding House Pictures')" />
                            <div class="flex items-center justify-center w-full">
                                <label for="photos" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="mb-2 text-sm text-slate-500 font-semibold">{{ __('Click to upload') }} {{ __('or drag and drop') }}</p>
                                        <p class="text-xs text-slate-400">PNG, JPG or WebP (MAX. 4MB)</p>
                                    </div>
                                    <input id="photos" name="photos[]" type="file" accept="image/*" multiple class="hidden" @change="handleFileSelect($event, 'bh')" />
                                </label>
                            </div>
                            
                            <!-- Preview Grid -->
                            <div x-show="bhPhotos.length > 0" class="grid grid-cols-2 gap-4 sm:grid-cols-4 mt-4">
                                <template x-for="(photo, index) in bhPhotos" :key="index">
                                    <div class="relative group aspect-square rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                                        <img :src="photo" class="h-full w-full object-cover">
                                        <button type="button" @click="bhPhotos.splice(index, 1)" class="absolute top-2 right-2 rounded-full bg-red-500 p-1 text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L12 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <p class="text-xs text-slate-500">{{ __('Upload up to 10 photos.') }}</p>
                            <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                            <x-input-error :messages="\Illuminate\Support\Arr::flatten($errors->get('photos.*'))" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2 pt-4">
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('Features & Amenities') }}</h3>
                        </div>

                        <div>
                            <x-input-label :value="__('Select Amenities')" />
                            <div class="mt-2 grid gap-3 sm:grid-cols-3">
                                @foreach ($amenities as $amenity)
                                    <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-3 shadow-sm hover:border-pink-200 transition-all">
                                        <input type="checkbox" name="amenity_ids[]" value="{{ $amenity->id }}" class="sr-only peer" @checked(in_array($amenity->id, old('amenity_ids', []), true))>
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
                                <x-text-input id="new_amenity_field" x-model="newAmenityInput" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="{{ __('e.g. Roof deck') }}" @keydown.enter.prevent="addAmenity('bh')" />
                                <button type="button" @click="addAmenity('bh')" class="inline-flex items-center rounded-xl bg-pink-50 px-4 py-2 text-sm font-bold text-pink-600 hover:bg-pink-100 transition-all active:scale-95">
                                    {{ __('Add') }}
                                </button>
                            </div>
                            
                            <!-- Selected Custom Amenities Chips -->
                            <div class="mt-3 flex flex-wrap gap-2">
                                <template x-for="(amenity, index) in customAmenities" :key="index">
                                    <div class="inline-flex items-center gap-1.5 rounded-lg bg-pink-50 px-3 py-1.5 text-xs font-bold text-pink-700 border border-pink-100">
                                        <span x-text="amenity"></span>
                                        <button type="button" @click="removeAmenity('bh', index)" class="text-pink-400 hover:text-pink-600">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L12 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            
                            <input type="hidden" name="new_amenities" :value="customAmenities.join(',')">
                            <x-input-error :messages="$errors->get('new_amenities')" class="mt-2" />
                        </div>
                    </div>

                    <div class="space-y-6 pt-8 border-t border-slate-100">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('First Room Configuration') }}</h3>
                        </div>
                        <p class="text-sm text-slate-600">{{ __('Every listing needs at least one room. You can add more later.') }}</p>
                        
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <x-input-label for="room_number" :value="__('Room Number/Name')" />
                                <x-text-input id="room_number" name="room_number" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('room_number')" required placeholder="e.g. Room 101 or Attic Room" />
                                <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="monthly_rate" :value="__('Monthly Rate (PHP)')" />
                                <x-text-input id="monthly_rate" name="monthly_rate" type="number" step="0.01" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('monthly_rate')" required placeholder="0.00" />
                                <x-input-error :messages="$errors->get('monthly_rate')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="capacity" :value="__('Total Capacity')" />
                                <x-text-input id="capacity" name="capacity" type="number" min="1" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('capacity', '1')" required placeholder="How many people?" />
                                <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label :value="__('Room Amenities')" />
                                <div class="mt-2 grid gap-3 sm:grid-cols-3">
                                    @foreach ($amenities as $amenity)
                                        <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-3 shadow-sm hover:border-pink-200 transition-all">
                                            <input type="checkbox" name="room_amenity_ids[]" value="{{ $amenity->id }}" class="sr-only peer" @checked(in_array($amenity->id, old('room_amenity_ids', []), true))>
                                            <div class="flex w-full items-center justify-between peer-checked:text-pink-600">
                                                <span class="text-sm font-medium">{{ $amenity->name }}</span>
                                                <svg class="h-5 w-5 opacity-0 peer-checked:opacity-100 transition-opacity text-pink-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                            </div>
                                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-pink-600 pointer-events-none"></div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="room_new_amenity_field" :value="__('Add Custom Room Amenities')" />
                                <div class="mt-1 flex gap-2">
                                    <x-text-input id="room_new_amenity_field" x-model="roomNewAmenityInput" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="{{ __('e.g. Memory foam mattress') }}" @keydown.enter.prevent="addAmenity('room')" />
                                    <button type="button" @click="addAmenity('room')" class="inline-flex items-center rounded-xl bg-pink-50 px-4 py-2 text-sm font-bold text-pink-600 hover:bg-pink-100 transition-all active:scale-95">
                                        {{ __('Add') }}
                                    </button>
                                </div>
                                
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <template x-for="(amenity, index) in roomCustomAmenities" :key="index">
                                        <div class="inline-flex items-center gap-1.5 rounded-lg bg-pink-50 px-3 py-1.5 text-xs font-bold text-pink-700 border border-pink-100">
                                            <span x-text="amenity"></span>
                                            <button type="button" @click="removeAmenity('room', index)" class="text-pink-400 hover:text-pink-600">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L12 6M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                
                                <input type="hidden" name="room_new_amenities" :value="roomCustomAmenities.join(',')">
                                <x-input-error :messages="$errors->get('room_new_amenities')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="room_photos" :value="__('Room Pictures')" />
                                <div class="flex items-center justify-center w-full">
                                    <label for="room_photos" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <p class="mb-2 text-sm text-slate-500 font-semibold">{{ __('Click to upload room photos') }}</p>
                                        </div>
                                        <input id="room_photos" name="room_photos[]" type="file" accept="image/*" multiple class="hidden" @change="handleFileSelect($event, 'room')" />
                                    </label>
                                </div>

                                <!-- Room Preview Grid -->
                                <div x-show="roomPhotos.length > 0" class="grid grid-cols-2 gap-4 sm:grid-cols-4 mt-4">
                                    <template x-for="(photo, index) in roomPhotos" :key="index">
                                        <div class="relative group aspect-square rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                                            <img :src="photo" class="h-full w-full object-cover">
                                            <button type="button" @click="roomPhotos.splice(index, 1)" class="absolute top-2 right-2 rounded-full bg-red-500 p-1 text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L12 6M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                <x-input-error :messages="$errors->get('room_photos')" class="mt-2" />
                                <x-input-error :messages="\Illuminate\Support\Arr::flatten($errors->get('room_photos.*'))" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-4 border-t border-slate-100 pt-8">
                        <a href="{{ route('landlord.boarding-houses.index') }}" class="inline-flex items-center rounded-xl px-6 py-3 text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors">{{ __('Cancel') }}</a>
                        <x-primary-button class="rounded-2xl px-8 py-3 bg-pink-600 hover:bg-pink-700 shadow-lg shadow-pink-200 transition-all active:scale-95">
                            {{ __('Publish Listing') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<style>
    .autocomplete-dropdown {
        position: absolute;
        z-index: 50;
        width: 100%;
        background-color: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        margin-top: 0.25rem;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        max-height: 15rem;
        overflow-y: auto;
        display: none;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .autocomplete-dropdown.active {
        display: block;
    }
    .autocomplete-item {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        color: #334155;
        cursor: pointer;
        list-style: none;
    }
    .autocomplete-item:hover {
        background-color: #eef2ff;
    }
    .autocomplete-wrapper {
        position: relative;
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fields = {
        province: document.getElementById('province'),
        city: document.getElementById('city'),
        barangay: document.getElementById('barangay'),
    };

    // Create dropdowns for each field
    const dropdowns = {};
    Object.entries(fields).forEach(([key, input]) => {
        if (!input) return;
        const wrapper = document.createElement('div');
        wrapper.className = 'autocomplete-wrapper';
        wrapper.style.position = 'relative';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);

        const dropdown = document.createElement('ul');
        dropdown.className = 'autocomplete-dropdown';
        wrapper.appendChild(dropdown);
        dropdowns[key] = dropdown;
    });

    let debounceTimers = {};

    function searchNominatim(query, type) {
        return new Promise((resolve, reject) => {
            if (!query || query.length < 2) return resolve([]);
            let searchQuery = query + ', Philippines';
            const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(searchQuery)}&format=json&addressdetails=1&countrycodes=ph&limit=8&email=sadbooking@example.com&accept-language=en`;
            
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(`Nominatim results for "${query}":`, data);
                    resolve(Array.isArray(data) ? data : []);
                },
                error: function(xhr, status, error) {
                    console.error('Nominatim AJAX search failed:', error);
                    resolve([]);
                }
            });
        });
    }

    function getComponent(address, keys) {
        if (!address) return '';
        for (const key of keys) {
            if (address[key]) return address[key];
        }
        return '';
    }

    function setupAutocomplete(fieldKey, inputEl, type) {
        if (!inputEl) return;
        const dropdown = dropdowns[fieldKey];

        inputEl.addEventListener('input', function () {
            clearTimeout(debounceTimers[fieldKey]);
            dropdown.classList.remove('active');
            dropdown.innerHTML = '';

            const val = this.value.trim();
            if (val.length < 2) return;

            debounceTimers[fieldKey] = setTimeout(async () => {
                const results = await searchNominatim(val, type);
                if (results.length === 0) {
                    console.warn('No results from Nominatim for:', val);
                    return;
                }

                dropdown.innerHTML = '';
                results.forEach(result => {
                    const li = document.createElement('li');
                    li.className = 'autocomplete-item';
                    li.textContent = result.display_name;
                    li.style.cursor = 'pointer';
                    li.addEventListener('click', () => {
                        const addr = result.address;
                        
                        // Fill the clicked input with the most relevant name part
                        let primaryName = result.name;
                        if (type === 'province') {
                            primaryName = getComponent(addr, ['state', 'region']) || result.name;
                        } else if (type === 'city') {
                            primaryName = getComponent(addr, ['city', 'town', 'municipality', 'county']) || result.name;
                        } else if (type === 'barangay') {
                            primaryName = getComponent(addr, ['suburb', 'village', 'quarter', 'neighbourhood', 'hamlet']) || result.name;
                        }
                        
                        inputEl.value = primaryName || result.display_name.split(',')[0];
                        dropdown.classList.remove('active');
                        inputEl.dispatchEvent(new Event('change', { bubbles: true }));

                        // Auto-fill other fields if possible
                        if (addr) {
                            const state = getComponent(addr, ['state', 'region']);
                            const city = getComponent(addr, ['city', 'town', 'municipality', 'county']);
                            
                            if (state && fields.province && !fields.province.value) {
                                fields.province.value = state;
                            }
                            if (city && fields.city && (!fields.city.value || type === 'barangay')) {
                                fields.city.value = city;
                            }
                        }

                        // Focus next logical field
                        if (type === 'province' && fields.city) fields.city.focus();
                        else if (type === 'city' && fields.barangay) fields.barangay.focus();
                    });
                    dropdown.appendChild(li);
                });
                dropdown.classList.add('active');
            }, 300);
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (inputEl && inputEl.parentNode && !inputEl.parentNode.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    }

    setupAutocomplete('province', fields.province, 'province');
    setupAutocomplete('city', fields.city, 'city');
    setupAutocomplete('barangay', fields.barangay, 'barangay');
});
</script>
@endpush
