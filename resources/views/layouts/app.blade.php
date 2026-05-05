<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')
</head>

<body class="font-sans antialiased text-slate-900 overflow-hidden">
    <div x-data="{ sidebarOpen: false }" class="h-screen bg-gradient-to-br from-slate-50 via-white to-pink-50/40">
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false"></div>

        <div class="flex h-full">
            <aside
                class="fixed inset-y-0 left-0 z-50 flex w-64 -translate-x-full flex-col border-r border-slate-200/80 bg-slate-50/95 shadow-lg transition-transform duration-200 ease-out lg:static lg:z-auto lg:translate-x-0 lg:shadow-none"
                :class="{ 'translate-x-0': sidebarOpen }" aria-label="{{ __('Sidebar') }}">
                @include('layouts.partials.sidebar')
            </aside>

            <div class="flex min-w-0 flex-1 flex-col">
                @include('layouts.partials.header-app')

                @isset($header)
                    <header class="shrink-0 border-b border-slate-200/80 bg-white/80 backdrop-blur">
                        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <div class="flex-1 overflow-y-auto">
                    <main class="flex flex-col min-h-full">
                        @include('layouts.partials.flash')
                        <div class="flex-1">
                            {{ $slot }}
                        </div>
                        @include('layouts.partials.footer')
                    </main>
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
