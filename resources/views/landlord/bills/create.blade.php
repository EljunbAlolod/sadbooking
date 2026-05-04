<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">{{ __('Billing Management') }}</p>
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">{{ __('Send Bill Notice') }}</h2>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">{{ __('Create and send utility or monthly fee notices to your active tenants.') }}</p>
            </div>
            <a href="{{ route('landlord.bills.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                {{ __('Back to billing') }}
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl">
                <div class="p-8 sm:p-10">
                    <form method="POST" action="{{ route('landlord.bills.store') }}" class="space-y-8">
                        @csrf
                        
                        <div class="grid gap-8 sm:grid-cols-2">
                            <!-- Tenant Selection -->
                            <div class="sm:col-span-2">
                                <label for="tenant_id" class="flex items-center gap-2 text-sm font-bold text-slate-900 mb-2">
                                    <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    {{ __('Target Tenant') }}
                                </label>
                                <select id="tenant_id" name="tenant_id" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-3 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all" required>
                                    <option value="">{{ __('Select an active tenant') }}</option>
                                    @foreach ($tenantOptions as $reservation)
                                        <option value="{{ $reservation->tenant_id }}" @selected(old('tenant_id') == $reservation->tenant_id)>
                                            {{ $reservation->tenant->name }} — {{ $reservation->room->boardingHouse->title }} / {{ __('Room') }} {{ $reservation->room->room_number }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('tenant_id')" class="mt-2" />
                            </div>

                            <!-- Room Selection -->
                            <div class="sm:col-span-2">
                                <label for="room_id" class="flex items-center gap-2 text-sm font-bold text-slate-900 mb-2">
                                    <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                    {{ __('Assign to Room') }}
                                </label>
                                <select id="room_id" name="room_id" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-3 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all" required>
                                    <option value="">{{ __('Verify target room') }}</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}" @selected(old('room_id') == $room->id)>
                                            {{ $room->boardingHouse->title }} — {{ $room->room_number }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                            </div>

                            <!-- Bill Type -->
                            <div>
                                <label for="bill_type" class="flex items-center gap-2 text-sm font-bold text-slate-900 mb-2">
                                    <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    {{ __('Category') }}
                                </label>
                                <select id="bill_type" name="bill_type" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-3 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all" required>
                                    @foreach (\App\Enums\UtilityBillType::cases() as $type)
                                        <option value="{{ $type->value }}" @selected(old('bill_type') === $type->value)>{{ $type->label() }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('bill_type')" class="mt-2" />
                            </div>

                            <!-- Amount -->
                            <div>
                                <label for="amount" class="flex items-center gap-2 text-sm font-bold text-slate-900 mb-2">
                                    <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ __('Billing Amount') }}
                                </label>
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-bold">₱</div>
                                    <input id="amount" name="amount" type="number" step="0.01" min="0" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 pl-8 py-3 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all" :value="old('amount')" required />
                                </div>
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <!-- Billing Month -->
                            <div>
                                <label for="billing_month" class="flex items-center gap-2 text-sm font-bold text-slate-900 mb-2">
                                    <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ __('Billing Period') }}
                                </label>
                                <input id="billing_month" name="billing_month" type="date" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-3 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all" :value="old('billing_month', now()->startOfMonth()->toDateString())" required />
                                <x-input-error :messages="$errors->get('billing_month')" class="mt-2" />
                            </div>

                            <!-- Due Date -->
                            <div>
                                <label for="due_date" class="flex items-center gap-2 text-sm font-bold text-slate-900 mb-2">
                                    <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ __('Due Date') }}
                                </label>
                                <input id="due_date" name="due_date" type="date" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-3 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all" :value="old('due_date')" required />
                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-6">
                            <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-2xl bg-indigo-600 px-6 py-4 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition-all hover:bg-indigo-700 active:scale-95">
                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                {{ __('Create & Send Notice') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
