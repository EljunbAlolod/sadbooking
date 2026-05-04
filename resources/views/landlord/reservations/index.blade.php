<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pending reservation requests') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Tenant') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Property / room') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Dates') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($reservations as $reservation)
                            <tr>
                                <td class="px-6 py-3">{{ $reservation->tenant->name }}<br><span class="text-gray-500">{{ $reservation->tenant->email }}</span></td>
                                <td class="px-6 py-3">{{ $reservation->room->boardingHouse->title }} — {{ __('Room') }} {{ $reservation->room->room_number }}</td>
                                <td class="px-6 py-3">
                                    {{ $reservation->start_date->format('M j, Y') }} – 
                                    @if($reservation->end_date)
                                        {{ $reservation->end_date->format('M j, Y') }}
                                    @else
                                        <span class="italic text-slate-400">{{ __('Ongoing') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 space-x-2">
                                    <form method="POST" action="{{ route('landlord.reservations.approve', $reservation) }}" class="inline">
                                        @csrf
                                        <x-primary-button type="submit">{{ __('Approve') }}</x-primary-button>
                                    </form>
                                    <form method="POST" action="{{ route('landlord.reservations.reject', $reservation) }}" class="inline">
                                        @csrf
                                        <x-secondary-button type="submit">{{ __('Reject') }}</x-secondary-button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-gray-600">{{ __('No pending requests.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $reservations->links() }}</div>
        </div>
    </div>
</x-app-layout>
