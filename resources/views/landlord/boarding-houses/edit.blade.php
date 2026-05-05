<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-pink-600">{{ __('Boarding house') }}</p>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Edit listing') }}</h2>
            <p class="mt-1 text-sm text-slate-600">{{ $boardingHouse->title }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                <form method="POST" action="{{ route('landlord.boarding-houses.update', $boardingHouse) }}" enctype="multipart/form-data" 
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
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('Basic Information') }}</h3>
                        </div>

                        <div>
                            <x-input-label for="title" :value="__('Listing Title')" />
                            <x-text-input id="title" name="title" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('title', $boardingHouse->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500">{{ old('description', $boardingHouse->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2 pt-4">
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('Location Details') }}</h3>
                        </div>

                        <div>
                            <x-input-label for="province" :value="__('Province')" />
                            <x-text-input id="province" name="province" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('province', $boardingHouse->province)" required autocomplete="off" />
                            <x-input-error :messages="$errors->get('province')" class="mt-2" />
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <x-input-label for="city" :value="__('City / Municipality')" />
                                <x-text-input id="city" name="city" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('city', $boardingHouse->city)" required autocomplete="off" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="barangay" :value="__('Barangay')" />
                                <x-text-input id="barangay" name="barangay" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('barangay', $boardingHouse->barangay)" autocomplete="off" />
                                <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="street" :value="__('Street / Landmark (optional)')" />
                            <x-text-input id="street" name="street" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" :value="old('street', $boardingHouse->street)" />
                            <x-input-error :messages="$errors->get('street')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2 pt-4">
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('Media Management') }}</h3>
                        </div>

                        @if ($boardingHouse->photos->isNotEmpty())
                            <div class="space-y-4">
                                <x-input-label :value="__('Current Pictures (Select to remove)')" />
                                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                                    @foreach ($boardingHouse->photos as $photo)
                                        <label class="group relative aspect-square overflow-hidden rounded-2xl border border-slate-200 cursor-pointer shadow-sm">
                                            <img src="{{ $photo->url() }}" alt="" class="h-full w-full object-cover transition-transform group-hover:scale-110">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <input type="checkbox" name="remove_photo_ids[]" value="{{ $photo->id }}" class="h-6 w-6 rounded border-slate-300 text-red-600 focus:ring-red-500">
                                            </div>
                                            <div class="absolute bottom-2 left-2 right-2 flex justify-center">
                                                <span class="rounded-full bg-white/90 px-2 py-0.5 text-[10px] font-bold text-slate-700 shadow-sm">{{ __('Click to remove') }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="space-y-4">
                            <x-input-label for="photos" :value="__('Add New Pictures')" />
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

                        @if ($boardingHouse->photo_path)
                            <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700 cursor-pointer hover:bg-slate-100 transition-colors">
                                <input type="checkbox" name="remove_photo" value="1" class="h-5 w-5 rounded border-slate-300 text-pink-600 focus:ring-pink-500" @checked(old('remove_photo'))>
                                <div class="flex flex-col">
                                    <span class="font-bold">{{ __('Remove legacy primary photo') }}</span>
                                    <span class="text-xs text-slate-500">{{ __('Only check this if you want to delete the main old photo.') }}</span>
                                </div>
                            </label>
                        @endif

                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2 pt-4">
                            <svg class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ __('Amenities') }}</h3>
                        </div>

                        <div>
                            <x-input-label :value="__('Select Amenities')" />
                            <div class="mt-2 grid gap-3 sm:grid-cols-3">
                                @php $selected = old('amenity_ids', $boardingHouse->amenities->pluck('id')->all()); @endphp
                                @foreach ($amenities as $amenity)
                                    <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-3 shadow-sm hover:border-pink-200 transition-all">
                                        <input type="checkbox" name="amenity_ids[]" value="{{ $amenity->id }}" class="sr-only peer" @checked(in_array($amenity->id, $selected, true))>
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
                                <x-text-input id="new_amenity_field" x-model="newAmenityInput" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-pink-500 focus:ring-pink-500" placeholder="{{ __('e.g. Roof deck') }}" @keydown.enter.prevent="addAmenity()" />
                                <button type="button" @click="addAmenity()" class="inline-flex items-center rounded-xl bg-pink-50 px-4 py-2 text-sm font-bold text-pink-600 hover:bg-pink-100 transition-all active:scale-95">
                                    {{ __('Add') }}
                                </button>
                            </div>
                            
                            <!-- Selected Custom Amenities Chips -->
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
                            <x-input-error :messages="$errors->get('new_amenities')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-4 border-t border-slate-100 pt-8">
                        <a href="{{ route('landlord.boarding-houses.show', $boardingHouse) }}" class="inline-flex items-center rounded-xl px-6 py-3 text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors">{{ __('Cancel') }}</a>
                        <x-primary-button class="rounded-2xl px-8 py-3 bg-pink-600 hover:bg-pink-700 shadow-lg shadow-pink-200 transition-all active:scale-95">
                            {{ __('Update Listing') }}
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
