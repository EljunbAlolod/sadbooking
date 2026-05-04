<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Platform overview') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Super admins') }}</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $userCounts['super_admin'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Landlords') }}</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $userCounts['landlord'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Tenants') }}</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $userCounts['tenant'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Boarding houses') }}</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $boardingHouseCount }}</p>
                </div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-500">{{ __('Approved / active reservations') }}</p>
                <p class="text-3xl font-semibold text-gray-900">{{ $activeReservationCount }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
