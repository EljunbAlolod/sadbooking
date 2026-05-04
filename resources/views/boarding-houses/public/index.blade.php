<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Find a boarding house') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="GET" action="{{ route('boarding-houses.index') }}" class="bg-white shadow-sm sm:rounded-lg p-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <x-input-label for="location" :value="__('Location / address')" />
                    <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $filters['location'] ?? '')" />
                </div>
                <div>
                    <x-input-label for="max_rate" :value="__('Max monthly rate')" />
                    <x-text-input id="max_rate" class="block mt-1 w-full" type="number" step="0.01" name="max_rate" :value="old('max_rate', $filters['max_rate'] ?? '')" />
                </div>
                <div class="sm:col-span-2">
                    <x-input-label :value="__('Amenities')" />
                    <div class="mt-2 flex flex-wrap gap-3 max-h-32 overflow-y-auto">
                        @foreach ($allAmenities as $amenity)
                            <label class="inline-flex items-center gap-2 text-sm">
                                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                    @checked(in_array($amenity->id, old('amenities', $filters['amenities'] ?? []), true))>
                                <span>{{ $amenity->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-end gap-2 sm:col-span-2 lg:col-span-4">
                    <x-primary-button type="submit">{{ __('Search') }}</x-primary-button>
                    <a href="{{ route('boarding-houses.index') }}" class="text-sm text-gray-600 underline">{{ __('Reset') }}</a>
                </div>
            </form>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($boardingHouses as $house)
                    <article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition hover:border-indigo-200 hover:shadow-md">
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-200">
                            @if ($house->photoUrl())
                                <img src="{{ $house->photoUrl() }}" alt="" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center text-sm text-slate-500">{{ __('No photo') }}</div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col gap-2 p-6">
                            <h3 class="text-lg font-semibold text-slate-900">{{ $house->title }}</h3>
                            <p class="text-sm text-slate-600 line-clamp-2">{{ $house->address }}</p>
                            @if ($house->rooms->isNotEmpty())
                                <p class="text-sm text-slate-800">
                                    {{ __('From') }}
                                    <span class="font-semibold">{{ number_format((float) $house->rooms->min('monthly_rate'), 2) }}</span>
                                    / {{ __('mo') }}
                                </p>
                            @endif
                            @if ($house->amenities->isNotEmpty())
                                <p class="text-xs text-slate-500">{{ $house->amenities->pluck('name')->join(', ') }}</p>
                            @endif
                            <div class="mt-auto pt-4">
                                <a href="{{ route('boarding-houses.show', $house) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ __('View details') }} →</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="text-gray-600 sm:col-span-3">{{ __('No boarding houses match your filters yet.') }}</p>
                @endforelse
            </div>

            <div>
                {{ $boardingHouses->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
