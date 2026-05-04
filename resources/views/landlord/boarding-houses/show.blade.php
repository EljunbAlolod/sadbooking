<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">{{ __('Property Details') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $boardingHouse->title }}</h2>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('landlord.boarding-houses.rooms.index', $boardingHouse) }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-800 transition-all active:scale-95 shadow-lg shadow-slate-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    {{ __('Manage Rooms') }}
                </a>
                <a href="{{ route('landlord.boarding-houses.edit', $boardingHouse) }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all active:scale-95 shadow-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    {{ __('Edit Property') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
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

                            <!-- Mobile Fallback for slice -->
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
                    
                    <!-- Close Button -->
                    <button @click="open = false" class="absolute top-6 right-6 z-[100] rounded-full bg-white/10 p-2 text-white hover:bg-white/20 transition-colors">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L12 6M6 6l12 12" /></svg>
                    </button>

                    <!-- Navigation Buttons -->
                    <button x-show="photos.length > 1" @click="prev()" class="absolute left-4 z-[100] rounded-full bg-white/10 p-3 text-white hover:bg-white/20 transition-colors">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button x-show="photos.length > 1" @click="next()" class="absolute right-4 z-[100] rounded-full bg-white/10 p-3 text-white hover:bg-white/20 transition-colors">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>

                    <!-- Main Image in Lightbox -->
                    <div class="relative h-full w-full flex items-center justify-center">
                        <img :src="photos[currentIndex]" class="max-h-full max-w-full rounded-lg shadow-2xl object-contain">
                        
                        <!-- Counter -->
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 bg-white/10 px-4 py-1 rounded-full text-white text-sm backdrop-blur-md">
                            <span x-text="currentIndex + 1"></span> / <span x-text="photos.length"></span>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                            <h3 class="flex items-center gap-2 text-lg font-bold text-slate-900 mb-4">
                                <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('Description') }}
                            </h3>
                            <p class="text-slate-700 whitespace-pre-line leading-relaxed">{{ $boardingHouse->description ?: __('No description provided.') }}</p>
                        </div>

                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                            <h3 class="flex items-center gap-2 text-lg font-bold text-slate-900 mb-4">
                                <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ __('Location') }}
                            </h3>
                            <p class="text-slate-700">{{ $boardingHouse->full_address }}</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
