<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">{{ __('Listings') }}</p>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Boarding houses') }}</h2>
            </div>
            <a href="{{ route('landlord.boarding-houses.create') }}">
                <x-primary-button type="button" class="rounded-xl">{{ __('Add boarding house') }}</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-4 px-4 sm:px-6 lg:px-8">
            @forelse ($boardingHouses as $house)
                <div class="flex flex-col gap-4 overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:p-6">
                    <div class="flex min-w-0 flex-1 gap-4">
                        <div class="relative h-24 w-32 shrink-0 overflow-hidden rounded-xl bg-slate-200 sm:h-28 sm:w-40">
                            @if ($house->photoUrl())
                                <img src="{{ $house->photoUrl() }}" alt="" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-xs text-slate-500">{{ __('No photo') }}</div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-lg font-semibold text-slate-900">{{ $house->title }}</h3>
                            <p class="text-sm text-slate-600">{{ $house->full_address }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ __('Rooms') }}: {{ $house->rooms_count }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 text-sm">
                        <a href="{{ route('landlord.boarding-houses.show', $house) }}" class="font-medium text-indigo-600 hover:text-indigo-500">{{ __('View') }}</a>
                        <a href="{{ route('landlord.boarding-houses.rooms.index', $house) }}" class="font-medium text-slate-600 hover:text-slate-900">{{ __('Rooms') }}</a>
                        <a href="{{ route('landlord.boarding-houses.edit', $house) }}" class="font-medium text-slate-600 hover:text-slate-900">{{ __('Edit') }}</a>
                        <form method="POST" action="{{ route('landlord.boarding-houses.destroy', $house) }}" onsubmit="return confirm('{{ __('Delete this boarding house?') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600 hover:text-red-500">{{ __('Delete') }}</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-200 bg-white p-10 text-center text-slate-600">
                    {{ __('You have not created any boarding houses yet.') }}
                    <div class="mt-4">
                        <a href="{{ route('landlord.boarding-houses.create') }}" class="font-medium text-indigo-600 hover:text-indigo-500">{{ __('Create your first listing') }}</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
