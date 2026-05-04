<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request reservation') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Details Column -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200/80 overflow-hidden">
                        <div class="aspect-[16/10] overflow-hidden bg-slate-200">
                            @if ($boardingHouse->photoUrl())
                                <img src="{{ $boardingHouse->photoUrl() }}" alt="" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-sm text-slate-500">{{ __('No photo') }}</div>
                            @endif
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">{{ $boardingHouse->title }}</h3>
                                <p class="text-sm text-slate-600">{{ $boardingHouse->address }}</p>
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <p class="text-sm font-medium text-slate-900">{{ __('Room') }} {{ $room->room_number }}</p>
                                <p class="text-sm text-slate-600">{{ __('Monthly Rate') }}: <span class="text-slate-900 font-semibold">{{ number_format((float) $room->monthly_rate, 2) }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Column -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200/80 p-6 sm:p-8">
                        <h3 class="text-lg font-semibold text-slate-900 mb-6">{{ __('Reservation Details') }}</h3>
                        <form method="POST" action="{{ route('tenant.reservations.store', [$boardingHouse, $room]) }}" class="space-y-6">
                            @csrf
                            <div class="grid gap-6 sm:grid-cols-2">
                                <div>
                                    <x-input-label for="start_date" :value="__('Start date')" />
                                    <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required />
                                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="end_date" :value="__('End date (Optional)')" />
                                    <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" />
                                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                    <p class="mt-1 text-xs text-slate-500">{{ __('Leave empty if you are not sure yet.') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 pt-4">
                                <x-primary-button class="px-8">{{ __('Submit request') }}</x-primary-button>
                                <a href="{{ route('boarding-houses.show', $boardingHouse) }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition">{{ __('Cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
