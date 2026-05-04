<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-indigo-600">{{ __('Edit reservation') }}</p>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $reservation->room->boardingHouse->title }}</h2>
            <p class="mt-1 text-sm text-slate-600">{{ __('Room') }} {{ $reservation->room->room_number }} · {{ __('Pending only') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                <form method="POST" action="{{ route('tenant.reservations.update', $reservation) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="start_date" :value="__('Start date')" />
                        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm" :value="old('start_date', $reservation->start_date->toDateString())" required />
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="end_date" :value="__('End date')" />
                        <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm" :value="old('end_date', $reservation->end_date?->toDateString())" />
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <x-primary-button class="rounded-xl">{{ __('Save changes') }}</x-primary-button>
                        <a href="{{ route('tenant.reservations.show', $reservation) }}" class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
