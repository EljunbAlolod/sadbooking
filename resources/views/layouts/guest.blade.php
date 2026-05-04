<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.head')
    </head>
    <body class="font-sans antialiased text-slate-900">
        <div class="flex min-h-screen flex-col bg-gradient-to-br from-slate-100 via-white to-indigo-50/40">
            <div class="flex flex-1 flex-col items-center justify-center px-4 py-10 sm:py-12">
                <a href="{{ url('/') }}" class="mb-6 inline-flex items-center gap-2 font-semibold tracking-tight text-slate-900">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-sm text-white shadow-sm">{{ strtoupper(\Illuminate\Support\Str::substr(config('app.name', 'S'), 0, 1)) }}</span>
                    {{ config('app.name') }}
                </a>

                <div class="w-full max-w-md overflow-hidden rounded-2xl border border-slate-200/80 bg-white px-6 py-8 shadow-lg">
                    @include('layouts.partials.flash')
                    {{ $slot }}
                </div>
            </div>

            @include('layouts.partials.footer')
        </div>
    </body>
</html>
