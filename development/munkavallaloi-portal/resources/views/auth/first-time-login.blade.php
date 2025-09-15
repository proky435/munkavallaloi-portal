<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Első bejelentkezés előregisztrált felhasználóknak. Használja az adóazonosítóját felhasználónévként és a születési dátumát jelszóként.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('first-time-login.store') }}">
        @csrf

        <!-- Tax Number -->
        <div>
            <x-input-label for="tax_number" :value="__('Adóazonosító')" />
            <x-text-input id="tax_number" class="block mt-1 w-full" type="text" name="tax_number" :value="old('tax_number')" required autofocus />
            <x-input-error :messages="$errors->get('tax_number')" class="mt-2" />
        </div>

        <!-- Birth Date -->
        <div class="mt-4">
            <x-input-label for="birth_date" :value="__('Születési dátum (ÉÉÉÉ.HH.NN)')" />
            <x-text-input id="birth_date" class="block mt-1 w-full"
                            type="text"
                            name="birth_date"
                            placeholder="1990.01.15"
                            :value="old('birth_date')"
                            required />
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Új jelszó')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Jelszó megerősítése')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('login') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Vissza a bejelentkezéshez') }}
            </a>

            <x-primary-button>
                {{ __('Fiók aktiválása') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
