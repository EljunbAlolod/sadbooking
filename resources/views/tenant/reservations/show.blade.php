<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">{{ __('Reservation') }}</p>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $reservation->room->boardingHouse->title }}</h2>
                <p class="mt-1 text-sm text-slate-600">{{ __('Room') }} {{ $reservation->room->room_number }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('tenant.reservations.index') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">{{ __('Back to list') }}</a>
                @if ($reservation->status === \App\Enums\ReservationStatus::Pending)
                    <a href="{{ route('tenant.reservations.edit', $reservation) }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-700 shadow-sm hover:bg-slate-50">{{ __('Edit dates') }}</a>
                    <form method="POST" action="{{ route('tenant.reservations.cancel', $reservation) }}" class="inline" onsubmit="return confirm('{{ __('Cancel this reservation request?') }}');">
                        @csrf
                        <x-danger-button type="submit" class="rounded-xl">{{ __('Cancel request') }}</x-danger-button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            @php
                $statusStyles = match ($reservation->status) {
                    \App\Enums\ReservationStatus::Pending => 'bg-amber-50 text-amber-800 ring-amber-200',
                    \App\Enums\ReservationStatus::Approved => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
                    \App\Enums\ReservationStatus::Rejected => 'bg-red-50 text-red-800 ring-red-200',
                    \App\Enums\ReservationStatus::Active => 'bg-indigo-50 text-indigo-800 ring-indigo-200',
                    \App\Enums\ReservationStatus::Completed => 'bg-slate-100 text-slate-700 ring-slate-200',
                    \App\Enums\ReservationStatus::Cancelled => 'bg-slate-100 text-slate-600 ring-slate-200',
                };
            @endphp

            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8 space-y-4">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-sm font-medium text-slate-500">{{ __('Status') }}</span>
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $statusStyles }}">{{ ucfirst($reservation->status->value) }}</span>
                </div>
                <dl class="grid gap-3 text-sm text-slate-700">
                    <div><span class="font-semibold text-slate-900">{{ __('Location') }}:</span> {{ $reservation->room->boardingHouse->address }}</div>
                    <div><span class="font-semibold text-slate-900">{{ __('Start') }}:</span> {{ $reservation->start_date->format('l, M j, Y') }}</div>
                    <div>
                        <span class="font-semibold text-slate-900">{{ __('End') }}:</span> 
                        @if($reservation->end_date)
                            {{ $reservation->end_date->format('l, M j, Y') }}
                        @else
                            <span class="italic text-slate-500">{{ __('Ongoing') }}</span>
                        @endif
                    </div>
                    <div><span class="font-semibold text-slate-900">{{ __('Monthly rate (room)') }}:</span> {{ number_format((float) $reservation->room->monthly_rate, 2) }}</div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
