<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium uppercase text-pink-600">{{ __('Boarding Hub') }}</p>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('My Profile') }}</h2>
            </div>
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                {{ __('Edit Profile') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="bg-white p-6 sm:p-10 shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden relative">
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 bg-pink-50 rounded-full opacity-50"></div>
                <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-24 w-24 bg-purple-50 rounded-full opacity-50"></div>

                <div class="relative flex flex-col sm:flex-row items-center gap-6">
                    <div class="shrink-0">
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="h-32 w-32 rounded-2xl object-cover ring-4 ring-white shadow-lg">
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="text-3xl font-bold text-slate-900">{{ $user->name }}</h3>
                        <p class="text-slate-500 font-medium">{{ $user->email }}</p>
                        <div class="mt-4 flex flex-wrap justify-center sm:justify-start gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-pink-100 text-pink-700 capitalize">
                                {{ str_replace('_', ' ', $user->role->value) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"/></svg>
                                {{ __('Joined') }} {{ $user->created_at->format('M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- User Details -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 shadow-sm sm:rounded-2xl border border-slate-200">
                        <h4 class="text-lg font-semibold text-slate-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ __('Account Details') }}
                        </h4>
                        <div class="space-y-6">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Full Name') }}</label>
                                <p class="text-slate-700 font-medium mt-1">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Email Address') }}</label>
                                <p class="text-slate-700 font-medium mt-1">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Account Status') }}</label>
                                <div class="mt-1">
                                    <span class="inline-flex items-center text-sm font-medium text-emerald-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        {{ __('Verified') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="lg:col-span-2 space-y-6">
                    @if($user->isTenant())
                        <!-- Current Stay Information -->
                        <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">
                            <div class="p-6 border-b border-slate-100 bg-slate-50/30">
                                <h4 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    {{ __('Current Stay') }}
                                </h4>
                            </div>
                            <div class="p-6">
                                @if($currentStay)
                                    <div class="flex flex-col md:flex-row gap-8">
                                        <div class="shrink-0">
                                            @if($currentStay->room->boardingHouse->photoUrl())
                                                <img src="{{ $currentStay->room->boardingHouse->photoUrl() }}" class="w-full md:w-56 h-40 rounded-2xl object-cover shadow-sm ring-1 ring-slate-100">
                                            @else
                                                <div class="w-full md:w-56 h-40 rounded-2xl bg-slate-50 flex flex-col items-center justify-center border border-dashed border-slate-200">
                                                    <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                                    <span class="mt-2 text-[10px] font-bold text-slate-300 uppercase tracking-widest">{{ __('No Photo') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 space-y-4">
                                            <div>
                                                <div class="flex items-center justify-between mb-1">
                                                    <h5 class="text-2xl font-bold text-slate-900">{{ $currentStay->room->boardingHouse->title }}</h5>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                        {{ __('Active') }}
                                                    </span>
                                                </div>
                                                <p class="text-slate-500 font-medium flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 4h1m4 0h1m-4 4h1m4 0h1"/></svg>
                                                    {{ __('Room') }} {{ $currentStay->room->room_number }} • {{ ucfirst($currentStay->room->type) }}
                                                </p>
                                            </div>

                                            <div class="grid grid-cols-2 gap-6 py-4 border-y border-slate-50">
                                                <div>
                                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Address') }}</label>
                                                    <p class="text-sm font-bold text-slate-700 mt-0.5">{{ $currentStay->room->boardingHouse->full_address }}</p>
                                                </div>
                                                <div>
                                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Check In') }}</label>
                                                    <p class="text-sm font-bold text-slate-700 mt-0.5">{{ $currentStay->start_date->format('M d, Y') }}</p>
                                                </div>
                                            </div>

                                            <div class="flex justify-end pt-2">
                                                <a href="{{ route('tenant.reservations.show', $currentStay) }}" class="inline-flex items-center text-sm font-bold text-pink-600 hover:text-pink-500 transition-colors">
                                                    {{ __('View Stay Details') }}
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="py-12 text-center">
                                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-slate-50 mb-6 border border-slate-100 shadow-inner">
                                            <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-4 4h1m4 0h1m-4 4h1m4 0h1"/></svg>
                                        </div>
                                        <h5 class="text-lg font-bold text-slate-900 mb-2">{{ __('No Active Stay') }}</h5>
                                        <p class="text-slate-500 max-w-xs mx-auto text-sm">{{ __('You don\'t have any active room reservations at the moment.') }}</p>
                                        <div class="mt-8">
                                            <a href="{{ route('boarding-houses.index') }}" class="inline-flex items-center px-6 py-3 bg-pink-600 text-white font-bold text-sm rounded-2xl shadow-lg shadow-pink-200 hover:bg-pink-700 hover:shadow-pink-300 transition-all active:scale-95">
                                                {{ __('Explore Stays') }}
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
