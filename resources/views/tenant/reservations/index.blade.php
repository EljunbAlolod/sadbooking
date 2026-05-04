<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-indigo-600">{{ __('Reservations') }}</p>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Your reservations') }}</h2>
            <p class="mt-1 text-sm text-slate-600">{{ __('View, edit pending stays, or cancel a request.') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead>
                            <tr class="bg-slate-50/80 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                <th class="px-6 py-3 sm:px-8">{{ __('Property') }}</th>
                                <th class="px-6 py-3">{{ __('Room') }}</th>
                                <th class="px-6 py-3">{{ __('Dates') }}</th>
                                <th class="px-6 py-3">{{ __('Status') }}</th>
                                <th class="px-6 py-3 text-end sm:px-8">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($reservations as $reservation)
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
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-6 py-4 font-medium text-slate-900 sm:px-8">{{ $reservation->room->boardingHouse->title }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ $reservation->room->room_number }}</td>
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $reservation->start_date->format('M j, Y') }} – 
                                        @if($reservation->end_date)
                                            {{ $reservation->end_date->format('M j, Y') }}
                                        @else
                                            <span class="italic text-slate-400">{{ __('Ongoing') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $statusStyles }}">{{ ucfirst($reservation->status->value) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-end sm:px-8">
                                        <a href="{{ route('tenant.reservations.show', $reservation) }}" class="font-medium text-indigo-600 hover:text-indigo-500">{{ __('View') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-600 sm:px-8">
                                        {{ __('No reservations yet.') }}
                                        <a href="{{ route('boarding-houses.index') }}" class="ms-1 font-medium text-indigo-600 hover:text-indigo-500">{{ __('Find a boarding house') }}</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($reservations->hasPages())
                    <div class="border-t border-slate-100 px-6 py-4">{{ $reservations->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
