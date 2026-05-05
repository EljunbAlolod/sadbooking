<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $boardingHouse->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if ($boardingHouse->photos->isNotEmpty())
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                    @foreach ($boardingHouse->photos as $photo)
                        <div class="overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm">
                            <img src="{{ $photo->url() }}" alt="" class="h-40 w-full object-cover sm:h-56">
                        </div>
                    @endforeach
                </div>
            @elseif ($boardingHouse->photoUrl())
                <div class="overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm">
                    <img src="{{ $boardingHouse->photoUrl() }}" alt="" class="max-h-96 w-full object-cover">
                </div>
            @endif
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8 space-y-4">
                <p class="text-slate-700 whitespace-pre-line">{{ $boardingHouse->description ?: __('No description provided.') }}</p>
                <p class="text-sm text-slate-600">{{ $boardingHouse->full_address }}</p>
                @if ($boardingHouse->amenities->isNotEmpty())
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">{{ __('Amenities') }}</h3>
                        <ul class="mt-2 flex flex-wrap gap-2 text-sm text-slate-700">
                            @foreach ($boardingHouse->amenities as $amenity)
                                <li class="rounded-full bg-slate-100 px-3 py-1">{{ $amenity->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-4 sm:px-8">
                    <h3 class="text-lg font-semibold text-slate-900">{{ __('Rooms') }}</h3>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($boardingHouse->rooms as $room)
                        <div class="flex flex-col gap-4 px-6 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                            <div class="space-y-2">
                                <p class="font-medium text-slate-900">{{ __('Room') }} {{ $room->room_number }}</p>
                                <p class="text-sm text-slate-600">
                                    {{ __('Capacity') }}: {{ $room->capacity }} ·
                                    {{ __('Occupants') }}: {{ $room->current_occupants }} ·
                                    {{ __('Status') }}: {{ $room->status->value }}
                                </p>
                                @if ($room->amenities->isNotEmpty())
                                    <p class="text-xs text-slate-600">{{ __('Room amenities') }}: {{ $room->amenities->pluck('name')->join(', ') }}</p>
                                @endif
                                <p class="mt-1 text-sm font-medium text-slate-800">
                                    {{ number_format((float) $room->monthly_rate, 2) }} / {{ __('month') }}
                                </p>
                                @if ($room->photos->isNotEmpty())
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($room->photos->take(3) as $photo)
                                            <img src="{{ $photo->url() }}" alt="" class="h-16 w-16 rounded-lg object-cover">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div>
                                @auth
                                    @if (auth()->user()->isTenant() && $room->hasAvailableCapacity())
                                        <a href="{{ route('tenant.reservations.create', [$boardingHouse, $room]) }}">
                                            <x-primary-button type="button" class="rounded-xl">{{ __('Request reservation') }}</x-primary-button>
                                        </a>
                                    @elseif (auth()->user()->isTenant())
                                        <span class="text-sm text-slate-500">{{ __('Full') }}</span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-medium text-pink-600 hover:text-pink-500">{{ __('Log in as a tenant to reserve') }}</a>
                                @endauth
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-6 text-slate-600 sm:px-8">{{ __('No rooms listed yet.') }}</p>
                    @endforelse
                </div>
            </div>

            <a href="{{ route('boarding-houses.index') }}" class="text-sm font-medium text-pink-600 hover:text-pink-500">{{ __('? Back to search') }}</a>
        </div>
    </div>
</x-app-layout>
