<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-indigo-600">{{ __('Billing') }}</p>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Send bill notice') }}</h2>
            <p class="mt-1 text-sm text-slate-600">{{ __('Include monthly boarding house fees or utility charges.') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                <form method="POST" action="{{ route('landlord.bills.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="tenant_id" :value="__('Tenant')" />
                        <select id="tenant_id" name="tenant_id" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">{{ __('Select tenant') }}</option>
                            @foreach ($tenantOptions as $reservation)
                                <option value="{{ $reservation->tenant_id }}" @selected(old('tenant_id') == $reservation->tenant_id)>
                                    {{ $reservation->tenant->name }} — {{ $reservation->room->boardingHouse->title }} / {{ __('Room') }} {{ $reservation->room->room_number }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('tenant_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="room_id" :value="__('Room')" />
                        <select id="room_id" name="room_id" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">{{ __('Select room') }}</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" @selected(old('room_id') == $room->id)>
                                    {{ $room->boardingHouse->title }} — {{ $room->room_number }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="bill_type" :value="__('Bill type')" />
                        <select id="bill_type" name="bill_type" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @foreach (\App\Enums\UtilityBillType::cases() as $type)
                                <option value="{{ $type->value }}" @selected(old('bill_type') === $type->value)>{{ $type->label() }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('bill_type')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="amount" :value="__('Amount')" />
                        <x-text-input id="amount" name="amount" type="number" step="0.01" min="0" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm" :value="old('amount')" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="billing_month" :value="__('Billing month (first day)')" />
                        <x-text-input id="billing_month" name="billing_month" type="date" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm" :value="old('billing_month', now()->startOfMonth()->toDateString())" required />
                        <x-input-error :messages="$errors->get('billing_month')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="due_date" :value="__('Due date')" />
                        <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm" :value="old('due_date')" required />
                        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                    </div>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <x-primary-button class="rounded-xl">{{ __('Save notice') }}</x-primary-button>
                        <a href="{{ route('landlord.bills.index') }}" class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
