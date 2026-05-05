<x-guest-layout>
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-black text-slate-900 leading-tight">{{ __('Welcome Back!') }}</h2>
        <p class="mt-3 text-sm font-medium text-slate-500 leading-relaxed">{{ __('Sign in to your account to continue.') }}</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email Address')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" />
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-pink-600 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" /></svg>
                </div>
                <x-text-input id="email" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-4 pl-12 pr-5 transition-all focus:border-pink-500 focus:ring-pink-500 focus:bg-white font-bold text-slate-900" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex items-center justify-between px-1">
                <x-input-label for="password" :value="__('Password')" class="text-[10px] font-black uppercase tracking-widest text-slate-400" />
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-black uppercase tracking-widest text-pink-600 hover:text-rose-600 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot?') }}
                    </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-pink-600 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <x-text-input id="password" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-4 pl-12 pr-5 transition-all focus:border-pink-500 focus:ring-pink-500 focus:bg-white font-bold text-slate-900"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between px-1 pt-2">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-pink-600 shadow-sm focus:ring-pink-500 cursor-pointer" name="remember">
                <span class="ms-2 text-xs font-bold text-slate-500 group-hover:text-slate-900 transition-colors">{{ __('Keep me signed in') }}</span>
            </label>
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center py-4 rounded-2xl bg-pink-600 hover:bg-pink-700 shadow-xl shadow-pink-200 text-sm font-black uppercase tracking-widest transition-all active:scale-95">
                {{ __('Sign In Now') }}
            </x-primary-button>
        </div>

        <div class="pt-8 text-center border-t border-slate-100">
            <p class="text-sm font-medium text-slate-500">
                {{ __('Don\'t have an account?') }}
                <a href="{{ route('register') }}" class="font-black text-pink-600 hover:text-rose-600 transition-colors ml-1 uppercase text-xs tracking-widest">
                    {{ __('Register') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
