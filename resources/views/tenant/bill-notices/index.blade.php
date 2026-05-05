<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">{{ __('Boarding Hub') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ __('Bill Notices') }}</h2>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">{{ __('Track your monthly boarding house fees, electric, water, and other utilities issued by your landlord.') }}</p>
            </div>
            <div class="hidden sm:block">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-sm">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2-2V19a2 2 0 002 2z" /></svg>
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
                                <th class="px-8 py-5">{{ __('Property & Room') }}</th>
                                <th class="px-6 py-5">{{ __('Bill Details') }}</th>
                                <th class="px-6 py-5">{{ __('Amount') }}</th>
                                <th class="px-6 py-5">{{ __('Timeline') }}</th>
                                <th class="px-6 py-5">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($billNotices as $bill)
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-900">{{ $bill->room->boardingHouse->title }}</div>
                                                <div class="mt-0.5 text-xs font-medium text-slate-500">{{ __('Room') }} {{ $bill->room->room_number }}</div>
                                                @if (in_array($bill->id, $newBillIds, true))
                                                    <span class="mt-1.5 inline-flex rounded-lg bg-rose-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-rose-600 border border-rose-100 animate-pulse">{{ __('New Notice') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-2">
                                            <span @class([
                                                'inline-flex rounded-lg p-1.5',
                                                'bg-blue-50 text-blue-600' => $bill->bill_type->value === 'monthly_fee',
                                                'bg-amber-50 text-amber-600' => $bill->bill_type->value === 'electric',
                                                'bg-cyan-50 text-cyan-600' => $bill->bill_type->value === 'water',
                                                'bg-slate-50 text-slate-600' => !in_array($bill->bill_type->value, ['monthly_fee', 'electric', 'water']),
                                            ])>
                                                @if($bill->bill_type->value === 'electric')
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                                @elseif($bill->bill_type->value === 'water')
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                                @else
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                                @endif
                                            </span>
                                            <span class="text-sm font-semibold text-slate-700">{{ $bill->bill_type->label() }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="text-lg font-extrabold text-slate-900">₱{{ number_format((float) $bill->amount, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="space-y-1">
                                            <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                {{ $bill->billing_month->format('F Y') }}
                                            </div>
                                            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                {{ __('Due on') }} {{ $bill->due_date->format('M d') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span @class([
                                            'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest shadow-sm',
                                            'bg-emerald-50 text-emerald-700 border border-emerald-100' => $bill->status->value === 'paid',
                                            'bg-rose-50 text-rose-700 border border-rose-100' => $bill->status->value === 'unpaid',
                                            'bg-slate-50 text-slate-600 border border-slate-100' => !in_array($bill->status->value, ['paid', 'unpaid']),
                                        ])>
                                            <span @class([
                                                'h-1.5 w-1.5 rounded-full',
                                                'bg-emerald-500' => $bill->status->value === 'paid',
                                                'bg-rose-500' => $bill->status->value === 'unpaid',
                                                'bg-slate-400' => !in_array($bill->status->value, ['paid', 'unpaid']),
                                            ])></span>
                                            {{ $bill->status->value }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50 text-slate-300">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        </div>
                                        <h3 class="mt-4 text-sm font-bold text-slate-900">{{ __('No billing notices found') }}</h3>
                                        <p class="mt-1 text-xs text-slate-500">{{ __('Your landlord has not issued any bill notices yet.') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($billNotices->hasPages())
                    <div class="bg-slate-50/50 border-t border-slate-100 px-8 py-5">{{ $billNotices->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
