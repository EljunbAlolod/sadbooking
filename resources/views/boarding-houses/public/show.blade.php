<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">{{ __('Public Listing') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $boardingHouse->title }}</h2>
            </div>
            <a href="{{ route('boarding-houses.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                {{ __('Back to listings') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="mx-auto max-w-7xl space-y-12 px-4 sm:px-6 lg:px-8">
            <!-- Photo Gallery Section -->
            <div x-data="{ 
                open: false, 
                currentIndex: 0, 
                photos: [
                    @foreach($boardingHouse->photos as $photo)
                        '{{ $photo->url() }}',
                    @endforeach
                    @if($boardingHouse->photos->isEmpty() && $boardingHouse->photoUrl())
                        '{{ $boardingHouse->photoUrl() }}'
                    @endif
                ],
                next() { this.currentIndex = (this.currentIndex + 1) % this.photos.length },
                prev() { this.currentIndex = (this.currentIndex - 1 + this.photos.length) % this.photos.length }
            }" class="space-y-6">
                
                @if ($boardingHouse->photos->isNotEmpty())
                    <div class="relative group">
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-4 sm:grid-rows-2 h-[400px] sm:h-[500px]">
                            <div class="sm:col-span-2 sm:row-span-2 relative overflow-hidden rounded-3xl border border-slate-200/80 shadow-md cursor-pointer group"
                                @click="open = true; currentIndex = 0">
                                <img src="{{ $boardingHouse->photos[0]->url() }}" alt="" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                <div class="absolute inset-0 bg-black/10 transition-colors group-hover:bg-black/20"></div>
                            </div>
                            
                            @foreach ($boardingHouse->photos->slice(1, 4) as $index => $photo)
                                <div class="hidden sm:block relative overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm cursor-pointer group"
                                    @click="open = true; currentIndex = {{ $index + 1 }}">
                                    <img src="{{ $photo->url() }}" alt="" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/5 transition-colors group-hover:bg-black/15"></div>
                                    @if ($loop->last && $boardingHouse->photos->count() > 5)
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/40 backdrop-blur-[2px] text-white font-bold text-lg">
                                            +{{ $boardingHouse->photos->count() - 5 }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <button @click="open = true; currentIndex = 0" 
                            class="absolute bottom-4 right-4 flex items-center gap-2 rounded-xl bg-white/90 px-4 py-2 text-sm font-semibold text-slate-900 shadow-lg backdrop-blur-md transition-all hover:bg-white active:scale-95">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            {{ __('Show all photos') }}
                        </button>
                    </div>
                @endif

                <!-- Lightbox -->
                <div x-show="open" style="display: none;" class="fixed inset-0 z-[99] flex items-center justify-center bg-slate-950/95 backdrop-blur-xl p-4 sm:p-10" @keydown.escape.window="open = false">
                    <button @click="open = false" class="absolute top-6 right-6 z-[100] rounded-full bg-white/10 p-2 text-white hover:bg-white/20 transition-colors">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L12 6M6 6l12 12" /></svg>
                    </button>
                    <button x-show="photos.length > 1" @click="prev()" class="absolute left-4 z-[100] rounded-full bg-white/10 p-3 text-white hover:bg-white/20 transition-colors">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button x-show="photos.length > 1" @click="next()" class="absolute right-4 z-[100] rounded-full bg-white/10 p-3 text-white hover:bg-white/20 transition-colors">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                    <div class="relative h-full w-full flex items-center justify-center">
                        <img :src="photos[currentIndex]" class="max-h-full max-w-full rounded-lg shadow-2xl object-contain">
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid gap-12 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-12">
                    <!-- Property Details -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-1 bg-indigo-600 rounded-full"></div>
                            <h3 class="text-2xl font-bold text-slate-900">{{ __('About this Property') }}</h3>
                        </div>
                        <div class="rounded-3xl border border-slate-200/80 bg-white p-8 shadow-sm leading-relaxed text-slate-700 whitespace-pre-line">
                            {{ $boardingHouse->description ?: __('No description provided.') }}
                        </div>
                    </div>

                    <!-- Available Rooms -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-1 bg-indigo-600 rounded-full"></div>
                                <h3 class="text-2xl font-bold text-slate-900">{{ __('Available Rooms') }}</h3>
                            </div>
                        </div>

                        <div class="grid gap-8 sm:grid-cols-2">
                            @forelse ($boardingHouse->rooms as $room)
                                <div x-data="{ rOpen: false, rIndex: 0, rPhotos: [
                                    @foreach($room->photos as $rp) '{{ $rp->url() }}', @endforeach
                                ] }" class="group relative bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300 overflow-hidden flex flex-col">
                                    
                                    <!-- Room Image Preview -->
                                    <div class="relative h-56 bg-slate-100 overflow-hidden cursor-pointer" @click="if(rPhotos.length) rOpen = true">
                                        @if($room->photos->isNotEmpty())
                                            <img src="{{ $room->photos->first()->url() }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Room {{ $room->room_number }}">
                                            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover:opacity-100">
                                                <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" /></svg>
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
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

                                    <div class="p-6 flex flex-col flex-1">
                                        <div class="flex items-start justify-between mb-4">
                                            <div>
                                                <h4 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ __('Room') }} {{ $room->room_number }}</h4>
                                                <div class="mt-2 flex items-center gap-2">
                                                    <span class="text-2xl font-extrabold text-indigo-600">₱{{ number_format($room->monthly_rate, 2) }}</span>
                                                    <span class="text-sm text-slate-500">/ month</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4 mb-6">
                                            <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100 flex items-center gap-3">
                                                <div class="p-2 bg-white rounded-xl text-indigo-600 shadow-sm">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                                </div>
                                                <div>
                                                    <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400">{{ __('Capacity') }}</p>
                                                    <span class="text-sm font-bold text-slate-700">{{ $room->capacity }} pax</span>
                                                </div>
                                            </div>
                                            <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100 flex items-center gap-3">
                                                <div class="p-2 bg-white rounded-xl text-indigo-600 shadow-sm">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                </div>
                                                <div>
                                                    <div class="flex flex-wrap gap-1.5 mt-2">
                                                    @foreach($room->amenities->take(3) as $amenity)
                                                        <span class="inline-flex rounded-lg bg-indigo-50 px-2 py-0.5 text-[10px] font-bold text-indigo-600 uppercase tracking-wider border border-indigo-100">
                                                            {{ $amenity->name }}
                                                        </span>
                                                    @endforeach
                                                    @if($room->amenities->count() > 3)
                                                        <span class="text-[10px] font-bold text-slate-400 self-center">+{{ $room->amenities->count() - 3 }}</span>
                                                    @endif
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-auto pt-6 border-t border-slate-100">
                                            @auth
                                                @if (auth()->user()->isTenant() && $room->status->value === 'available')
                                                    <a href="{{ route('tenant.reservations.create', [$boardingHouse, $room]) }}" 
                                                        class="inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-6 py-4 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition-all hover:bg-indigo-700 active:scale-95">
                                                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                        {{ __('Reserve This Room') }}
                                                    </a>
                                                @elseif (auth()->user()->isTenant())
                                                    <button disabled class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-100 px-6 py-4 text-sm font-bold text-slate-400 cursor-not-allowed">
                                                        {{ __('Currently Full') }}
                                                    </button>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-6 py-4 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition-all hover:bg-indigo-700 active:scale-95">
                                                    {{ __('Log in to reserve') }}
                                                </a>
                                            @endauth
                                        </div>
                                    </div>

                                    <!-- Room Photo Lightbox -->
                                    <div x-show="rOpen" style="display: none;" class="fixed inset-0 z-[110] flex items-center justify-center bg-slate-950/95 backdrop-blur-xl p-4 sm:p-10" @keydown.escape.window="rOpen = false">
                                        <button @click="rOpen = false" class="absolute top-6 right-6 z-[120] rounded-full bg-white/10 p-2 text-white hover:bg-white/20 transition-colors">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L12 6M6 6l12 12" /></svg>
                                        </button>
                                        <button x-show="rPhotos.length > 1" @click="rIndex = (rIndex - 1 + rPhotos.length) % rPhotos.length" class="absolute left-4 z-[120] rounded-full bg-white/10 p-3 text-white hover:bg-white/20 transition-colors">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                                        </button>
                                        <button x-show="rPhotos.length > 1" @click="rIndex = (rIndex + 1) % rPhotos.length" class="absolute right-4 z-[120] rounded-full bg-white/10 p-3 text-white hover:bg-white/20 transition-colors">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                        </button>
                                        <div class="relative h-full w-full flex items-center justify-center">
                                            <img :src="rPhotos[rIndex]" class="max-h-full max-w-full rounded-lg shadow-2xl object-contain">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-16 text-center rounded-3xl border-2 border-dashed border-slate-200 bg-white">
                                    <svg class="h-16 w-16 mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    <p class="text-slate-500 font-medium">{{ __('No rooms available in this property yet.') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="space-y-12">
                    <!-- Location Info -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 bg-indigo-600 rounded-full"></div>
                            <h3 class="text-xl font-bold text-slate-900">{{ __('Location') }}</h3>
                        </div>
                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm flex items-start gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl shadow-sm">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-slate-700 font-medium leading-relaxed">{{ $boardingHouse->full_address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Amenities -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 bg-indigo-600 rounded-full"></div>
                            <h3 class="text-xl font-bold text-slate-900">{{ __('Amenities') }}</h3>
                        </div>
                        <div class="rounded-3xl border border-slate-200/80 bg-white p-8 shadow-sm">
                            @if ($boardingHouse->amenities->isNotEmpty())
                                <div class="flex flex-wrap gap-3">
                                    @foreach($boardingHouse->amenities as $amenity)
                                        <span class="inline-flex items-center gap-2 rounded-2xl bg-indigo-50 px-4 py-2 text-sm font-bold text-indigo-700 border border-indigo-100/50 shadow-sm">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            {{ $amenity->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-slate-500 italic">{{ __('No common amenities listed.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
