<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-bold text-2xl text-slate-900 leading-tight">{{ $boardingHouse->title }}</h2>
            <a href="{{ route('boarding-houses.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                {{ __('Back to search') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Photo Gallery & Lightbox -->
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
                            <!-- Main Photo -->
                            <div class="sm:col-span-2 sm:row-span-2 relative overflow-hidden rounded-3xl border border-slate-200/80 shadow-md cursor-pointer group"
                                @click="open = true; currentIndex = 0">
                                <img src="{{ $boardingHouse->photos[0]->url() }}" alt="" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                <div class="absolute inset-0 bg-black/10 transition-colors group-hover:bg-black/20"></div>
                            </div>
                            
                            <!-- Other Photos -->
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

                            <!-- Mobile Fallback -->
                            @if($boardingHouse->photos->count() < 5)
                                @for($i = $boardingHouse->photos->count(); $i < 5; $i++)
                                     <div class="hidden sm:block rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50"></div>
                                @endfor
                            @endif
                        </div>
                        
                        <button @click="open = true; currentIndex = 0" 
                            class="absolute bottom-4 right-4 flex items-center gap-2 rounded-xl bg-white/90 px-4 py-2 text-sm font-semibold text-slate-900 shadow-lg backdrop-blur-md transition-all hover:bg-white active:scale-95">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ __('Show all photos') }}
                        </button>
                    </div>
                @elseif ($boardingHouse->photoUrl())
                    <div class="overflow-hidden rounded-3xl border border-slate-200/80 shadow-md cursor-pointer group"
                        @click="open = true; currentIndex = 0">
                        <img src="{{ $boardingHouse->photoUrl() }}" alt="" class="max-h-[500px] w-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                @endif

                <!-- Lightbox Modal -->
                <div x-show="open" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="fixed inset-0 z-[99] flex items-center justify-center bg-slate-950/95 backdrop-blur-xl p-4 sm:p-10"
                    @keydown.escape.window="open = false"
                    style="display: none;">
                    
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
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 bg-white/10 px-4 py-1 rounded-full text-white text-sm backdrop-blur-md">
                            <span x-text="currentIndex + 1"></span> / <span x-text="photos.length"></span>
                        </div>
                    </div>
                </div>

                <div class="grid gap-8 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Description -->
                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8 transition-all hover:shadow-md">
                            <h3 class="flex items-center gap-2 text-lg font-bold text-slate-900 mb-4">
                                <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('About this boarding house') }}
                            </h3>
                            <p class="text-slate-700 whitespace-pre-line leading-relaxed">{{ $boardingHouse->description ?: __('No description provided.') }}</p>
                        </div>

                        <!-- Location -->
                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8 transition-all hover:shadow-md">
                            <h3 class="flex items-center gap-2 text-lg font-bold text-slate-900 mb-4">
                                <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ __('Location') }}
                            </h3>
                            <div class="space-y-4">
                                <p class="text-slate-700">{{ $boardingHouse->full_address }}</p>
                                <div class="rounded-2xl bg-slate-100 h-48 flex items-center justify-center text-slate-400">
                                    <svg class="h-8 w-8 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.382V5.618a2 2 0 011.447-1.817L9 2l12 6v9.382a2 2 0 01-1.447 1.817L15 22l-6-2z" /></svg>
                                    {{ __('Map view coming soon') }}
                                </div>
                            </div>
                        </div>

                        <!-- Rooms Section -->
                        <div id="rooms" class="rounded-3xl border border-slate-200/80 bg-white shadow-sm overflow-hidden transition-all hover:shadow-md">
                            <div class="border-b border-slate-100 px-6 py-4 sm:px-8 bg-slate-50/50">
                                <h3 class="flex items-center gap-2 text-lg font-bold text-slate-900">
                                    <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ __('Available Rooms') }}
                                </h3>
                            </div>
                            <div class="divide-y divide-slate-100">
                                @forelse ($boardingHouse->rooms as $room)
                                    <div class="flex flex-col gap-6 px-6 py-6 sm:flex-row sm:items-center sm:justify-between sm:px-8 hover:bg-slate-50/50 transition-colors">
                                        <div class="space-y-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <p class="text-lg font-bold text-slate-900">{{ __('Room') }} {{ $room->room_number }}</p>
                                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $room->status->value === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($room->status->value) }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-4 text-sm text-slate-600">
                                                <div class="flex items-center gap-2">
                                                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                                    {{ __('Capacity') }}: {{ $room->capacity }}
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                                    {{ __('Occupants') }}: {{ $room->current_occupants }}
                                                </div>
                                            </div>

                                            @if ($room->amenities->isNotEmpty())
                                                <div class="flex flex-wrap gap-1.5">
                                                    @foreach($room->amenities as $amenity)
                                                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-[10px] font-medium text-slate-600">
                                                            {{ $amenity->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if ($room->photos->isNotEmpty())
                                                <div x-data="{ rOpen: false, rIndex: 0, rPhotos: [ @foreach($room->photos as $p) '{{ $p->url() }}', @endforeach ] }" class="flex gap-2">
                                                    @foreach ($room->photos->take(4) as $index => $photo)
                                                        <div class="relative cursor-pointer group/room" @click="rOpen = true; rIndex = {{ $index }}">
                                                            <img src="{{ $photo->url() }}" alt="" class="h-14 w-14 rounded-xl object-cover border border-slate-200 transition-transform group-hover/room:scale-105">
                                                            @if($loop->last && $room->photos->count() > 4)
                                                                <div class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-xl text-white text-[10px] font-bold">
                                                                    +{{ $room->photos->count() - 4 }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach

                                                    <!-- Room Lightbox -->
                                                    <template x-teleport="body">
                                                        <div x-show="rOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/90 backdrop-blur-md p-4" style="display: none;" @keydown.escape.window="rOpen = false">
                                                            <button @click="rOpen = false" class="absolute top-6 right-6 text-white"><svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L12 6M6 6l12 12" /></svg></button>
                                                            <button x-show="rPhotos.length > 1" @click="rIndex = (rIndex - 1 + rPhotos.length) % rPhotos.length" class="absolute left-4 text-white p-2 rounded-full bg-white/10 hover:bg-white/20"><svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
                                                            <button x-show="rPhotos.length > 1" @click="rIndex = (rIndex + 1) % rPhotos.length" class="absolute right-4 text-white p-2 rounded-full bg-white/10 hover:bg-white/20"><svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></button>
                                                            <img :src="rPhotos[rIndex]" class="max-h-[90vh] max-w-full rounded-lg shadow-2xl object-contain">
                                                        </div>
                                                    </template>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex flex-col items-end gap-3">
                                            <div class="text-right">
                                                <p class="text-2xl font-bold text-indigo-600">&#8369;{{ number_format((float) $room->monthly_rate, 2) }}</p>
                                                <p class="text-xs text-slate-500">{{ __('per month') }}</p>
                                            </div>

                                            @auth
                                                @if (auth()->user()->isTenant() && $room->status->value === 'available')
                                                    <a href="{{ route('tenant.reservations.create', [$boardingHouse, $room]) }}" 
                                                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 active:scale-95">
                                                        {{ __('Reserve Now') }}
                                                    </a>
                                                @elseif (auth()->user()->isTenant())
                                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-500">
                                                        {{ __('Full') }}
                                                    </span>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-500 transition-colors">
                                                    {{ __('Log in to reserve') }} &rarr;
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex flex-col items-center justify-center py-12 px-6 text-center">
                                        <svg class="h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        <p class="text-slate-600">{{ __('No rooms listed yet.') }}</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Section -->
                    <div class="space-y-6">
                        <!-- Amenities Sidebar Card -->
                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8 transition-all hover:shadow-md">
                            <h3 class="flex items-center gap-2 text-lg font-bold text-slate-900 mb-4">
                                <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" />
                                </svg>
                                {{ __('Amenities') }}
                            </h3>
                            @if ($boardingHouse->amenities->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach($boardingHouse->amenities as $amenity)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 border border-indigo-100">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            {{ $amenity->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-slate-500 italic">{{ __('No amenities listed.') }}</p>
                            @endif
                        </div>

                        <!-- CTA Card -->
                        <div class="rounded-3xl bg-indigo-600 p-8 text-white shadow-xl shadow-indigo-200">
                            <h4 class="text-lg font-bold mb-2">{{ __('Interested?') }}</h4>
                            <p class="text-indigo-100 text-sm mb-6">{{ __('Contact the landlord or reserve a room directly from the list.') }}</p>
                            <a href="#rooms" class="block w-full rounded-xl bg-white py-3 text-center text-sm font-bold text-indigo-600 transition-all hover:bg-indigo-50 active:scale-95">
                                {{ __('View Available Rooms') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
