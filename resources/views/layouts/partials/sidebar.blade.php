@php
    $navBase = 'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition';
    $navInactive = 'text-slate-600 hover:bg-white/80 hover:text-slate-900';
    $navActive = 'bg-white text-indigo-700 shadow-sm ring-1 ring-slate-200/80';
@endphp

<div class="flex h-full min-h-0 flex-1 flex-col">
    <div class="flex items-center gap-2 px-3 py-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-semibold tracking-tight text-slate-900">
            <span
                class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-sm text-white shadow-sm">{{ strtoupper(\Illuminate\Support\Str::substr(config('app.name', 'S'), 0, 1)) }}</span>
            <span class="leading-tight">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </div>

    <nav class="flex flex-1 flex-col space-y-1 overflow-y-auto px-3 pb-4" aria-label="{{ __('Main navigation') }}">
        <a href="{{ route('dashboard') }}"
            class="{{ $navBase }} {{ request()->routeIs('dashboard') ? $navActive : $navInactive }}">
            <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            {{ __('Dashboard') }}
        </a>

        @auth
            @if (auth()->user()->isTenant())
                <a href="{{ route('boarding-houses.index') }}"
                    class="{{ $navBase }} {{ request()->routeIs('boarding-houses.*') ? $navActive : $navInactive }}">
                    <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    {{ __('Browse stays') }}
                </a>
            @endif
        @endauth

        @auth
            @if (auth()->user()->isTenant())
                <a href="{{ route('tenant.dashboard') }}"
                    class="{{ $navBase }} {{ request()->routeIs('tenant.dashboard') ? $navActive : $navInactive }}">
                    <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    {{ __('Tenant home') }}
                </a>
                <a href="{{ route('tenant.reservations.index') }}"
                    class="{{ $navBase }} {{ request()->routeIs('tenant.reservations.*') ? $navActive : $navInactive }}">
                    <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                    </svg>
                    {{ __('Reservations') }}
                </a>
                <a href="{{ route('tenant.bill-notices.index') }}"
                    class="{{ $navBase }} {{ request()->routeIs('tenant.bill-notices.*') ? $navActive : $navInactive }} relative">
                    <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="flex-1 text-left">{{ __('Bill notices') }}</span>
                    @if (($tenantUnseenBillCount ?? 0) > 0)
                        <span
                            class="inline-flex min-w-[1.25rem] items-center justify-center rounded-full bg-rose-500 px-1.5 py-0.5 text-[10px] font-bold leading-none text-white"
                            aria-label="{{ __('New bills') }}">{{ $tenantUnseenBillCount > 99 ? '99+' : $tenantUnseenBillCount }}</span>
                    @endif
                </a>
            @endif

            @if (auth()->user()->isLandlord())
                <a href="{{ route('landlord.dashboard') }}"
                    class="{{ $navBase }} {{ request()->routeIs('landlord.dashboard') ? $navActive : $navInactive }}">
                    <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                    </svg>
                    {{ __('Landlord overview') }}
                </a>
                <a href="{{ route('landlord.boarding-houses.index') }}"
                    class="{{ $navBase }} {{ request()->routeIs('landlord.boarding-houses.*') ? $navActive : $navInactive }}">
                    <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008H17.25v-.008zm0 3.75h.008v.008H17.25v-.008zm0 3.75h.008v.008H17.25v-.008z" />
                    </svg>
                    {{ __('My boarding houses') }}
                </a>
                <a href="{{ route('landlord.reservations.index') }}"
                    class="{{ $navBase }} {{ request()->routeIs('landlord.reservations.*') ? $navActive : $navInactive }}">
                    <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                    </svg>
                    {{ __('Reservations') }}
                </a>
                <a href="{{ route('landlord.tenants.index') }}"
                    class="{{ $navBase }} {{ request()->routeIs('landlord.tenants.*') ? $navActive : $navInactive }}">
                    <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    {{ __('Tenants') }}
                </a>
                <a href="{{ route('landlord.bills.index') }}"
                    class="{{ $navBase }} {{ request()->routeIs('landlord.bills.*') ? $navActive : $navInactive }}">
                    <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                    {{ __('Billing notices') }}
                </a>
            @endif

            @if (auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ $navBase }} {{ request()->routeIs('admin.*') ? $navActive : $navInactive }}">
                    <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ __('Admin') }}
                </a>
            @endif
        @endauth


    </nav>
    @auth
        <div class="mt-auto border-t border-slate-200/80 pt-3 pl-3 pb-2">

            <a href="{{ route('profile.show') }}"
                class="{{ $navBase }} {{ request()->routeIs('profile.show') ? $navActive : $navInactive }}">
                <svg class="h-5 w-5 shrink-0 text-slate-400 group-[.bg-white]:text-indigo-600" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ __('Profile') }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full {{ $navBase }} {{ $navInactive }}">
                    <svg class="h-5 w-5 shrink-0 text-slate-400 group-hover:text-slate-900" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    @endauth
</div>