<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-indigo-600">{{ __('Landlord') }}</p>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Overview') }}</h2>
            <p class="mt-1 text-sm text-slate-600">{{ __('Your properties and the latest reservation activity.') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ __('Boarding houses') }}</p>
                    <p class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $boardingHouseCount }}</p>
                    <a href="{{ route('landlord.boarding-houses.index') }}" class="mt-3 inline-flex text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ __('Manage listings') }}</a>
                </div>
                <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ __('Pending reservations') }}</p>
                    <p class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $pendingReservations }}</p>
                    <a href="{{ route('landlord.reservations.index') }}" class="mt-3 inline-flex text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ __('Review requests') }}</a>
                </div>
            </div>

            <section class="rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <div class="flex flex-col gap-2 border-b border-slate-100 px-6 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">{{ __('My boarding houses') }}</h3>
                        <p class="text-sm text-slate-600">{{ __('Recent listings and quick stats.') }}</p>
                    </div>
                    <a href="{{ route('landlord.boarding-houses.create') }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">{{ __('Add listing') }}</a>
                </div>
                <div class="grid gap-4 p-6 sm:grid-cols-2 lg:grid-cols-3 sm:p-8">
                    @forelse ($boardingHouses as $house)
                        <article class="flex flex-col overflow-hidden rounded-xl border border-slate-100 bg-slate-50/50">
                            <div class="relative aspect-[16/10] bg-slate-200">
                                @if ($house->photoUrl())
                                    <img src="{{ $house->photoUrl() }}" alt="" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full items-center justify-center text-sm text-slate-500">{{ __('No photo') }}</div>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col gap-2 p-4">
                                <h4 class="font-semibold text-slate-900">{{ $house->title }}</h4>
                                <p class="line-clamp-2 text-sm text-slate-600">{{ $house->full_address }}</p>
                                <p class="text-xs text-slate-500">{{ trans_choice(':count room|:count rooms', $house->rooms_count, ['count' => $house->rooms_count]) }}</p>
                                @if ($house->amenities->isNotEmpty())
                                    <p class="text-xs text-slate-500">{{ $house->amenities->pluck('name')->take(3)->join(', ') }}{{ $house->amenities->count() > 3 ? '…' : '' }}</p>
                                @endif
                                <div class="mt-auto flex flex-wrap gap-2 pt-2">
                                    <a href="{{ route('landlord.boarding-houses.show', $house) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ __('Open') }}</a>
                                    <span class="text-slate-300" aria-hidden="true">|</span>
                                    <a href="{{ route('landlord.boarding-houses.rooms.index', $house) }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ __('Rooms') }}</a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-slate-600 sm:col-span-3">{{ __('You have not added a boarding house yet.') }}</p>
                    @endforelse
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-4 sm:px-8">
                    <h3 class="text-lg font-semibold text-slate-900">{{ __('Recent reservations') }}</h3>
                    <p class="text-sm text-slate-600">{{ __('Latest requests across all your properties.') }}</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead>
                            <tr class="bg-slate-50/80 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                <th class="px-6 py-3 sm:px-8">{{ __('Tenant') }}</th>
                                <th class="px-6 py-3">{{ __('Property') }}</th>
                                <th class="px-6 py-3">{{ __('Room') }}</th>
                                <th class="px-6 py-3">{{ __('Dates') }}</th>
                                <th class="px-6 py-3">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($recentReservations as $reservation)
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
                                    <td class="px-6 py-4 text-slate-900 sm:px-8">{{ $reservation->tenant->name }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ $reservation->room->boardingHouse->title }}</td>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-slate-600 sm:px-8">{{ __('No reservations yet.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($recentReservations->isNotEmpty())
                    <div class="border-t border-slate-100 px-6 py-4 sm:px-8">
                        <a href="{{ route('landlord.reservations.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ __('View all reservations') }} →</a>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
