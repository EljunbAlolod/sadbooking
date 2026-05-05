<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">{{ __('Welcome Back') }}</p>
                <h2 class="text-3xl font-bold tracking-tight text-slate-700">{{ auth()->user()->name }}<span>{{ __('! 👋') }}</span></h2>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">{{ __('Manage your reservations, view billing notices, and discover your next stay.') }}</p>
            </div>
            <div class="hidden sm:block">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <!-- Summary Stats Section -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Reservations Stat -->
                <a href="{{ route('tenant.reservations.index') }}" class="group relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-8 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1">
                    <div class="flex items-center gap-5">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 transition-colors group-hover:bg-indigo-600 group-hover:text-white">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">{{ __('Reservations') }}</p>
                            <h3 class="text-xl font-black text-slate-900">{{ __('My Requests') }}</h3>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-between text-sm font-bold text-indigo-600">
                        <span>{{ __('View All') }}</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </div>
                </a>

                <!-- Billing Stat -->
                <a href="{{ route('tenant.bill-notices.index') }}" class="group relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-8 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1">
                    @if ($unseenBillNoticeCount > 0)
                        <div class="absolute top-6 right-6 flex h-6 w-6 items-center justify-center rounded-full bg-rose-500 text-[10px] font-black text-white shadow-lg shadow-rose-200">
                            {{ $unseenBillNoticeCount > 9 ? '9+' : $unseenBillNoticeCount }}
                        </div>
                    @endif
                    <div class="flex items-center gap-5">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 transition-colors group-hover:bg-amber-500 group-hover:text-white">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">{{ __('Billing') }}</p>
                            <h3 class="text-xl font-black text-slate-900">{{ __('Bill Notices') }}</h3>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-between text-sm font-bold text-amber-600">
                        <span>{{ __('Check Payments') }}</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </div>
                </a>

                <!-- Quick Browse Stat -->
                <a href="{{ route('boarding-houses.index') }}" class="group relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-8 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1">
                    <div class="flex items-center gap-5">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 transition-colors group-hover:bg-emerald-500 group-hover:text-white">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">{{ __('Stay') }}</p>
                            <h3 class="text-xl font-black text-slate-900">{{ __('Browse BH') }}</h3>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-between text-sm font-bold text-emerald-600">
                        <span>{{ __('Find New Stay') }}</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </div>
                </a>
            </div>

            <!-- Recommended Stays (Using the Premium BH Card Design) -->
            <section class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1 bg-indigo-600 rounded-full"></div>
                        <h3 class="text-xl font-bold text-slate-900">{{ __('Recommended for You') }}</h3>
                    </div>
                    <a href="{{ route('boarding-houses.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-wider">
                        {{ __('See All Stays') }}
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </div>

                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($recommendedBoardingHouses as $house)
                        <article class="group relative flex flex-col overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm hover:shadow-2xl hover:border-indigo-200 transition-all duration-500">
                            <div class="relative h-48 w-full overflow-hidden bg-slate-100">
                                @if ($house->photoUrl())
                                    <img src="{{ $house->photoUrl() }}" alt="{{ $house->title }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="flex h-full w-full flex-col items-center justify-center text-slate-400">
                                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                @endif
                                
                                @if ($house->rooms->isNotEmpty())
                                    <div class="absolute bottom-3 left-3">
                                        <div class="rounded-xl bg-white/95 backdrop-blur-md px-2.5 py-1 shadow-lg flex items-center gap-1.5">
                                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">{{ __('From') }}</p>
                                            <span class="text-xs font-black text-indigo-600">₱{{ number_format((float) $house->rooms->min('monthly_rate'), 0) }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-1 flex-col gap-4 p-6">
                                <div class="flex-1">
                                    <h4 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $house->title }}</h4>
                                    <p class="mt-1 line-clamp-1 text-xs text-slate-500 flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        {{ $house->full_address }}
                                    </p>
                                    <p class="mt-2 text-[10px] font-bold text-emerald-600 uppercase tracking-widest flex items-center gap-1.5">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ trans_choice(':count room available|:count rooms available', $house->availableRoomsCount(), ['count' => $house->availableRoomsCount()]) }}
                                    </p>
                                </div>

                                <div class="mt-auto pt-4 border-t border-slate-100">
                                    <a href="{{ route('boarding-houses.show', $house) }}" class="inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-3 text-xs font-bold text-white transition-all hover:bg-indigo-600 active:scale-95 group/btn">
                                        {{ __('View Details') }}
                                        <svg class="h-3.5 w-3.5 ml-1.5 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full py-12 text-center rounded-3xl border-2 border-dashed border-slate-200 bg-white">
                            <p class="text-sm text-slate-500">{{ __('No recommendations yet. Try browsing our marketplace!') }}</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Current Stay Section -->
            <section class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-1 bg-indigo-600 rounded-full"></div>
                    <h3 class="text-xl font-bold text-slate-900">{{ __('Current Stay') }}</h3>
                </div>

                <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
                    @if ($currentStay)
                        <div class="p-8 sm:p-10">
                            <div class="grid gap-10 lg:grid-cols-3">
                                <div class="lg:col-span-2">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                                        <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-3xl bg-indigo-50 text-indigo-600">
                                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-2xl font-black text-slate-900">{{ $currentStay->room->boardingHouse->title }}</h4>
                                            <p class="mt-2 flex items-center gap-2 text-sm text-slate-500">
                                                <svg class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                {{ $currentStay->room->boardingHouse->full_address }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-10 grid gap-8 sm:grid-cols-3">
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Room Number') }}</p>
                                            <p class="text-sm font-bold text-slate-700">{{ $currentStay->room->room_number }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Stay Period') }}</p>
                                            <p class="text-sm font-bold text-slate-700">
                                                {{ $currentStay->start_date->format('M j, Y') }} – 
                                                @if($currentStay->end_date)
                                                    {{ $currentStay->end_date->format('M j, Y') }}
                                                @else
                                                    <span class="italic text-indigo-500">{{ __('Ongoing') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Status') }}</p>
                                            <span class="inline-flex rounded-lg bg-emerald-50 px-2.5 py-1 text-[10px] font-black text-emerald-600 uppercase tracking-wider border border-emerald-100">
                                                {{ ucfirst($currentStay->status->value) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col justify-center rounded-3xl bg-slate-50 p-8 lg:p-10">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ __('Monthly Rate') }}</p>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-3xl font-black text-slate-900">₱{{ number_format($currentStay->room->monthly_rate, 2) }}</span>
                                        <span class="text-sm font-bold text-slate-500">/ mo</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-50 text-slate-300 mb-6">
                                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <h4 class="text-xl font-bold text-slate-900">{{ __('No active stay') }}</h4>
                            <p class="mt-2 text-slate-500">{{ __('You don\'t have any active property stay at the moment.') }}</p>
                            <a href="{{ route('boarding-houses.index') }}" class="mt-8 inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-8 py-4 text-sm font-bold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95">
                                {{ __('Find a Place') }}
                            </a>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
