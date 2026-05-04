<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Rooms for') }} {{ $boardingHouse->title }}</h2>
            <a href="{{ route('landlord.boarding-houses.rooms.create', $boardingHouse) }}">
                <x-primary-button type="button">{{ __('Add room') }}</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('landlord.boarding-houses.show', $boardingHouse) }}" class="text-sm text-indigo-600 underline">{{ __('Back to boarding house') }}</a>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Room #') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Capacity') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Occupants') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Monthly rate') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Amenities') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Pictures') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($boardingHouse->rooms as $room)
                            <tr>
                                <td class="px-6 py-3">{{ $room->room_number }}</td>
                                <td class="px-6 py-3">{{ $room->capacity }}</td>
                                <td class="px-6 py-3">{{ $room->current_occupants }}</td>
                                <td class="px-6 py-3">{{ number_format((float) $room->monthly_rate, 2) }}</td>
                                <td class="px-6 py-3 text-xs text-gray-600">{{ $room->amenities->pluck('name')->join(', ') ?: __('None') }}</td>
                                <td class="px-6 py-3">{{ $room->photos->count() }}</td>
                                <td class="px-6 py-3 capitalize">{{ $room->status->value }}</td>
                                <td class="px-6 py-3 text-right space-x-3">
                                    <a href="{{ route('landlord.boarding-houses.rooms.edit', [$boardingHouse, $room]) }}" class="text-indigo-600 underline">{{ __('Edit') }}</a>
                                    <form class="inline" method="POST" action="{{ route('landlord.boarding-houses.rooms.destroy', [$boardingHouse, $room]) }}" onsubmit="return confirm('{{ __('Delete this room?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 underline">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-6 text-gray-600">{{ __('No rooms yet. Add your first room.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
