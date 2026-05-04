<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-indigo-600">{{ __('Billing') }}</p>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Bill notices') }}</h2>
            <p class="mt-1 text-sm text-slate-600">{{ __('Notices from your landlord for your room — monthly BH fees, electric, water, and more.') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead>
                            <tr class="bg-slate-50/80 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                <th class="px-6 py-3 sm:px-8">{{ __('Property') }}</th>
                                <th class="px-6 py-3">{{ __('Type') }}</th>
                                <th class="px-6 py-3">{{ __('Amount') }}</th>
                                <th class="px-6 py-3">{{ __('Billing month') }}</th>
                                <th class="px-6 py-3">{{ __('Due') }}</th>
                                <th class="px-6 py-3">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($billNotices as $bill)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-6 py-4 text-slate-900 sm:px-8">
                                        <div class="font-medium">{{ $bill->room->boardingHouse->title }}</div>
                                        <div class="text-xs text-slate-500">{{ __('Room') }} {{ $bill->room->room_number }}</div>
                                        @if (in_array($bill->id, $newBillIds, true))
                                            <span class="mt-1 inline-flex rounded-full bg-rose-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-rose-800">{{ __('New') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-700">{{ $bill->bill_type->label() }}</td>
                                    <td class="px-6 py-4 font-medium text-slate-900">{{ number_format((float) $bill->amount, 2) }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $bill->billing_month->format('M Y') }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $bill->due_date->format('M j, Y') }}</td>
                                    <td class="px-6 py-4 capitalize text-slate-700">{{ $bill->status->value }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-600 sm:px-8">{{ __('No bill notices yet.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($billNotices->hasPages())
                    <div class="border-t border-slate-100 px-6 py-4">{{ $billNotices->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
