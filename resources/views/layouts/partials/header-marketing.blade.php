<header class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="flex items-center gap-2 font-semibold tracking-tight text-slate-900">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-xs text-white">{{ strtoupper(\Illuminate\Support\Str::substr(config('app.name', 'S'), 0, 1)) }}</span>
            {{ config('app.name') }}
        </a>
        <nav class="flex items-center gap-4 text-sm font-medium">
            <a href="{{ route('boarding-houses.index') }}" class="text-slate-600 hover:text-slate-900">{{ __('Browse') }}</a>
            @auth
                <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-slate-900">{{ __('Dashboard') }}</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-slate-600 hover:text-slate-900">{{ __('Log out') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-slate-600 hover:text-slate-900">{{ __('Log in') }}</a>
                <a href="{{ route('register') }}" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-white shadow-sm hover:bg-indigo-500">{{ __('Register') }}</a>
            @endauth
        </nav>
    </div>
</header>
