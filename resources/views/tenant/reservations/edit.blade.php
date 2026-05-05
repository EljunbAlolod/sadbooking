<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-pink-600 uppercase tracking-wider">{{ __('Modify Request') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ __('Update Reservation') }}</h2>
            </div>
            <a href="{{ route('tenant.reservations.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-pink-600 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                {{ __('Back to reservations') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-3">
                <!-- Room Details Column -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden sticky top-8">
                        <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                            @if ($reservation->room->photos->isNotEmpty())
                                <img src="{{ $reservation->room->photos->first()->url() }}" alt="" class="h-full w-full object-cover">
                            @elseif ($reservation->room->boardingHouse->photoUrl())
                                <img src="{{ $reservation->room->boardingHouse->photoUrl() }}" alt="" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-slate-300">
                                    <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            
                            <div class="absolute top-6 left-6">
                                <span class="px-4 py-2 rounded-2xl bg-white/90 backdrop-blur text-xs font-black text-pink-600 uppercase tracking-widest shadow-lg">
                                    {{ __('Room') }} {{ $reservation->room->room_number }}
                                </span>
                            </div>
                        </div>

                        <div class="p-8 space-y-8">
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 leading-tight">{{ $reservation->room->boardingHouse->title }}</h3>
                                <p class="mt-2 text-sm text-slate-500 flex items-center gap-2 font-medium">
                                    <svg class="h-4 w-4 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    {{ $reservation->room->boardingHouse->full_address }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ __('Monthly Rate') }}</p>
                                    <p class="text-lg font-black text-pink-600">₱{{ number_format((float) $reservation->room->monthly_rate, 2) }}</p>
                                </div>
                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ __('Status') }}</p>
                                    <span class="inline-flex rounded-lg bg-amber-50 px-2 py-0.5 text-[10px] font-black text-amber-600 uppercase tracking-wider border border-amber-100">
                                        {{ $reservation->status->value }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Column -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 p-8 sm:p-12">
                        <div class="flex items-center gap-4 mb-10">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-500 text-white shadow-lg shadow-amber-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900">{{ __('Update Schedule') }}</h3>
                                <p class="text-slate-500 font-medium">{{ __('You can only modify dates while the request is pending.') }}</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('tenant.reservations.update', $reservation) }}" class="space-y-10">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid gap-10 sm:grid-cols-2">
                                <div>
                                    <x-input-label for="start_date" :value="__('Stay Start Date')" class="text-xs font-black uppercase tracking-widest text-slate-500 mb-3" />
                                    <x-text-input id="start_date" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-4 px-5 transition-all focus:border-pink-600 focus:ring-pink-600 focus:bg-white text-slate-900 font-bold" type="date" name="start_date" :value="old('start_date', $reservation->start_date->toDateString())" required />
                                    <x-input-error :messages="$errors->get('start_date')" class="mt-3" />
                                </div>
                                <div>
                                    <x-input-label for="end_date" :value="__('Expected End Date (Optional)')" class="text-xs font-black uppercase tracking-widest text-slate-500 mb-3" />
                                    <x-text-input id="end_date" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-4 px-5 transition-all focus:border-pink-600 focus:ring-pink-600 focus:bg-white text-slate-900 font-bold" type="date" name="end_date" :value="old('end_date', $reservation->end_date?->toDateString())" />
                                    <x-input-error :messages="$errors->get('end_date')" class="mt-3" />
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row items-center gap-6 pt-6 border-t border-slate-50">
                                <x-primary-button class="w-full sm:w-auto px-12 py-5 rounded-2xl bg-pink-600 hover:bg-pink-700 shadow-xl shadow-pink-200 text-sm font-black uppercase tracking-widest transition-all active:scale-95">
                                    {{ __('Save Changes') }}
                                </x-primary-button>
                                <a href="{{ route('tenant.reservations.index') }}" class="text-sm font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-colors">
                                    {{ __('Keep Original') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
