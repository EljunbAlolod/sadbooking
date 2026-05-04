<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Current tenants') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Tenant') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Boarding house') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Room') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Stay') }}</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-6 py-3 text-right font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($reservations as $reservation)
                            <tr>
                                <td class="px-6 py-3">{{ $reservation->tenant->name }}</td>
                                <td class="px-6 py-3">{{ $reservation->tenant->email }}</td>
                                <td class="px-6 py-3">{{ $reservation->room->boardingHouse->title }}</td>
                                <td class="px-6 py-3">{{ $reservation->room->room_number }}</td>
                                <td class="px-6 py-3">
                                    {{ $reservation->start_date->format('M j, Y') }} – 
                                    @if($reservation->end_date)
                                        {{ $reservation->end_date->format('M j, Y') }}
                                    @else
                                        <span class="italic text-slate-400">{{ __('Ongoing') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 capitalize">{{ $reservation->status->value }}</td>
                                <td class="px-6 py-3 text-right">
                                    <form action="{{ route('landlord.tenants.remove', $reservation) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to remove this tenant? This will mark their stay as completed.') }}')">
                                        @csrf
                                        <button type="submit" class="text-rose-600 hover:text-rose-900 font-semibold text-xs uppercase tracking-wider">
                                            {{ __('Remove') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-6 text-gray-600">{{ __('No active boarders in your properties for this period.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
