<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">{{ __('Landlord Dashboard') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ __('Billing Management') }}</h2>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">{{ __('Issue and track monthly BH fees, electric, water, and other utility charges for your tenants.') }}</p>
            </div>
            <a href="{{ route('landlord.bills.create') }}">
                <x-primary-button type="button" class="rounded-2xl px-6 py-3 bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all active:scale-95">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    {{ __('Issue New Bill') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead>
                            <tr class="bg-slate-50/80 text-left text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                <th class="px-8 py-5 sm:px-10">{{ __('Tenant & Property') }}</th>
                                <th class="px-6 py-5">{{ __('Bill Type') }}</th>
                                <th class="px-6 py-5">{{ __('Amount') }}</th>
                                <th class="px-6 py-5">{{ __('Due Date') }}</th>
                                <th class="px-6 py-5">{{ __('Status') }}</th>
                                <th class="px-6 py-5"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($bills as $bill)
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-6 sm:px-10">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-900">{{ $bill->tenant->name }}</div>
                                                <div class="mt-0.5 text-xs font-medium text-slate-500">{{ $bill->room->boardingHouse->title }} — {{ __('Room') }} {{ $bill->room->room_number }}</div>
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
                                        <div class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                                            <svg @class([
                                                'h-4 w-4',
                                                'text-rose-500 animate-pulse' => $bill->status === \App\Enums\UtilityBillStatus::Unpaid && $bill->due_date->isPast(),
                                                'text-slate-400' => !($bill->status === \App\Enums\UtilityBillStatus::Unpaid && $bill->due_date->isPast()),
                                            ]) fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $bill->due_date->format('M d, Y') }}
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
                                    <td class="px-8 py-6 text-end sm:px-10">
                                        @if ($bill->status === \App\Enums\UtilityBillStatus::Unpaid)
                                            <form method="POST" action="{{ route('landlord.bills.paid', $bill) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white hover:bg-indigo-700 transition-all active:scale-95 shadow-lg shadow-indigo-100">
                                                    {{ __('Mark Paid') }}
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-20 text-center">
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50 text-slate-300">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        </div>
                                        <h3 class="mt-4 text-sm font-bold text-slate-900">{{ __('No billing notices issued') }}</h3>
                                        <p class="mt-1 text-xs text-slate-500">{{ __('Start by issuing a new bill notice to your tenants.') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($bills->hasPages())
                    <div class="bg-slate-50/50 border-t border-slate-100 px-8 py-5 sm:px-10">{{ $bills->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
