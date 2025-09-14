<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Személyes adatok') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Frissítse személyes adatait és munkahely információit.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Workplace Selection -->
        <div>
            <x-input-label for="workplace_id" :value="__('Munkahely')" />
            <select id="workplace_id" name="workplace_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="">{{ __('Válasszon munkahelyet') }}</option>
                @foreach($workplaces as $workplace)
                    <option value="{{ $workplace->id }}" {{ old('workplace_id', $user->workplace_id) == $workplace->id ? 'selected' : '' }}>
                        {{ $workplace->name }} ({{ $workplace->code }})
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('workplace_id')" />
        </div>

        <!-- Personal Information Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Phone -->
            <div>
                <x-input-label for="phone" :value="__('Telefon')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <!-- Birth Date -->
            <div>
                <x-input-label for="birth_date" :value="__('Születési dátum')" />
                <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $user->birth_date?->format('Y-m-d'))" />
                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
            </div>
        </div>

        <!-- Birth Place -->
        <div>
            <x-input-label for="birth_place" :value="__('Születési hely')" />
            <x-text-input id="birth_place" name="birth_place" type="text" class="mt-1 block w-full" :value="old('birth_place', $user->birth_place)" />
            <x-input-error class="mt-2" :messages="$errors->get('birth_place')" />
        </div>

        <!-- Address Information -->
        <div class="space-y-4">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                {{ __('Lakcím') }}
            </h3>
            
            <div>
                <x-input-label for="address" :value="__('Cím')" />
                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" />
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <x-input-label for="city" :value="__('Város')" />
                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" />
                    <x-input-error class="mt-2" :messages="$errors->get('city')" />
                </div>

                <div>
                    <x-input-label for="postal_code" :value="__('Irányítószám')" />
                    <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $user->postal_code)" />
                    <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
                </div>

                <div>
                    <x-input-label for="country" :value="__('Ország')" />
                    <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->country)" />
                    <x-input-error class="mt-2" :messages="$errors->get('country')" />
                </div>
            </div>
        </div>

        <!-- Financial Information -->
        <div class="space-y-4">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                {{ __('Pénzügyi adatok') }}
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="bank_account_number" :value="__('Bankszámlaszám')" />
                    <x-text-input id="bank_account_number" name="bank_account_number" type="text" class="mt-1 block w-full" :value="old('bank_account_number', $user->bank_account_number)" />
                    <x-input-error class="mt-2" :messages="$errors->get('bank_account_number')" />
                </div>

                <div>
                    <x-input-label for="tax_number" :value="__('Adószám')" />
                    <x-text-input id="tax_number" name="tax_number" type="text" class="mt-1 block w-full" :value="old('tax_number', $user->tax_number)" />
                    <x-input-error class="mt-2" :messages="$errors->get('tax_number')" />
                </div>
            </div>

            <div>
                <x-input-label for="social_security_number" :value="__('TAJ szám')" />
                <x-text-input id="social_security_number" name="social_security_number" type="text" class="mt-1 block w-full" :value="old('social_security_number', $user->social_security_number)" />
                <x-input-error class="mt-2" :messages="$errors->get('social_security_number')" />
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="space-y-4">
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                {{ __('Vészhelyzeti kapcsolattartó') }}
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="emergency_contact_name" :value="__('Név')" />
                    <x-text-input id="emergency_contact_name" name="emergency_contact_name" type="text" class="mt-1 block w-full" :value="old('emergency_contact_name', $user->emergency_contact_name)" />
                    <x-input-error class="mt-2" :messages="$errors->get('emergency_contact_name')" />
                </div>

                <div>
                    <x-input-label for="emergency_contact_phone" :value="__('Telefon')" />
                    <x-text-input id="emergency_contact_phone" name="emergency_contact_phone" type="text" class="mt-1 block w-full" :value="old('emergency_contact_phone', $user->emergency_contact_phone)" />
                    <x-input-error class="mt-2" :messages="$errors->get('emergency_contact_phone')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Mentés') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Mentve.') }}</p>
            @endif
        </div>
    </form>
</section>
