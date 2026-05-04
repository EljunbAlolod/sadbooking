<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-indigo-600">{{ __('Boarding house') }}</p>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Add a new listing') }}</h2>
            <p class="mt-1 text-sm text-slate-600">{{ __('Name, location, photos, amenities, and your first room in one step.') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                <form method="POST" action="{{ route('landlord.boarding-houses.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    <div class="space-y-4">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">{{ __('Property') }}</h3>
                        <div>
                            <x-input-label for="title" :value="__('Boarding house name')" />
                            <x-text-input id="title" name="title" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('title')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="address" :value="__('Location / address')" />
                            <x-text-input id="address" name="address" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('address')" required />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="photos" :value="__('Boarding house pictures (multiple)')" />
                            <input id="photos" name="photos[]" type="file" accept="image/*" multiple class="mt-1 block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
                            <p class="mt-1 text-xs text-slate-500">{{ __('Upload up to 10 photos. JPG, PNG, or WebP up to 4 MB each.') }}</p>
                            <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                            <x-input-error :messages="\Illuminate\Support\Arr::flatten($errors->get('photos.*'))" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label :value="__('Amenities')" />
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
                            <x-input-label for="new_amenities" :value="__('Add new amenities')" />
                            <textarea id="new_amenities" name="new_amenities" rows="2" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="{{ __('Example: Common CR, CCTV, Study area') }}">{{ old('new_amenities') }}</textarea>
                            <p class="mt-1 text-xs text-slate-500">{{ __('Separate by comma or new line.') }}</p>
                            <x-input-error :messages="$errors->get('new_amenities')" class="mt-2" />
                        </div>
                    </div>

                    <div class="space-y-4 border-t border-slate-100 pt-8">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">{{ __('First room') }}</h3>
                        <p class="text-sm text-slate-600">{{ __('You can add more rooms after saving.') }}</p>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <x-input-label for="room_number" :value="__('Room number')" />
                                <x-text-input id="room_number" name="room_number" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('room_number')" required />
                                <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="monthly_rate" :value="__('Monthly rate')" />
                                <x-text-input id="monthly_rate" name="monthly_rate" type="number" step="0.01" min="0" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('monthly_rate')" required />
                                <x-input-error :messages="$errors->get('monthly_rate')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="capacity" :value="__('Capacity (optional)')" />
                                <x-text-input id="capacity" name="capacity" type="number" min="1" max="50" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('capacity', '1')" />
                                <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label :value="__('Room amenities (private CR, etc.)')" />
                                <div class="mt-2 grid gap-2 sm:grid-cols-2">
                                    @foreach ($amenities as $amenity)
                                        <label class="inline-flex items-center gap-2 rounded-lg border border-slate-100 bg-slate-50/80 px-3 py-2 text-sm hover:border-slate-200">
                                            <input type="checkbox" name="room_amenity_ids[]" value="{{ $amenity->id }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(in_array($amenity->id, old('room_amenity_ids', []), true))>
                                            <span>{{ $amenity->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="room_new_amenities" :value="__('Add new room amenities')" />
                                <textarea id="room_new_amenities" name="room_new_amenities" rows="2" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="{{ __('Example: Private CR, Sink, Closet') }}">{{ old('room_new_amenities') }}</textarea>
                                <p class="mt-1 text-xs text-slate-500">{{ __('Separate by comma or new line.') }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="room_photos" :value="__('Room pictures (multiple)')" />
                                <input id="room_photos" name="room_photos[]" type="file" accept="image/*" multiple class="mt-1 block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
                                <x-input-error :messages="$errors->get('room_photos')" class="mt-2" />
                                <x-input-error :messages="\Illuminate\Support\Arr::flatten($errors->get('room_photos.*'))" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                        <x-primary-button class="rounded-xl">{{ __('Save listing') }}</x-primary-button>
                        <a href="{{ route('landlord.boarding-houses.index') }}" class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
