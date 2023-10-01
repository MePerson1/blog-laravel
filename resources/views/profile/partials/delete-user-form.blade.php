<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            {{ __('Usun konto') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('Kiedy twoje konto zostanie usuniete, wszystkie wpisy i informacje zostaną usunięte!') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Usuń konto') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-100">
                {{ __('Czy na pewno chcesz usunąć konto??') }}
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                {{ __('Kiedy twoje konto zostanie usuniete, wszystkie wpisy i informacje zostaną usunięte!') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Password" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Password"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Anuluj') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Usuń konto') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
