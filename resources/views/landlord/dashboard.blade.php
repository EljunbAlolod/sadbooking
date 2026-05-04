<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">{{ __('Landlord Dashboard') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ __('Overview') }}</h2>
                <p class="mt-2 text-sm text-slate-600">{{ __('Manage your properties and track latest activity at a glance.') }}</p>
            </div>
            <div class="hidden sm:block">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="mx-auto max-w-7xl space-y-10 px-4 sm:px-6 lg:px-8">
            
            <!-- Summary Stats -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="group relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">{{ __('Total Boarding Houses') }}</p>
                            <p class="text-4xl font-black text-slate-900 tracking-tight">{{ $boardingHouseCount }}</p>
                        </div>
                        <div class="p-4 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('landlord.boarding-houses.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-wider">
                            {{ __('Manage listings') }}
                            <svg class="h-3 w-3 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </a>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">{{ __('Pending Reservations') }}</p>
                            <p class="text-4xl font-black text-slate-900 tracking-tight">{{ $pendingReservations }}</p>
                        </div>
                        <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('landlord.reservations.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-600 hover:text-amber-700 uppercase tracking-wider">
                            {{ __('Review requests') }}
                            <svg class="h-3 w-3 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Properties Grid -->
            <section class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1 bg-indigo-600 rounded-full"></div>
                        <h3 class="text-xl font-bold text-slate-900">{{ __('My Properties') }}</h3>
                    </div>
                    <a href="{{ route('landlord.boarding-houses.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition-all hover:bg-indigo-700 active:scale-95">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        {{ __('Add Listing') }}
                    </a>
                </div>
                
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($boardingHouses as $house)
                        <article class="group relative flex flex-col overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300">
                            <div class="relative h-48 w-full overflow-hidden bg-slate-100">
                                @if ($house->photoUrl())
                                    <img src="{{ $house->photoUrl() }}" alt="" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="flex h-full w-full flex-col items-center justify-center text-slate-400">
                                        <svg class="h-10 w-10 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col gap-4 p-6">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $house->title }}</h4>
                                    <p class="mt-1 line-clamp-1 text-xs text-slate-500 flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        {{ $house->full_address }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    <span class="flex items-center gap-1">
                                        <svg class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                        {{ trans_choice(':count room|:count rooms', $house->rooms_count, ['count' => $house->rooms_count]) }}
                                    </span>
                                </div>
                                <div class="mt-auto flex items-center gap-3 pt-4 border-t border-slate-100">
                                    <a href="{{ route('landlord.boarding-houses.show', $house) }}" class="flex-1 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white hover:bg-indigo-700 transition-all active:scale-95 shadow-sm shadow-indigo-100">
                                        {{ __('Details') }}
                                    </a>
                                    <a href="{{ route('landlord.boarding-houses.rooms.index', $house) }}" class="flex-1 inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all active:scale-95">
                                        {{ __('Rooms') }}
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-slate-600 sm:col-span-3">{{ __('You have not added a boarding house yet.') }}</p>
                    @endforelse
                </div>
            </section>

            <!-- Recent Reservations -->
            <section class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-100 px-8 py-6">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">{{ __('Recent Reservations') }}</h3>
                        <p class="text-sm text-slate-500">{{ __('Latest requests across all your properties.') }}</p>
                    </div>
                    <a href="{{ route('landlord.reservations.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-wider">
                        {{ __('All reservations') }}
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead>
                            <tr class="bg-slate-50/80 text-left text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                <th class="px-8 py-5">{{ __('Tenant') }}</th>
                                <th class="px-6 py-5">{{ __('Property & Room') }}</th>
                                <th class="px-6 py-5">{{ __('Dates') }}</th>
                                <th class="px-6 py-5">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($recentReservations as $reservation)
                                @php
                                    $statusStyles = match ($reservation->status) {
                                        \App\Enums\ReservationStatus::Pending => 'bg-amber-50 text-amber-700 border-amber-100',
                                        \App\Enums\ReservationStatus::Approved => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        \App\Enums\ReservationStatus::Rejected => 'bg-rose-50 text-rose-700 border-rose-100',
                                        \App\Enums\ReservationStatus::Active => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                        \App\Enums\ReservationStatus::Completed => 'bg-slate-50 text-slate-600 border-slate-200',
                                        \App\Enums\ReservationStatus::Cancelled => 'bg-slate-100 text-slate-500 border-slate-200',
                                    };
                                @endphp
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="text-sm font-bold text-slate-900">{{ $reservation->tenant->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-medium">{{ $reservation->tenant->email }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm font-semibold text-slate-700">{{ $reservation->room->boardingHouse->title }}</div>
                                        <div class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">{{ __('Room') }} {{ $reservation->room->room_number }}</div>
                                    </td>
                                    <td class="px-6 py-5 text-xs font-bold text-slate-600">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            {{ $reservation->start_date->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest shadow-sm border {{ $statusStyles }}">
                                            {{ $reservation->status->value }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-slate-600">{{ __('No recent reservations.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
