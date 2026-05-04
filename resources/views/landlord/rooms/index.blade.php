<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-purple-600">{{ $boardingHouse->title }}</p>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">{{ __('Manage Rooms') }}</h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('landlord.boarding-houses.show', $boardingHouse) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-purple-600 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    {{ __('Back') }}
                </a>
                <a href="{{ route('landlord.boarding-houses.rooms.create', $boardingHouse) }}">
                    <x-primary-button class="rounded-2xl px-6 py-2.5 bg-purple-600 hover:bg-purple-700 shadow-lg shadow-purple-100 transition-all active:scale-95">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        {{ __('Add Room') }}
                    </x-primary-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($boardingHouse->rooms as $room)
                    <div class="group relative bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300 overflow-hidden">
                        <!-- Room Header / Image Preview -->
                        <div class="relative h-48 bg-slate-100 overflow-hidden">
                            @if($room->photos->isNotEmpty())
                                <img src="{{ $room->photos->first()->url() }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Room {{ $room->room_number }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            
                            <div class="absolute top-4 right-4">
                                <span @class([
                                    'px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm',
                                    'bg-green-100 text-green-700' => $room->status->value === 'available',
                                    'bg-red-100 text-red-700' => $room->status->value === 'full',
                                    'bg-amber-100 text-amber-700' => $room->status->value === 'maintenance',
                                ])>
                                    {{ $room->status->value }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-purple-600 transition-colors">{{ __('Room') }} {{ $room->room_number }}</h3>
                                    <p class="text-sm text-slate-500 flex items-center gap-1 mt-1">
                                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span class="font-semibold text-purple-600">₱{{ number_format($room->monthly_rate, 2) }}</span> / month
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100">
                                    <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 mb-1">{{ __('Occupants') }}</p>
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        <span class="text-sm font-bold text-slate-700">{{ $room->current_occupants }} / {{ $room->capacity }}</span>
                                    </div>
                                </div>
                                <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100">
                                    <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 mb-1">{{ __('Photos') }}</p>
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        <span class="text-sm font-bold text-slate-700">{{ $room->photos->count() }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($room->amenities->isNotEmpty())
                                <div class="mb-6">
                                    <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 mb-2">{{ __('Amenities') }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($room->amenities->take(3) as $amenity)
                                            <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-medium border border-indigo-100/50">
                                                {{ $amenity->name }}
                                            </span>
                                        @endforeach
                                        @if($room->amenities->count() > 3)
                                            <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-medium">
                                                +{{ $room->amenities->count() - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                                <a href="{{ route('landlord.boarding-houses.rooms.edit', [$boardingHouse, $room]) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-purple-600 text-white text-xs font-bold rounded-xl hover:bg-purple-700 transition-colors shadow-sm shadow-purple-100">
                                    {{ __('Edit Details') }}
                                </a>
                                <form method="POST" action="{{ route('landlord.boarding-houses.rooms.destroy', [$boardingHouse, $room]) }}" onsubmit="return confirm('{{ __('Delete this room?') }}');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-colors" title="{{ __('Delete Room') }}">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-400 mb-4">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">{{ __('No rooms found') }}</h3>
                        <p class="text-slate-500 mt-2">{{ __('Get started by adding your first room to this boarding house.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
