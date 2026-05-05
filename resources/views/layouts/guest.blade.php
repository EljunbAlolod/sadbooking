<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.head')
        <style>
            .bg-pattern {
                background-color: #f8fafc;
                background-image: radial-gradient(#ec4899 0.5px, transparent 0.5px), radial-gradient(#ec4899 0.5px, #f8fafc 0.5px);
                background-size: 20px 20px;
                background-position: 0 0, 10px 10px;
                opacity: 0.05;
            }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-900 overflow-x-hidden">
        <div class="relative min-h-screen flex flex-col bg-slate-50">
            <!-- Decorative Background -->
            <div class="absolute inset-0 bg-pattern"></div>
            <div class="absolute top-0 left-0 w-full h-1/2 bg-gradient-to-b from-pink-50/50 to-transparent"></div>
            
            <div class="relative flex flex-1 flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="mb-10 flex flex-col items-center group transition-transform hover:scale-105 active:scale-95">
                    <div class="flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-pink-600 text-white shadow-2xl shadow-pink-200 transition-transform group-hover:rotate-6">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div class="mt-4 flex flex-col items-center">
                        <span class="text-2xl font-black tracking-tight text-slate-900 uppercase">{{ config('app.name', 'Boarding Hub') }}</span>
                        <span class="text-[10px] font-bold text-pink-600 uppercase tracking-widest mt-1">{{ __('Quality Stay') }}</span>
                    </div>
                </a>

                <div class="w-full max-w-md">
                    <div class="overflow-hidden rounded-[2.5rem] border border-white/40 bg-white/80 backdrop-blur-xl shadow-2xl shadow-slate-200/60 transition-all">
                        <div class="px-8 py-10 sm:px-10 sm:py-12">
                            @include('layouts.partials.flash')
                            {{ $slot }}
                        </div>
                    </div>
                    
                    <p class="mt-8 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                    </p>
                </div>
            </div>

            @include('layouts.partials.footer')
        </div>
    </body>
</html>
