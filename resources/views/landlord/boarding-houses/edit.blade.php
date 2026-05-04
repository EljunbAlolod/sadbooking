<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-indigo-600">{{ __('Boarding house') }}</p>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Edit listing') }}</h2>
            <p class="mt-1 text-sm text-slate-600">{{ $boardingHouse->title }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                <form method="POST" action="{{ route('landlord.boarding-houses.update', $boardingHouse) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="title" :value="__('Boarding house name')" />
                        <x-text-input id="title" name="title" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('title', $boardingHouse->title)" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $boardingHouse->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="address" :value="__('Location / address')" />
                        <x-text-input id="address" name="address" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('address', $boardingHouse->address)" required />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    @if ($boardingHouse->photos->isNotEmpty())
                        <div>
                            <x-input-label :value="__('Current pictures')" />
                            <div class="mt-2 grid grid-cols-2 gap-3 sm:grid-cols-3">
                                @foreach ($boardingHouse->photos as $photo)
                                    <label class="group relative overflow-hidden rounded-xl border border-slate-200">
                                        <img src="{{ $photo->url() }}" alt="" class="h-28 w-full object-cover">
                                        <span class="absolute inset-x-0 bottom-0 bg-black/55 px-2 py-1 text-xs text-white">
                                            <input type="checkbox" name="remove_photo_ids[]" value="{{ $photo->id }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                            {{ __('Remove') }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <x-input-label for="photos" :value="__('Add new pictures')" />
                        <input id="photos" name="photos[]" type="file" accept="image/*" multiple class="mt-1 block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                        <x-input-error :messages="\Illuminate\Support\Arr::flatten($errors->get('photos.*'))" class="mt-2" />
                    </div>

                    @if ($boardingHouse->photo_path)
                        <label class="flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" name="remove_photo" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(old('remove_photo'))>
                            {{ __('Remove legacy primary photo') }}
                        </label>
                    @endif

                    <div>
                        <x-input-label :value="__('Amenities')" />
                        <div class="mt-2 grid gap-2 sm:grid-cols-2">
                            @php $selected = old('amenity_ids', $boardingHouse->amenities->pluck('id')->all()); @endphp
                            @foreach ($amenities as $amenity)
                                <label class="inline-flex items-center gap-2 rounded-lg border border-slate-100 bg-slate-50/80 px-3 py-2 text-sm hover:border-slate-200">
                                    <input type="checkbox" name="amenity_ids[]" value="{{ $amenity->id }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(in_array($amenity->id, $selected, true))>
                                    <span>{{ $amenity->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <x-input-label for="new_amenities" :value="__('Add new amenities')" />
                        <textarea id="new_amenities" name="new_amenities" rows="2" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="{{ __('Example: Common CR, CCTV, Study area') }}">{{ old('new_amenities') }}</textarea>
                        <p class="mt-1 text-xs text-slate-500">{{ __('Separate by comma or new line.') }}</p>
                    </div>
                    <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                        <x-primary-button class="rounded-xl">{{ __('Update') }}</x-primary-button>
                        <a href="{{ route('landlord.boarding-houses.show', $boardingHouse) }}" class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
