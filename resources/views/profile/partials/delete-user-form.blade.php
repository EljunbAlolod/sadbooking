<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-slate-900">
            {{ __('Danger Zone') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500 leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-rose-600 hover:bg-rose-700 shadow-lg shadow-rose-100 px-8 rounded-xl py-3 border-none"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-bold text-slate-900">
                {{ __('Are you sure?') }}
            </h2>

            <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-slate-200 focus:border-rose-500 focus:ring-rose-500"
                    placeholder="{{ __('Confirm Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-6 py-3 border-slate-200 text-slate-600 hover:bg-slate-50">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="bg-rose-600 hover:bg-rose-700 px-6 py-3 rounded-xl border-none">
                    {{ __('Permanently Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
