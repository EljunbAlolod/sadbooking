@php
    $navBase = 'group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200';
    $navInactive = 'text-slate-500 hover:bg-white hover:text-pink-600 hover:shadow-sm hover:ring-1 hover:ring-slate-200/60';
    $navActive = 'bg-white text-pink-600 shadow-md shadow-pink-100/50 ring-1 ring-slate-200/80';
    $iconInactive = 'h-5 w-5 shrink-0 text-slate-400 group-hover:text-pink-500 transition-colors';
    $iconActive = 'h-5 w-5 shrink-0 text-pink-600';
@endphp

<div class="flex h-full min-h-0 flex-1 flex-col bg-slate-50/50">
    <!-- Brand / Logo -->
    <div class="flex items-center px-6 py-8">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-pink-600 text-white shadow-lg shadow-pink-200 transition-transform group-hover:scale-105 group-active:scale-95">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-lg font-black tracking-tight text-slate-900 leading-none uppercase">{{ config('app.name', 'Boarding Hub') }}</span>
                <span class="text-[10px] font-bold text-pink-600 uppercase tracking-widest mt-1">{{ __('Quality Stay') }}</span>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex flex-1 flex-col gap-6 overflow-y-auto px-4 pb-6 custom-scrollbar" aria-label="{{ __('Main navigation') }}">
        
        @auth
            <!-- 1. Tenant Hub: Links accessible only to registered tenants -->
            @if (auth()->user()->isTenant())
                <div class="space-y-1">
                    <p class="px-4 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">{{ __('Tenant Hub') }}</p>
                    <a href="{{ route('tenant.dashboard') }}"
                        class="{{ $navBase }} {{ request()->routeIs('tenant.dashboard') ? $navActive : $navInactive }}">
                        <svg class="{{ request()->routeIs('tenant.dashboard') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        {{ __('Dashboard') }}
                    </a>
                     <a href="{{ route('boarding-houses.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('boarding-houses.*') ? $navActive : $navInactive }}">
                        <svg class="{{ request()->routeIs('boarding-houses.*') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        {{ __('Browse Boarding House') }}
                    </a>
                    <a href="{{ route('tenant.reservations.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('tenant.reservations.*') ? $navActive : $navInactive }}">
                        <svg class="{{ request()->routeIs('tenant.reservations.*') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ __('My Reservations') }}
                    </a>
                    <a href="{{ route('tenant.bill-notices.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('tenant.bill-notices.*') ? $navActive : $navInactive }} relative">
                        <svg class="{{ request()->routeIs('tenant.bill-notices.*') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="flex-1">{{ __('Billing') }}</span>
                        @if (($tenantUnseenBillCount ?? 0) > 0)
                            <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-[10px] font-black text-white shadow-lg shadow-rose-200">
                                {{ $tenantUnseenBillCount > 9 ? '9+' : $tenantUnseenBillCount }}
                            </span>
                        @endif
                    </a>
                </div>
            @endif

            <!-- 2. Landlord Hub: Management tools for property owners -->
            @if (auth()->user()->isLandlord())
                <div class="space-y-1">
                    <p class="px-4 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">{{ __('Management') }}</p>
                    <a href="{{ route('landlord.dashboard') }}"
                        class="{{ $navBase }} {{ request()->routeIs('landlord.dashboard') ? $navActive : $navInactive }}">
                        <svg class="{{ request()->routeIs('landlord.dashboard') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('landlord.boarding-houses.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('landlord.boarding-houses.*') ? $navActive : $navInactive }}">
                        <svg class="{{ request()->routeIs('landlord.boarding-houses.*') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        {{ __('My Boarding Houses') }}
                    </a>
                    <a href="{{ route('landlord.reservations.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('landlord.reservations.*') ? $navActive : $navInactive }}">
                        <svg class="{{ request()->routeIs('landlord.reservations.*') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ __('Reservations') }}
                    </a>
                    <a href="{{ route('landlord.tenants.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('landlord.tenants.*') ? $navActive : $navInactive }}">
                        <svg class="{{ request()->routeIs('landlord.tenants.*') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ __('Active Tenants') }}
                    </a>
                    <a href="{{ route('landlord.bills.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('landlord.bills.*') ? $navActive : $navInactive }}">
                        <svg class="{{ request()->routeIs('landlord.bills.*') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        {{ __('Billing Notices') }}
                    </a>
                </div>
            @endif

            <!-- 3. Admin Hub: System-wide administration for Super Admins -->
            @if (auth()->user()->isSuperAdmin())
                <div class="space-y-1">
                    <p class="px-4 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">{{ __('Administration') }}</p>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ $navBase }} {{ request()->routeIs('admin.dashboard') ? $navActive : $navInactive }}">
                        <svg class="{{ request()->routeIs('admin.dashboard') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        {{ __('Overview') }}
                    </a>
                    <a href="{{ route('admin.landlords.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('admin.landlords.*') ? $navActive : $navInactive }}">
                        <svg class="{{ request()->routeIs('admin.landlords.*') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ __('Landlords') }}
                    </a>
                    <a href="{{ route('admin.tenants.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('admin.tenants.*') ? $navActive : $navInactive }}">
                        <svg class="{{ request()->routeIs('admin.tenants.*') ? $iconActive : $iconInactive }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('Tenants') }}
                    </a>
                </div>
            @endif
        @endauth

    </nav>

    <!-- User Profile & Footer Area -->
    @auth
        <div class="mt-auto border-t border-slate-200/80 p-4">
            <div class="flex flex-col gap-2">
                <!-- User Profile Link -->
                <a href="{{ route('profile.show') }}"
                    class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-bold transition-all hover:bg-white hover:shadow-sm hover:ring-1 hover:ring-slate-200/60 {{ request()->routeIs('profile.show') ? 'bg-white text-pink-600 shadow-sm ring-1 ring-slate-200/80' : 'text-slate-700' }}">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500 {{ request()->routeIs('profile.show') ? 'bg-pink-50 text-pink-600' : '' }}">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="truncate leading-none">{{ auth()->user()->name }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 truncate">{{ auth()->user()->role->label() }}</span>
                    </div>
                </a>
                
                <!-- Logout Action -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="group flex w-full items-center gap-3 rounded-2xl px-3 py-3 text-sm font-bold text-slate-500 transition-all hover:bg-rose-50 hover:text-rose-600">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-50 text-slate-400 group-hover:bg-rose-100 group-hover:text-rose-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>
    @endauth
</div>
