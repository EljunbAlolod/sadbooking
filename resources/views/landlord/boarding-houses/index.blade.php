<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">{{ __('Boarding Hub') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ __('My Boarding Houses') }}</h2>
            </div>
            <a href="{{ route('landlord.boarding-houses.create') }}">
                <x-primary-button type="button"
                    class="rounded-2xl px-6 py-3 bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all active:scale-95">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Add New Property') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($boardingHouses as $house)
                    <div
                        class="group relative flex flex-col overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300">
                        <!-- Property Image -->
                        <div class="relative h-56 w-full overflow-hidden bg-slate-100">
                            @if ($house->photoUrl())
                                <img src="{{ $house->photoUrl() }}" alt="{{ $house->title }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="flex h-full w-full flex-col items-center justify-center text-slate-400">
                                    <svg class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs font-medium uppercase">{{ __('No photo available') }}</span>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                            <div
                                class="absolute bottom-4 left-4 right-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                <a href="{{ route('landlord.boarding-houses.show', $house) }}"
                                    class="inline-flex w-full items-center justify-center rounded-xl bg-white/95 px-4 py-2 text-sm font-bold text-slate-900 backdrop-blur-md hover:bg-white transition-colors shadow-lg">
                                    {{ __('View Property') }}
                                </a>
                            </div>
                        </div>

                        <!-- Property Content -->
                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex-1">
                                <h3
                                    class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-1">
                                    {{ $house->title }}
                                </h3>
                                <p class="mt-2 flex items-start gap-1.5 text-sm text-slate-600">
                                    <svg class="h-4 w-4 shrink-0 text-slate-400 mt-0.5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="line-clamp-2">{{ $house->full_address }}</span>
                                </p>

                                <div class="mt-4 flex items-center gap-4 border-t border-slate-100 pt-4">
                                    <div class="flex items-center gap-1.5 text-sm font-medium text-slate-700">
                                        <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        {{ trans_choice('{0} No Rooms|{1} 1 Room|[2,*] :count Rooms', $house->rooms_count, ['count' => $house->rooms_count]) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-6 flex items-center gap-2 border-t border-slate-100 pt-6">
                                <a href="{{ route('landlord.boarding-houses.rooms.index', $house) }}"
                                    class="flex flex-1 items-center justify-center gap-1.5 rounded-xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white hover:bg-indigo-700 transition-all active:scale-95 shadow-sm shadow-indigo-100">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    {{ __('Rooms') }}
                                </a>
                                <a href="{{ route('landlord.boarding-houses.edit', $house) }}"
                                    class="flex flex-1 items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all active:scale-95 shadow-sm">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    {{ __('Edit') }}
                                </a>
                                <form method="POST" action="{{ route('landlord.boarding-houses.destroy', $house) }}"
                                    onsubmit="return confirm('{{ __('Are you sure you want to delete this property and all associated rooms?') }}');"
                                    class="flex shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center rounded-xl border border-rose-100 bg-rose-50 p-2 text-rose-600 hover:bg-rose-100 hover:text-rose-700 transition-all active:scale-90 shadow-sm"
                                        title="{{ __('Delete Property') }}">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full rounded-3xl border-2 border-dashed border-slate-200 bg-white p-16 text-center shadow-sm">
                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50 text-slate-400">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-bold text-slate-900">{{ __('No boarding houses found') }}</h3>
                        <p class="mt-2 text-slate-500">
                            {{ __('Create your first property listing to start managing your rooms and tenants.') }}</p>
                        <div class="mt-8">
                            <a href="{{ route('landlord.boarding-houses.create') }}"
                                class="inline-flex items-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-100 transition-all hover:bg-indigo-700 active:scale-95">
                                {{ __('Create My First Listing') }}
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>