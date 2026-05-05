<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Boarding Hub') }} - Find Your Perfect Boarding House</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts/Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }

        .glass-dark {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="antialiased bg-slate-50 text-slate-900 selection:bg-pink-100 selection:text-pink-700">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass border-b border-slate-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-3">
                    <div
                        class="h-10 w-10 bg-pink-600 rounded-xl flex items-center justify-center shadow-lg shadow-pink-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="text-xl font-bold tracking-tight text-slate-900">{{ config('app.name', 'Boarding Hub') }}</span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-pink-600 text-white text-sm font-bold hover:bg-pink-700 shadow-lg shadow-pink-200 transition-all active:scale-95">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-sm font-medium text-slate-600 hover:text-pink-600 transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-pink-600 text-white text-sm font-bold hover:bg-pink-700 shadow-lg shadow-pink-200 transition-all active:scale-95">Get
                                    Started</a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button type="button" class="text-slate-500 hover:text-pink-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:flex lg:items-center lg:gap-16">
                    <div class="lg:w-1/2 relative z-10">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-50 text-pink-600 text-xs font-bold uppercase tracking-wider mb-6 animate-fade-in">
                            <span class="flex h-2 w-2 rounded-full bg-pink-600"></span>
                            Verified Boarding Houses Only
                        </div>
                        <h1 class="text-5xl lg:text-7xl font-bold text-slate-900 leading-[1.1] mb-8">
                            Find your perfect <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-rose-600">home
                                away from home.</span>
                        </h1>
                        <p class="text-lg text-slate-600 leading-relaxed mb-10 lg:max-w-xl">
                            Discover high-quality, verified boarding houses and rooms tailored to your needs.
                            Affordable, convenient, and safe for students and professionals.
                        </p>

                        <!-- Search Form -->
                        <form action="{{ route('boarding-houses.index') }}" method="GET"
                            class="flex flex-col sm:flex-row gap-3 p-2 bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 max-w-2xl">
                            <div class="flex-1 flex items-center px-4 gap-3">
                                <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <input type="text" name="location" placeholder="Where do you want to stay?"
                                    class="w-full border-none focus:ring-0 text-slate-900 placeholder-slate-400 py-3 bg-transparent">
                            </div>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-8 py-3 rounded-xl bg-pink-600 text-white font-bold hover:bg-pink-700 shadow-lg shadow-pink-100 transition-all active:scale-95">
                                Search Now
                            </button>
                        </form>

                        <div class="mt-12 flex items-center gap-8">
                            <div>
                                <p class="text-3xl font-bold text-slate-900">500+</p>
                                <p class="text-sm text-slate-500 font-medium">Listings</p>
                            </div>
                            <div class="h-10 w-px bg-slate-200"></div>
                            <div>
                                <p class="text-3xl font-bold text-slate-900">1.2k</p>
                                <p class="text-sm text-slate-500 font-medium">Reservations</p>
                            </div>
                            <div class="h-10 w-px bg-slate-200"></div>
                            <div>
                                <p class="text-3xl font-bold text-slate-900">4.9/5</p>
                                <p class="text-sm text-slate-500 font-medium">Tenant Rating</p>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:block lg:w-1/2 relative">
                        <div class="absolute -inset-4 bg-pink-600/5 rounded-3xl blur-3xl"></div>
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                            <img src="{{ asset('images/hero.png') }}" alt="Modern Boarding House"
                                class="w-full h-auto object-cover transform hover:scale-105 transition-transform duration-700">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent">
                            </div>
                            <div class="absolute bottom-8 left-8 right-8 p-6 glass rounded-2xl border border-white/20">
                                <div class="flex items-center gap-4">
                                    <div class="flex -space-x-3">
                                        <div
                                            class="h-10 w-10 rounded-full border-2 border-white bg-slate-200 overflow-hidden">
                                            <img src="https://ui-avatars.com/api/?name=John+Doe" alt="">
                                        </div>
                                        <div
                                            class="h-10 w-10 rounded-full border-2 border-white bg-slate-200 overflow-hidden">
                                            <img src="https://ui-avatars.com/api/?name=Jane+Smith" alt="">
                                        </div>
                                        <div
                                            class="h-10 w-10 rounded-full border-2 border-white bg-pink-600 flex items-center justify-center text-xs font-bold text-white">
                                            +8
                                        </div>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-900">Recently booked by students at UP
                                        Manila</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-24 bg-white border-y border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-6 tracking-tight">Why Choose Our
                        Platform?</h2>
                    <p class="text-slate-600 leading-relaxed">We provide a seamless and secure experience for both
                        tenants and landlords, ensuring every listing meets our standards.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div
                        class="group p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:border-pink-200 transition-all hover:shadow-xl hover:shadow-pink-50/50">
                        <div
                            class="h-14 w-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Verified Listings</h3>
                        <p class="text-slate-600 leading-relaxed">Every property and landlord is manually verified by
                            our team to ensure your safety and peace of mind.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="group p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:border-pink-200 transition-all hover:shadow-xl hover:shadow-pink-50/50">
                        <div
                            class="h-14 w-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Instant Reservations</h3>
                        <p class="text-slate-600 leading-relaxed">Book your room in minutes. No more wasting time
                            visiting multiple places in person.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="group p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:border-pink-200 transition-all hover:shadow-xl hover:shadow-pink-50/50">
                        <div
                            class="h-14 w-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Transparent Pricing</h3>
                        <p class="text-slate-600 leading-relaxed">No hidden fees. View all inclusive costs, utility
                            bills, and deposit requirements upfront.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="relative rounded-[3rem] bg-pink-600 p-8 lg:p-20 overflow-hidden shadow-2xl shadow-pink-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-500 to-pink-800 opacity-50"></div>
                    <div class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-black/10 rounded-full blur-3xl"></div>

                    <div class="relative z-10 lg:flex lg:items-center lg:justify-between">
                        <div class="lg:max-w-2xl mb-12 lg:mb-0 text-center lg:text-left">
                            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6 tracking-tight leading-tight">
                                Ready to find your next home?</h2>
                            <p class="text-pink-100 text-lg leading-relaxed">Join thousands of students and
                                professionals who found their perfect stay through our platform.</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center justify-center px-10 py-4 rounded-2xl bg-white text-pink-600 font-bold hover:bg-pink-50 transition-all active:scale-95 shadow-xl">
                                Create Account
                            </a>
                            <a href="{{ route('boarding-houses.index') }}"
                                class="inline-flex items-center justify-center px-10 py-4 rounded-2xl bg-pink-500 text-white font-bold hover:bg-pink-400 border border-pink-400/50 transition-all active:scale-95 shadow-xl">
                                Browse Houses
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 py-20 text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-3 text-white mb-8">
                        <div class="h-8 w-8 bg-pink-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold tracking-tight">{{ config('app.name', 'Boarding Hub') }}</span>
                    </div>
                    <p class="leading-relaxed mb-8">Empowering students and professionals to find safe, affordable, and
                        convenient housing with ease.</p>
                    <div class="flex space-x-5">
                        <a href="#" class="hover:text-pink-400 transition-colors"><svg class="w-6 h-6"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg></a>
                        <a href="#" class="hover:text-pink-400 transition-colors"><svg class="w-6 h-6"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-8">Platform</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('boarding-houses.index') }}"
                                class="hover:text-white transition-colors">Browse Houses</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Safety Standards</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">How it Works</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-8">Legal</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Refund Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Cookie Policy</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-8">Support</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQs</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Report a Listing</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm">© {{ date('Y') }} {{ config('app.name', 'Boarding Hub') }}. All rights reserved.</p>
                <div class="flex items-center gap-6 text-sm">
                    <span class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        System Online
                    </span>
                    <p>Philippines</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
