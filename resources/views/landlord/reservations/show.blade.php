<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-pink-600 uppercase tracking-wider">{{ __('Reservation Details') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $reservation->tenant->name }}</h2>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">{{ __('Complete details of the reservation request and property info.') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('landlord.reservations.index') }}" class="inline-flex h-12 items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    {{ __('Back') }}
                </a>
                
                <form method="POST" action="{{ route('landlord.reservations.destroy', $reservation) }}" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this reservation? This action cannot be undone.') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex h-12 items-center justify-center rounded-2xl bg-white border border-rose-200 px-6 py-2.5 text-sm font-bold text-rose-600 shadow-sm transition-all hover:bg-rose-50 active:scale-95">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            @php
                $statusStyles = match ($reservation->status) {
                    \App\Enums\ReservationStatus::Pending => 'bg-amber-50 text-amber-700 border-amber-100',
                    \App\Enums\ReservationStatus::Approved => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                    \App\Enums\ReservationStatus::Rejected => 'bg-rose-50 text-rose-700 border-rose-100',
                    \App\Enums\ReservationStatus::Active => 'bg-pink-50 text-pink-700 border-pink-100',
                    \App\Enums\ReservationStatus::Completed => 'bg-slate-50 text-slate-600 border-slate-200',
                    \App\Enums\ReservationStatus::Cancelled => 'bg-slate-100 text-slate-500 border-slate-200',
                };
            @endphp

            <!-- Summary Card -->
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl">
                <div class="relative h-72 w-full overflow-hidden bg-slate-100">
                    @if ($reservation->room->boardingHouse->photoUrl())
                        <img src="{{ $reservation->room->boardingHouse->photoUrl() }}" alt="{{ $reservation->room->boardingHouse->title }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full flex-col items-center justify-center text-slate-400">
                            <svg class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    @endif
                    
                    <div class="absolute bottom-6 left-6 right-6 flex items-end justify-between">
                        <div class="rounded-2xl bg-white/95 backdrop-blur-md p-4 shadow-xl border border-white/20">
                            <h3 class="text-xl font-black text-slate-900 leading-none">{{ $reservation->room->boardingHouse->title }} — {{ __('Room') }} {{ $reservation->room->room_number }}</h3>
                            <p class="mt-2 text-sm font-medium text-slate-500 flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                {{ $reservation->room->boardingHouse->full_address }}
                            </p>
                        </div>
                        <div class="rounded-2xl bg-white/95 backdrop-blur-md px-6 py-4 shadow-xl border border-white/20 text-right">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ __('Current Status') }}</p>
                            <span class="inline-flex rounded-full px-4 py-1 text-xs font-bold uppercase tracking-widest shadow-sm border {{ $statusStyles }}">
                                {{ $reservation->status->value }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-8 sm:p-10">
                    <div class="grid gap-10 lg:grid-cols-2">
                        <!-- Left Side: Tenant & Stay Info -->
                        <div class="space-y-8">
                            <div>
                                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">{{ __('Tenant Information') }}</h4>
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 font-bold">
                                        {{ substr($reservation->tenant->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-slate-900">{{ $reservation->tenant->name }}</p>
                                        <p class="text-sm text-slate-500">{{ $reservation->tenant->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6 bg-slate-50 p-6 rounded-3xl">
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Check In') }}</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $reservation->start_date->format('l, M j, Y') }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Check Out') }}</p>
                                    <p class="text-sm font-bold text-slate-700">
                                        @if($reservation->end_date)
                                            {{ $reservation->end_date->format('l, M j, Y') }}
                                        @else
                                            <span class="italic text-pink-500">{{ __('Ongoing Stay') }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Room Specifics -->
                        <div class="space-y-8">
                             <div>
                                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">{{ __('Room Details') }}</h4>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-slate-500">{{ __('Room Number') }}</span>
                                        <span class="text-sm font-bold text-slate-900">{{ $reservation->room->room_number }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-slate-500">{{ __('Monthly Rate') }}</span>
                                        <span class="text-sm font-bold text-pink-600">₱{{ number_format($reservation->room->monthly_rate, 2) }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-slate-500">{{ __('Capacity') }}</span>
                                        <span class="text-sm font-bold text-slate-900">{{ $reservation->room->capacity }} pax</span>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Room Amenities') }}</h5>
                                <div class="flex flex-wrap gap-2">
                                    @forelse ($reservation->room->amenities as $amenity)
                                        <span class="inline-flex rounded-xl bg-slate-50 px-3 py-1.5 text-[10px] font-bold text-slate-500 uppercase tracking-wider border border-slate-100">
                                            {{ $amenity->name }}
                                        </span>
                                    @empty
                                        <p class="text-xs text-slate-400 italic">{{ __('No amenities listed.') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if ($reservation->status === \App\Enums\ReservationStatus::Pending)
                        <div class="mt-12 pt-8 border-t border-slate-100 flex flex-wrap gap-4">
                            <form method="POST" action="{{ route('landlord.reservations.approve', $reservation) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center rounded-2xl bg-pink-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-pink-200 transition-all hover:bg-pink-700 active:scale-95">
                                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    {{ __('Approve Reservation') }}
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('landlord.reservations.reject', $reservation) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-8 py-4 text-sm font-bold text-slate-700 shadow-sm transition-all hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 active:scale-95">
                                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    {{ __('Reject Request') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
