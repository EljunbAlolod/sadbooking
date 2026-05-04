<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.head')
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-white to-indigo-50/30 text-slate-900">
        <div class="flex min-h-screen flex-col">
            @include('layouts.partials.header-marketing')

            @isset($header)
                <div class="border-b border-slate-200/80 bg-white/80 backdrop-blur">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <main class="flex-1">
                @include('layouts.partials.flash')
                {{ $slot }}
            </main>

            @include('layouts.partials.footer')
        </div>
    </body>
</html>
