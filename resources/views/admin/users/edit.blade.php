<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    {{ __('Edit User') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Update details for {{ $user->name }} ({{ $user->role->label() }}).</p>
            </div>
            <a href="{{ $user->role === \App\Enums\UserRole::Landlord ? route('admin.landlords.index') : route('admin.tenants.index') }}" 
               class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-pink-600 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to list
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-100">
                <div class="p-8">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-2xl" :value="old('name', $user->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-2xl" :value="old('email', $user->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="border-t border-slate-50 pt-6 mt-6">
                            <h3 class="text-lg font-bold text-slate-900 mb-1">{{ __('Security') }}</h3>
                            <p class="text-sm text-slate-500 mb-4">Leave password fields empty to keep the current password.</p>
                            
                            <div class="grid gap-6 md:grid-cols-2">
                                <!-- Password -->
                                <div>
                                    <x-input-label for="password" :value="__('New Password')" />
                                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full rounded-2xl" autocomplete="new-password" />
                                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-2xl" autocomplete="new-password" />
                                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-50">
                            <x-primary-button class="rounded-xl px-8 py-3 bg-pink-600 hover:bg-pink-700 shadow-lg shadow-pink-100">
                                {{ __('Save Changes') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
