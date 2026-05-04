<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">{{ __('Tenants') }}</p>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Billing notices') }}</h2>
                <p class="mt-1 text-sm text-slate-600">{{ __('Monthly BH fees, utilities, and other charges.') }}</p>
            </div>
            <a href="{{ route('landlord.bills.create') }}">
                <x-primary-button type="button" class="rounded-xl">{{ __('Create notice') }}</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead>
                            <tr class="bg-slate-50/80 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                <th class="px-6 py-3 sm:px-8">{{ __('Tenant') }}</th>
                                <th class="px-6 py-3">{{ __('Room') }}</th>
                                <th class="px-6 py-3">{{ __('Type') }}</th>
                                <th class="px-6 py-3">{{ __('Amount') }}</th>
                                <th class="px-6 py-3">{{ __('Due') }}</th>
                                <th class="px-6 py-3">{{ __('Status') }}</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($bills as $bill)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-6 py-4 text-slate-900 sm:px-8">{{ $bill->tenant->name }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ $bill->room->boardingHouse->title }} — {{ $bill->room->room_number }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ $bill->bill_type->label() }}</td>
                                    <td class="px-6 py-4 font-medium text-slate-900">{{ number_format((float) $bill->amount, 2) }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $bill->due_date->format('M j, Y') }}</td>
                                    <td class="px-6 py-4 capitalize text-slate-700">{{ $bill->status->value }}</td>
                                    <td class="px-6 py-4 text-end">
                                        @if ($bill->status === \App\Enums\UtilityBillStatus::Unpaid)
                                            <form method="POST" action="{{ route('landlord.bills.paid', $bill) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <x-secondary-button type="submit" class="rounded-xl">{{ __('Mark paid') }}</x-secondary-button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-slate-600 sm:px-8">{{ __('No billing notices yet.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($bills->hasPages())
                    <div class="border-t border-slate-100 px-6 py-4">{{ $bills->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
