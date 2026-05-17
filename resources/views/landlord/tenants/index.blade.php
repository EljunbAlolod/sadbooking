<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-pink-600 uppercase tracking-wider">{{ __('Boarding Hub') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ __('Current Tenants') }}</h2>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">{{ __('Manage your active tenants, their stay periods, and property assignments.') }}</p>
            </div>
            <div class="hidden sm:block">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-50 text-pink-600 shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr class="bg-slate-50/80 text-left text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                <th class="px-8 py-5 sm:px-10">{{ __('Tenant Information') }}</th>
                                <th class="px-6 py-5">{{ __('Property & Room') }}</th>
                                <th class="px-6 py-5">{{ __('Stay Period') }}</th>
                                <th class="px-6 py-5">{{ __('Status') }}</th>
                                <th class="px-6 py-5"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($reservations as $reservation)
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-6 sm:px-10">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 group-hover:bg-pink-100 group-hover:text-pink-600 transition-colors">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-900">{{ $reservation->tenant->name }}</div>
                                                <div class="mt-0.5 text-xs font-medium text-slate-500">{{ $reservation->tenant->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="space-y-1">
                                            <div class="text-sm font-bold text-slate-700">{{ $reservation->room->boardingHouse->title }}</div>
                                            <div class="inline-flex items-center gap-1.5 rounded-lg bg-pink-50 px-2 py-0.5 text-[10px] font-bold text-pink-600 border border-pink-100">
                                                {{ __('Room') }} {{ $reservation->room->room_number }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="space-y-1">
                                            <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                {{ $reservation->start_date->format('M d, Y') }}
                                            </div>
                                            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                @if($reservation->end_date)
                                                    {{ __('Ends') }} {{ $reservation->end_date->format('M d, Y') }}
                                                @else
                                                    <span class="text-emerald-600 uppercase tracking-widest text-[9px]">{{ __('Ongoing Stay') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span @class([
                                            'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest shadow-sm border',
                                            'bg-pink-50 text-pink-700 border-pink-100' => $reservation->status->value === 'active',
                                            'bg-emerald-50 text-emerald-700 border-emerald-100' => $reservation->status->value === 'approved',
                                            'bg-slate-50 text-slate-600 border-slate-100' => !in_array($reservation->status->value, ['active', 'approved']),
                                        ])>
                                            <span @class([
                                                'h-1.5 w-1.5 rounded-full',
                                                'bg-pink-500' => $reservation->status->value === 'active',
                                                'bg-emerald-500' => $reservation->status->value === 'approved',
                                                'bg-slate-400' => !in_array($reservation->status->value, ['active', 'approved']),
                                            ])></span>
                                            {{ $reservation->status->value }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-end sm:px-10">
                                        <form action="{{ route('landlord.tenants.remove', $reservation) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to remove this tenant? This will mark their stay as completed.') }}')" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-pink-600 px-4 py-2 text-xs font-bold text-white hover:bg-pink-700 transition-all active:scale-95 shadow-lg shadow-pink-100">
                                                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                                {{ __('Evict/Remove') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50 text-slate-300">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                        </div>
                                        <h3 class="mt-4 text-sm font-bold text-slate-900">{{ __('No active boarders') }}</h3>
                                        <p class="mt-1 text-xs text-slate-500">{{ __('When tenants move into your properties, they will appear here.') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
