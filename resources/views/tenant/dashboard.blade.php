<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-indigo-600">{{ __('Welcome back') }}</p>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Tenant dashboard') }}</h2>
            <p class="mt-1 text-sm text-slate-600">{{ __('Recommended stays, reservations, and billing notices.') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2">
                <a href="{{ route('tenant.reservations.index') }}" class="group rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:border-indigo-200 hover:shadow-md">
                    <h3 class="text-lg font-semibold text-slate-900">{{ __('My reservations') }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ __('View details, update pending requests, or cancel.') }}</p>
                    <span class="mt-4 inline-flex text-sm font-medium text-indigo-600 group-hover:text-indigo-500">{{ __('Open reservations') }} →</span>
                </a>
                <a href="{{ route('tenant.bill-notices.index') }}" class="group relative rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition hover:border-indigo-200 hover:shadow-md">
                    @if ($unseenBillNoticeCount > 0)
                        <span class="absolute right-4 top-4 inline-flex min-h-[1.5rem] min-w-[1.5rem] items-center justify-center rounded-full bg-rose-500 px-2 text-xs font-bold text-white">{{ $unseenBillNoticeCount > 99 ? '99+' : $unseenBillNoticeCount }}</span>
                    @endif
                    <h3 class="text-lg font-semibold text-slate-900">{{ __('Bill notices') }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ __('Monthly BH fees, electric, water, and payment status from your landlord.') }}</p>
                    <span class="mt-4 inline-flex text-sm font-medium text-indigo-600 group-hover:text-indigo-500">{{ __('View notices') }} →</span>
                </a>
            </div>

            <section class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">{{ __('Recommended for you') }}</h3>
                        <p class="text-sm text-slate-600">{{ __('Boarding houses with available rooms.') }}</p>
                    </div>
                    <a href="{{ route('boarding-houses.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ __('Browse all') }} →</a>
                </div>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($recommendedBoardingHouses as $house)
                        <article class="group flex flex-col overflow-hidden rounded-xl border border-slate-100 bg-slate-50/50 transition hover:border-indigo-200 hover:shadow-md">
                            <div class="relative aspect-[16/10] overflow-hidden bg-slate-200">
                                @if ($house->photoUrl())
                                    <img src="{{ $house->photoUrl() }}" alt="" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-sm text-slate-500">{{ __('No photo') }}</div>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col gap-2 p-4">
                                <h4 class="font-semibold text-slate-900">{{ $house->title }}</h4>
                                <p class="line-clamp-2 text-sm text-slate-600">{{ $house->full_address }}</p>
                                @if ($house->rooms->isNotEmpty())
                                    <p class="text-sm text-slate-800">
                                        {{ __('From') }}
                                        <span class="font-semibold">{{ number_format((float) $house->rooms->min('monthly_rate'), 2) }}</span>
                                        / {{ __('mo') }}
                                    </p>
                                @endif
                                @if ($house->amenities->isNotEmpty())
                                    <p class="text-xs text-slate-500">{{ $house->amenities->pluck('name')->take(3)->join(', ') }}{{ $house->amenities->count() > 3 ? '…' : '' }}</p>
                                @endif
                                <a href="{{ route('boarding-houses.show', $house) }}" class="mt-auto inline-flex text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ __('View & reserve') }}</a>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-slate-600 sm:col-span-3">{{ __('No listings match yet. Try browsing all boarding houses.') }}</p>
                    @endforelse
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
                <h3 class="text-lg font-semibold text-slate-900">{{ __('Current stay') }}</h3>
                @if ($currentStay)
                    <dl class="mt-4 grid gap-3 text-sm text-slate-700 sm:grid-cols-2">
                        <div><span class="font-medium text-slate-900">{{ __('Boarding house') }}:</span> {{ $currentStay->room->boardingHouse->title }}</div>
                        <div><span class="font-medium text-slate-900">{{ __('Room') }}:</span> {{ $currentStay->room->room_number }}</div>
                        <div class="sm:col-span-2"><span class="font-medium text-slate-900">{{ __('Address') }}:</span> {{ $currentStay->room->boardingHouse->full_address }}</div>
                        <div>
                            <span class="font-medium text-slate-900">{{ __('Stay') }}:</span> 
                            {{ $currentStay->start_date->format('M j, Y') }} – 
                            @if($currentStay->end_date)
                                {{ $currentStay->end_date->format('M j, Y') }}
                            @else
                                <span class="italic text-slate-500">{{ __('Ongoing') }}</span>
                            @endif
                        </div>
                        <div><span class="font-medium text-slate-900">{{ __('Status') }}:</span> {{ ucfirst($currentStay->status->value) }}</div>
                    </dl>
                @else
                    <p class="mt-2 text-slate-600">{{ __('You do not have an active stay in this period.') }}</p>
                    <a href="{{ route('boarding-houses.index') }}" class="mt-4 inline-flex text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ __('Browse boarding houses') }}</a>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
