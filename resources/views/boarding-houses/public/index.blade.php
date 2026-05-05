<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-pink-600 uppercase tracking-wider">{{ __('Boarding Hub') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ __('Find a Boarding House') }}</h2>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">{{ __('Discover the perfect stay from our curated selection of verified properties.') }}</p>
            </div>
            <div class="hidden sm:block">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-50 text-pink-600 shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:gap-10 items-start">
                
                <!-- Sidebar Filters -->
                <aside class="w-full lg:w-80 shrink-0 mb-10 lg:mb-0 lg:sticky lg:top-8">
                    <div class="overflow-hidden rounded-[2.5rem] border border-slate-200/80 bg-white shadow-xl shadow-slate-200/40">
                        <div class="p-8 space-y-8">
                            <div class="flex items-center justify-between pb-4 border-b border-slate-50">
                                <h3 class="text-lg font-black text-slate-900 uppercase tracking-wider">{{ __('Filters') }}</h3>
                                <a href="{{ route('boarding-houses.index') }}" class="text-[10px] font-black text-pink-600 uppercase tracking-widest hover:text-rose-500 transition-colors">
                                    {{ __('Reset') }}
                                </a>
                            </div>

                            <form id="filterForm" method="GET" action="{{ route('boarding-houses.index') }}" class="space-y-8">
                                <!-- Location Search -->
                                <div>
                                    <label for="location" class="flex items-center gap-2 text-xs font-black text-slate-400 uppercase tracking-widest mb-4">
                                        <svg class="h-3.5 w-3.5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        {{ __('Location') }}
                                    </label>
                                    <x-text-input id="location" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-3.5 px-5 transition-all focus:border-pink-500 focus:ring-pink-500 focus:bg-white font-bold text-slate-900" type="text" name="location" :value="old('location', $filters['location'] ?? '')" placeholder="Where to?" />
                                </div>
                                
                                <!-- Budget Range Dropdown -->
                                <div>
                                    <label for="budget_range" class="flex items-center gap-2 text-xs font-black text-slate-400 uppercase tracking-widest mb-4">
                                        <svg class="h-3.5 w-3.5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ __('Monthly Budget') }}
                                    </label>
                                    <select id="budget_range" name="budget_range" class="block w-full rounded-2xl border border-slate-200 bg-slate-50/50 py-3.5 px-5 transition-all focus:border-pink-500 focus:ring-pink-500 focus:bg-white text-slate-900 font-bold appearance-none">
                                        <option value="">{{ __('Any Budget') }}</option>
                                        <option value="1-1000" @selected(($filters['budget_range'] ?? '') === '1-1000')>{{ __('₱1 - ₱1,000') }}</option>
                                        <option value="1001-2000" @selected(($filters['budget_range'] ?? '') === '1001-2000')>{{ __('₱1,001 - ₱2,000') }}</option>
                                        <option value="2001-3000" @selected(($filters['budget_range'] ?? '') === '2001-3000')>{{ __('₱2,001 - ₱3,000') }}</option>
                                        <option value="3001-4000" @selected(($filters['budget_range'] ?? '') === '3001-4000')>{{ __('₱3,001 - ₱4,000') }}</option>
                                        <option value="4001-5000" @selected(($filters['budget_range'] ?? '') === '4001-5000')>{{ __('₱4,001 - ₱5,000') }}</option>
                                        <option value="5001+" @selected(($filters['budget_range'] ?? '') === '5001+')>{{ __('₱5,001 and above') }}</option>
                                    </select>
                                </div>

                                <!-- Amenities Filter -->
                                <div class="space-y-4">
                                    <label class="flex items-center gap-2 text-xs font-black text-slate-400 uppercase tracking-widest mb-4">
                                        <svg class="h-3.5 w-3.5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        {{ __('Amenities') }}
                                    </label>
                                    <div class="grid gap-3">
                                        @foreach ($allAmenities as $amenity)
                                            <div class="relative">
                                                <input 
                                                    type="checkbox" 
                                                    id="amenity_{{ $amenity->id }}" 
                                                    name="amenities[]" 
                                                    value="{{ $amenity->id }}"
                                                    class="peer hidden amenity-checkbox"
                                                    @checked(in_array($amenity->id, old('amenities', $filters['amenities'] ?? []), true))
                                                >
                                                <label for="amenity_{{ $amenity->id }}" class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-100 bg-slate-50/30 px-4 py-3 text-xs font-bold text-slate-600 transition-all hover:border-pink-200 hover:bg-pink-50/30 peer-checked:border-pink-600 peer-checked:bg-pink-50 peer-checked:text-pink-700">
                                                    <span class="flex h-5 w-5 items-center justify-center rounded-lg bg-white border border-slate-200 text-transparent transition-all peer-checked:bg-pink-600 peer-checked:border-pink-600 peer-checked:text-white">
                                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </span>
                                                    {{ $amenity->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <button type="submit" class="hidden">{{ __('Submit') }}</button>
                            </form>
                        </div>
                    </div>
                </aside>

                <!-- Results Grid -->
                <div class="flex-1">
                    <div id="resultsContainer" class="grid gap-8 sm:grid-cols-1 md:grid-cols-2">
                        @forelse ($boardingHouses as $house)
                            <article class="group relative flex flex-col overflow-hidden rounded-[2.5rem] border border-slate-200/80 bg-white shadow-sm hover:shadow-2xl hover:border-pink-200 transition-all duration-500">
                                <div class="relative h-64 w-full overflow-hidden bg-slate-100">
                                    @if ($house->photoUrl())
                                        <img src="{{ $house->photoUrl() }}" alt="{{ $house->title }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <div class="flex h-full w-full flex-col items-center justify-center text-slate-400">
                                            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                    
                                    @if ($house->rooms->isNotEmpty())
                                        <div class="absolute bottom-4 left-4">
                                            <div class="rounded-xl bg-white/95 backdrop-blur-md px-3 py-1.5 shadow-lg flex items-center gap-1.5">
                                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('From') }}</p>
                                                <span class="text-sm font-black text-pink-600">₱{{ number_format((float) $house->rooms->min('monthly_rate'), 0) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-1 flex-col gap-4 p-8">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-pink-600 transition-colors line-clamp-1">{{ $house->title }}</h3>
                                        <p class="mt-2 flex items-start gap-2 text-sm text-slate-500">
                                            <svg class="h-5 w-5 shrink-0 text-pink-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            <span class="line-clamp-2 leading-relaxed">{{ $house->full_address }}</span>
                                        </p>
                                        <div class="mt-4 text-xs font-black text-emerald-600 uppercase tracking-widest flex items-center gap-2">
                                            <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <span>
                                                {{ trans_choice(':count room available|:count rooms available', $house->availableRoomsCount(), ['count' => $house->availableRoomsCount()]) }}
                                            </span>
                                        </div>
                                    </div>

                                    @if ($house->amenities->isNotEmpty())
                                        <div class="flex flex-wrap gap-2 py-2 border-t border-slate-50">
                                            @foreach($house->amenities->take(3) as $amenity)
                                                <span class="inline-flex rounded-lg bg-slate-50 px-2 py-1 text-[9px] font-bold text-slate-500 uppercase tracking-wider border border-slate-100">
                                                    {{ $amenity->name }}
                                                </span>
                                            @endforeach
                                            @if($house->amenities->count() > 3)
                                                <span class="text-[9px] font-bold text-slate-400">+{{ $house->amenities->count() - 3 }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="mt-auto pt-6">
                                        <a href="{{ route('boarding-houses.show', $house) }}" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-6 py-4 text-sm font-bold text-white shadow-xl shadow-slate-100 transition-all hover:bg-pink-600 active:scale-95 group/btn">
                                            {{ __('View Details') }}
                                            <svg class="h-4 w-4 ml-2 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="col-span-full py-20 text-center rounded-[2.5rem] border-2 border-dashed border-slate-200 bg-white">
                                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-50 text-slate-300 mb-6">
                                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900">{{ __('No results found') }}</h3>
                                <p class="mt-2 text-slate-500 font-medium">{{ __('Try adjusting your filters or searching in a different area.') }}</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($boardingHouses->hasPages())
                        <div id="paginationContainer" class="pt-10">
                            {{ $boardingHouses->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const locationInput = document.getElementById('location');
            const budgetSelect = document.getElementById('budget_range');
            const amenityCheckboxes = document.querySelectorAll('.amenity-checkbox');
            
            async function updateResults() {
                const formData = new FormData(filterForm);
                const queryParams = new URLSearchParams(formData);
                
                const resultsWrapper = document.getElementById('resultsContainer');
                const paginationWrapper = document.getElementById('paginationContainer');
                
                resultsWrapper.classList.add('opacity-40', 'pointer-events-none');
                
                try {
                    const response = await fetch(`{{ route('boarding-houses.index') }}?${queryParams.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (response.ok) {
                        const html = await response.text();
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const newResults = doc.getElementById('resultsContainer');
                        const newPagination = doc.getElementById('paginationContainer');
                        
                        resultsWrapper.innerHTML = newResults.innerHTML;
                        if (paginationWrapper) {
                            paginationWrapper.innerHTML = newPagination ? newPagination.innerHTML : '';
                        } else if (newPagination) {
                            const newPagContainer = document.createElement('div');
                            newPagContainer.id = 'paginationContainer';
                            newPagContainer.className = 'pt-10';
                            newPagContainer.innerHTML = newPagination.innerHTML;
                            resultsWrapper.parentNode.appendChild(newPagContainer);
                        }
                        
                        window.history.pushState({}, '', `{{ route('boarding-houses.index') }}?${queryParams.toString()}`);
                    }
                } catch (error) {
                    console.error('Filter error:', error);
                } finally {
                    resultsWrapper.classList.remove('opacity-40', 'pointer-events-none');
                }
            }

            // Auto-submit on change
            budgetSelect?.addEventListener('change', updateResults);
            amenityCheckboxes.forEach(cb => cb.addEventListener('change', updateResults));

            // Debounced search for location
            let timeout = null;
            locationInput?.addEventListener('input', () => {
                clearTimeout(timeout);
                timeout = setTimeout(updateResults, 500);
            });

            // Prevent form submit
            filterForm.addEventListener('submit', (e) => e.preventDefault());
        });
    </script>
</x-app-layout>
