<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $boardingHouse->title }}</h2>
            <div class="flex flex-wrap gap-3 text-sm">
                <a href="{{ route('landlord.boarding-houses.rooms.index', $boardingHouse) }}" class="text-indigo-600 underline">{{ __('Manage rooms') }}</a>
                <a href="{{ route('landlord.boarding-houses.edit', $boardingHouse) }}" class="text-indigo-600 underline">{{ __('Edit') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if ($boardingHouse->photos->isNotEmpty())
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                    @foreach ($boardingHouse->photos as $photo)
                        <div class="overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm">
                            <img src="{{ $photo->url() }}" alt="" class="h-40 w-full object-cover sm:h-52">
                        </div>
                    @endforeach
                </div>
            @elseif ($boardingHouse->photoUrl())
                <div class="overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm">
                    <img src="{{ $boardingHouse->photoUrl() }}" alt="" class="max-h-80 w-full object-cover">
                </div>
            @endif
            <div class="space-y-3 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                <p class="text-slate-700 whitespace-pre-line">{{ $boardingHouse->description ?: __('No description.') }}</p>
                <p class="text-sm text-slate-600">{{ $boardingHouse->address }}</p>
                @if ($boardingHouse->amenities->isNotEmpty())
                    <p class="text-sm text-slate-800">{{ __('Amenities') }}: {{ $boardingHouse->amenities->pluck('name')->join(', ') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
