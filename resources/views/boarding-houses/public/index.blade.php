<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">{{ __('Marketplace') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ __('Find a Boarding House') }}</h2>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">{{ __('Discover the perfect stay from our curated selection of verified properties.') }}</p>
            </div>
            <div class="hidden sm:block">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <!-- Filter Section -->
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl">
                <div class="p-8 sm:p-10">
                    <form id="filterForm" method="GET" action="{{ route('boarding-houses.index') }}" class="grid gap-8 lg:grid-cols-4">
                        <!-- Location Search -->
                        <div class="lg:col-span-1">
                            <label for="location" class="flex items-center gap-2 text-sm font-bold text-slate-900 mb-2">
                                <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                {{ __('Location') }}
                            </label>
                            <x-text-input id="location" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-3 transition-all focus:border-indigo-500 focus:ring-indigo-500" type="text" name="location" :value="old('location', $filters['location'] ?? '')" placeholder="Street, barangay, city, or province..." />
                        </div>
                        
                        <!-- Budget Range Dropdown -->
                        <div class="lg:col-span-1">
                            <label for="budget_range" class="flex items-center gap-2 text-sm font-bold text-slate-900 mb-2">
                                <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ __('Budget Range') }}
                            </label>
                            <select id="budget_range" name="budget_range" class="block w-full rounded-2xl border border-slate-200 bg-slate-50/50 py-3 px-4 transition-all focus:border-indigo-500 focus:ring-indigo-500 text-slate-900 font-medium">
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
                        <div class="lg:col-span-2">
                            <label class="flex items-center gap-2 text-sm font-bold text-slate-900 mb-3">
                                <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                {{ __('Amenities') }}
                            </label>
                            <div class="flex flex-wrap gap-3 max-h-40 overflow-y-auto pr-2 custom-scrollbar">
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
                                        <label for="amenity_{{ $amenity->id }}" class="flex cursor-pointer items-center gap-2 rounded-xl border-2 border-slate-100 bg-white px-4 py-2.5 text-sm font-bold text-slate-600 transition-all hover:border-indigo-200 hover:bg-slate-50 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 peer-checked:shadow-md peer-checked:shadow-indigo-100">
                                            <span class="flex h-5 w-5 items-center justify-center rounded-lg bg-slate-100 text-slate-400 transition-colors peer-checked:bg-indigo-600 peer-checked:text-white group-hover:bg-indigo-100">
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

                        <!-- Action Buttons -->
                        <div class="flex items-end gap-3 lg:col-span-4 lg:col-span-0">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-4 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition-all hover:bg-indigo-700 active:scale-95">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                {{ __('Search') }}
                            </button>
                            <a href="{{ route('boarding-houses.index') }}" class="inline-flex h-13 items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 text-sm font-bold text-slate-400 hover:text-rose-500 transition-colors" title="{{ __('Reset Filters') }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Grid -->
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($boardingHouses as $house)
                    <article class="group relative flex flex-col overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm hover:shadow-2xl hover:border-indigo-200 transition-all duration-500">
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
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Starting at') }}</p>
                                        <span class="text-sm font-black text-indigo-600">₱{{ number_format((float) $house->rooms->min('monthly_rate'), 0) }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-1 flex-col gap-4 p-8">
                            <div class="flex-1">
                                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $house->title }}</h3>
                                    <p class="mt-2 flex items-start gap-2 text-sm text-slate-500">
                                        <svg class="h-5 w-5 shrink-0 text-indigo-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        <span class="line-clamp-2 leading-relaxed">{{ $house->full_address }}</span>
                                    </p>
                                    <div class="mt-4 text-xs font-bold text-emerald-600 uppercase tracking-widest flex items-center gap-2">
    
                                    <!-- Icon -->
                                    <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>

                                    <!-- Text -->
                                    <span>
                                        {{ trans_choice(':count room available|:count rooms available', $house->availableRoomsCount(), ['count' => $house->availableRoomsCount()]) }}
                                    </span>

                             </div>
                                </div>

                            @if ($house->amenities->isNotEmpty())
                                <div class="flex flex-wrap gap-2 py-2 border-t border-slate-100">
                                    @foreach($house->amenities->take(4) as $amenity)
                                        <span class="inline-flex rounded-lg bg-slate-50 px-2 py-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider border border-slate-100">
                                            {{ $amenity->name }}
                                        </span>
                                    @endforeach
                                    @if($house->amenities->count() > 4)
                                        <span class="text-[10px] font-bold text-slate-400">+{{ $house->amenities->count() - 4 }}</span>
                                    @endif
                                </div>
                            @endif

                            <div class="mt-auto pt-6">
                                <a href="{{ route('boarding-houses.show', $house) }}" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-6 py-4 text-sm font-bold text-white shadow-xl shadow-slate-100 transition-all hover:bg-indigo-600 active:scale-95 group/btn">
                                    {{ __('View Details') }}
                                    <svg class="h-4 w-4 ml-2 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center rounded-3xl border-2 border-dashed border-slate-200 bg-white">
                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-50 text-slate-300 mb-6">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">{{ __('No results found') }}</h3>
                        <p class="mt-2 text-slate-500">{{ __('Try adjusting your filters or searching in a different area.') }}</p>
                    </div>
                @endforelse
            </div>

            @if ($boardingHouses->hasPages())
                <div class="pt-10">
                    {{ $boardingHouses->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .amenity-checkbox:checked + label span {
            @apply bg-indigo-600 text-white;
        }

        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: rgba(226, 232, 240, 0.5) transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(226, 232, 240, 0.5);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(226, 232, 240, 0.8);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const checkboxes = document.querySelectorAll('.amenity-checkbox');
            const submitBtn = filterForm.querySelector('button[type="submit"]');
            
            // Handle amenity checkbox changes - optional auto-submit
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Uncomment line below for auto-submit on amenity change
                    // filterForm.submit();
                });
            });

            // Handle budget range change - auto-submit
            const budgetRange = document.getElementById('budget_range');
            budgetRange?.addEventListener('change', function() {
                filterForm.submit();
            });

            // Handle form submission with AJAX
            async function updateResults() {
                const formData = new FormData(filterForm);
                const queryParams = new URLSearchParams(formData);
                
                const resultsContainer = document.querySelector('div.grid.gap-8.sm\\:grid-cols-2');
                if (resultsContainer) {
                    resultsContainer.classList.add('opacity-50', 'pointer-events-none');
                }

                try {
                    const response = await fetch(`{{ route('boarding-houses.index') }}?${queryParams.toString()}`, {
                        headers: {
                            'Accept': 'text/html',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (response.ok) {
                        const html = await response.text();
                        const parser = new DOMParser();
                        const newDoc = parser.parseFromString(html, 'text/html');
                        
                        const currentResults = document.querySelector('div.py-10.bg-slate-50\\/50.min-h-screen');
                        const newResults = newDoc.querySelector('div.py-10.bg-slate-50\\/50.min-h-screen');
                        
                        if (currentResults && newResults) {
                            const resultsWrapper = currentResults.querySelector('div.max-w-7xl');
                            const newResultsWrapper = newResults.querySelector('div.max-w-7xl');
                            
                            if (resultsWrapper && newResultsWrapper) {
                                // Preserve the filter form state
                                const oldForm = resultsWrapper.querySelector('#filterForm');
                                const newContent = newResultsWrapper.querySelector('.grid.gap-8.sm\\:grid-cols-2');
                                const newPagination = newResultsWrapper.querySelector('.pt-10');
                                
                                const gridContainer = resultsWrapper.querySelector('.grid.gap-8.sm\\:grid-cols-2');
                                const paginationContainer = resultsWrapper.querySelector('.pt-10');
                                
                                if (gridContainer && newContent) {
                                    gridContainer.outerHTML = newContent.outerHTML;
                                }
                                if (paginationContainer && newPagination) {
                                    paginationContainer.outerHTML = newPagination.outerHTML;
                                } else if (paginationContainer) {
                                    paginationContainer.remove();
                                } else if (newPagination) {
                                    resultsWrapper.appendChild(newPagination);
                                }
                            }
                        }
                        
                        window.history.pushState({}, '', `{{ route('boarding-houses.index') }}?${queryParams.toString()}`);
                    }
                } catch (error) {
                    console.error('Filter error:', error);
                } finally {
                    if (resultsContainer) {
                        resultsContainer.classList.remove('opacity-50', 'pointer-events-none');
                    }
                }
            }

            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                updateResults();
            });

            budgetRange?.addEventListener('change', updateResults);
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateResults);
            });

            // Input delay for location search
            let timeout = null;
            document.getElementById('location').addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(updateResults, 500);
            });

            // Handle pagination link clicks with AJAX
            document.addEventListener('click', function(e) {
                const paginationLink = e.target.closest('a[href*="?page="]');
                if (paginationLink && paginationLink.origin === window.location.origin) {
                    e.preventDefault();
                    window.location.href = paginationLink.href; // Simplified for now
                }
            });
        });
    </script>
</x-app-layout>
