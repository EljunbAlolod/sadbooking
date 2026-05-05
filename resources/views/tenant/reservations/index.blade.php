<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">{{ __('Reservations') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ __('Your Stays') }}</h2>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">{{ __('Track your ongoing stays, upcoming reservations, and history.') }}</p>
            </div>
            <div class="hidden sm:block">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr class="bg-slate-50/80 text-left text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                <th class="px-8 py-5 sm:px-10">{{ __('Boarding House & Room') }}</th>
                                <th class="px-6 py-5">{{ __('Stay Period') }}</th>
                                <th class="px-6 py-5">{{ __('Monthly Rate') }}</th>
                                <th class="px-6 py-5">{{ __('Status') }}</th>
                                <th class="px-6 py-5"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($reservations as $reservation)
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
                                    <td class="px-8 py-6 sm:px-10">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-900 line-clamp-1">{{ $reservation->room->boardingHouse->title }}</div>
                                                <div class="mt-0.5 text-[10px] font-bold text-indigo-600 uppercase tracking-widest">{{ __('Room') }} {{ $reservation->room->room_number }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                            <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            {{ $reservation->start_date->format('M d, Y') }}
                                        </div>
                                        <div class="mt-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                                            <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            @if($reservation->end_date)
                                                {{ $reservation->end_date->format('M d, Y') }}
                                            @else
                                                <span class="italic text-indigo-500">{{ __('Ongoing') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="text-sm font-bold text-indigo-600">₱{{ number_format($reservation->room->monthly_rate, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest shadow-sm border {{ $statusStyles }}">
                                            {{ $reservation->status->value }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-end sm:px-10">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('tenant.reservations.show', $reservation) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all" title="{{ __('View Details') }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            </a>
                                            @if($reservation->status === \App\Enums\ReservationStatus::Pending)
                                                <a href="{{ route('tenant.reservations.edit', $reservation) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all" title="{{ __('Edit Dates') }}">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50 text-slate-300 mb-6">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">{{ __('No reservations found') }}</h3>
                                        <p class="mt-2 text-sm text-slate-500">{{ __('You haven\'t made any reservations yet.') }}</p>
                                        <a href="{{ route('boarding-houses.index') }}" class="mt-8 inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95">
                                            {{ __('Explore Boarding Houses') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($reservations->hasPages())
                <div class="pt-6">
                    {{ $reservations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
