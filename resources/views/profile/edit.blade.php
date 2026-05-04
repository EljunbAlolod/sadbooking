<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">{{ __('Profile Account') }}</p>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('Edit Settings') }}</h2>
            </div>
            <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                {{ __('Back to Profile') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Sidebar Info -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-4">
                        <div class="bg-indigo-600 rounded-3xl p-8 text-white shadow-xl shadow-indigo-200 relative overflow-hidden">
                            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                            <h3 class="text-xl font-bold mb-2">{{ __('Security & Identity') }}</h3>
                            <p class="text-indigo-100 text-sm leading-relaxed">
                                {{ __('Update your personal information, manage your password, and keep your account secure.') }}
                            </p>
                        </div>
                        
                        <nav class="bg-white rounded-2xl border border-slate-200 p-2 shadow-sm">
                            <a href="#profile-info" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 rounded-xl transition-colors">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ __('General Information') }}
                            </a>
                            <a href="#password-update" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 rounded-xl transition-colors">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                {{ __('Security Settings') }}
                            </a>
                            <a href="#delete-account" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-rose-600 hover:bg-rose-50 rounded-xl transition-colors">
                                <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                {{ __('Danger Zone') }}
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Forms Area -->
                <div class="lg:col-span-2 space-y-8">
                    <div id="profile-info" class="p-6 sm:p-10 bg-white shadow-sm sm:rounded-3xl border border-slate-200">
                        <div class="max-w-2xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div id="password-update" class="p-6 sm:p-10 bg-white shadow-sm sm:rounded-3xl border border-slate-200">
                        <div class="max-w-2xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div id="delete-account" class="p-6 sm:p-10 bg-white shadow-sm sm:rounded-3xl border border-rose-100 bg-rose-50/10">
                        <div class="max-w-2xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
