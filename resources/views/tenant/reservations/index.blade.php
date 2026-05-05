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
            
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
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
                    <article class="group relative flex flex-col overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300">
                        <!-- BH Image -->
                        <div class="relative h-48 w-full overflow-hidden bg-slate-100">
                            @if ($reservation->room->boardingHouse->photoUrl())
                                <img src="{{ $reservation->room->boardingHouse->photoUrl() }}" alt="{{ $reservation->room->boardingHouse->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="flex h-full w-full flex-col items-center justify-center text-slate-400">
                                    <svg class="h-10 w-10 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest shadow-sm border {{ $statusStyles }} bg-white/95 backdrop-blur-sm">
                                    {{ $reservation->status->value }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col gap-4 p-6">
                            <div>
                                <h4 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $reservation->room->boardingHouse->title }}</h4>
                                <p class="mt-1 line-clamp-1 text-xs text-slate-500 flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    {{ $reservation->room->boardingHouse->full_address }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-100">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Room') }}</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $reservation->room->room_number }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Monthly Rate') }}</p>
                                    <p class="text-sm font-bold text-indigo-600">₱{{ number_format($reservation->room->monthly_rate, 2) }}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Stay Period') }}</p>
                                    <p class="text-xs font-bold text-slate-600">
                                        {{ $reservation->start_date->format('M d, Y') }} – 
                                        @if($reservation->end_date)
                                            {{ $reservation->end_date->format('M d, Y') }}
                                        @else
                                            <span class="italic text-indigo-500">{{ __('Ongoing') }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="mt-auto flex items-center gap-3">
                                <a href="{{ route('tenant.reservations.show', $reservation) }}" class="flex-1 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-indigo-700 transition-all active:scale-95 shadow-sm shadow-indigo-100">
                                    {{ __('View Details') }}
                                </a>
                                @if($reservation->status === \App\Enums\ReservationStatus::Pending)
                                    <a href="{{ route('tenant.reservations.edit', $reservation) }}" class="inline-flex items-center justify-center h-9 w-9 rounded-xl border border-slate-200 bg-white text-slate-600 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm" title="{{ __('Edit Dates') }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center rounded-3xl border-2 border-dashed border-slate-200 bg-white">
                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-50 text-slate-300 mb-6">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">{{ __('No reservations found') }}</h3>
                        <p class="mt-2 text-slate-500">{{ __('You haven\'t made any reservations yet.') }}</p>
                        <a href="{{ route('boarding-houses.index') }}" class="mt-8 inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95">
                            {{ __('Explore Boarding Houses') }}
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($reservations->hasPages())
                <div class="pt-6">
                    {{ $reservations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
