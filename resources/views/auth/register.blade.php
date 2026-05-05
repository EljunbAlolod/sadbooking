<x-guest-layout>
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-black text-slate-900 leading-tight">{{ __('Join Us Today') }}</h2>
        <p class="mt-3 text-sm font-medium text-slate-500 leading-relaxed">{{ __('Start your journey with Boarding Hub.') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <x-input-label for="name" :value="__('Full Name')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" />
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-pink-600 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <x-text-input id="name" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-4 pl-12 pr-5 transition-all focus:border-pink-500 focus:ring-pink-500 focus:bg-white font-bold text-slate-900" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email Address')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" />
            <div class="relative group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-pink-600 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" /></svg>
                </div>
                <x-text-input id="email" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-4 pl-12 pr-5 transition-all focus:border-pink-500 focus:ring-pink-500 focus:bg-white font-bold text-slate-900" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="space-y-4">
            <x-input-label :value="__('Account Type')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" />
            <div class="grid gap-4">
                <label class="relative flex cursor-pointer items-start gap-4 rounded-2xl border border-slate-200 bg-slate-50/30 p-5 transition-all hover:bg-slate-50 has-[:checked]:border-pink-600 has-[:checked]:bg-pink-50/30 group">
                    <input type="radio" name="role" value="tenant" class="mt-1.5 h-4 w-4 text-pink-600 focus:ring-pink-500 border-slate-300" @checked(old('role', 'tenant') === 'tenant')>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <span class="block text-sm font-black text-slate-900 uppercase tracking-tight">{{ __('Tenant') }}</span>
                            <div class="h-8 w-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-pink-500 shadow-sm transition-transform group-hover:scale-110">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>
                        <span class="block mt-1 text-xs font-medium text-slate-500 leading-relaxed">{{ __('Looking for a safe and quality boarding house.') }}</span>
                    </div>
                </label>
                <label class="relative flex cursor-pointer items-start gap-4 rounded-2xl border border-slate-200 bg-slate-50/30 p-5 transition-all hover:bg-slate-50 has-[:checked]:border-pink-600 has-[:checked]:bg-pink-50/30 group">
                    <input type="radio" name="role" value="landlord" class="mt-1.5 h-4 w-4 text-pink-600 focus:ring-pink-500 border-slate-300" @checked(old('role') === 'landlord')>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <span class="block text-sm font-black text-slate-900 uppercase tracking-tight">{{ __('Landlord') }}</span>
                            <div class="h-8 w-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-pink-500 shadow-sm transition-transform group-hover:scale-110">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                        </div>
                        <span class="block mt-1 text-xs font-medium text-slate-500 leading-relaxed">{{ __('List properties and manage your tenants effortlessly.') }}</span>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="grid gap-6 sm:grid-cols-2">
            <div class="space-y-2">
                <x-input-label for="password" :value="__('Password')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" />
                <x-text-input id="password" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-4 px-5 transition-all focus:border-pink-500 focus:ring-pink-500 focus:bg-white font-bold text-slate-900"
                                type="password"
                                name="password"
                                required autocomplete="new-password"
                                placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="space-y-2">
                <x-input-label for="password_confirmation" :value="__('Confirm')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" />
                <x-text-input id="password_confirmation" class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 py-4 px-5 transition-all focus:border-pink-500 focus:ring-pink-500 focus:bg-white font-bold text-slate-900"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="pt-6">
            <x-primary-button class="w-full justify-center py-4 rounded-2xl bg-pink-600 hover:bg-pink-700 shadow-xl shadow-pink-200 text-sm font-black uppercase tracking-widest transition-all active:scale-95">
                {{ __('Create Free Account') }}
            </x-primary-button>
        </div>

        <div class="pt-8 text-center border-t border-slate-100">
            <p class="text-sm font-medium text-slate-500">
                {{ __('Already registered?') }}
                <a href="{{ route('login') }}" class="font-black text-pink-600 hover:text-rose-600 transition-colors ml-1 uppercase text-xs tracking-widest">
                    {{ __('Sign In') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
