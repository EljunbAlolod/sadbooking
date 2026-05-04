<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label :value="__('I want to')" />
            <fieldset class="mt-2 space-y-2">
                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-slate-50/80 px-4 py-3 has-[:checked]:border-indigo-300 has-[:checked]:bg-indigo-50/50">
                    <input type="radio" name="role" value="tenant" class="mt-1 text-indigo-600 focus:ring-indigo-500" @checked(old('role', 'tenant') === 'tenant')>
                    <span>
                        <span class="block text-sm font-medium text-slate-900">{{ __('Find a boarding house') }}</span>
                        <span class="block text-xs text-slate-600">{{ __('Browse listings and make reservations as a tenant.') }}</span>
                    </span>
                </label>
                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-slate-50/80 px-4 py-3 has-[:checked]:border-indigo-300 has-[:checked]:bg-indigo-50/50">
                    <input type="radio" name="role" value="landlord" class="mt-1 text-indigo-600 focus:ring-indigo-500" @checked(old('role') === 'landlord')>
                    <span>
                        <span class="block text-sm font-medium text-slate-900">{{ __('Post a boarding house') }}</span>
                        <span class="block text-xs text-slate-600">{{ __('List properties, rooms, and send billing notices to tenants.') }}</span>
                    </span>
                </label>
            </fieldset>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full rounded-xl border-slate-200 shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6 flex items-center justify-end gap-4">
            <a class="text-sm text-slate-600 underline hover:text-slate-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="rounded-xl">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
