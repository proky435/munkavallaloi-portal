<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil kiegészítése') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Info Section -->
                    <div class="mb-8 p-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">{{ __('Üdvözöljük a rendszerben!') }}</h3>
                                <p class="text-blue-700 dark:text-blue-300 mb-4">
                                    {{ __('A teljes funkcionalitás eléréséhez kérjük, egészítse ki profilját a hiányzó adatokkal.') }}
                                </p>
                                @if(count($missingFields) > 0)
                                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                        <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200 mb-2">{{ __('Hiányzó adatok:') }}</p>
                                        <ul class="text-sm text-yellow-700 dark:text-yellow-300 list-disc list-inside space-y-1">
                                            @foreach($missingFields as $field => $label)
                                                <li>{{ $label }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                        <p class="text-sm text-green-800 dark:text-green-200">{{ __('Minden szükséges adat megvan! Folytathatja a dashboard használatát.') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <form method="POST" action="{{ route('complete-profile.store') }}" class="space-y-8">
                        @csrf

                        <!-- Personal Information -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('Személyes adatok') }}
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Phone -->
                                @if(array_key_exists('phone', $missingFields))
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Telefonszám') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200"
                                           placeholder="+36 30 123 4567">
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                                @endif

                                <!-- Birth Place -->
                                @if(array_key_exists('birth_place', $missingFields))
                                <div>
                                    <label for="birth_place" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Születési hely') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input id="birth_place" name="birth_place" type="text" value="{{ old('birth_place', $user->birth_place) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200"
                                           placeholder="Budapest">
                                    <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
                                </div>
                                @endif

                                <!-- Workplace -->
                                @if(array_key_exists('workplace_id', $missingFields))
                                <div class="md:col-span-2">
                                    <label for="workplace_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Munkahely') }} <span class="text-red-500">*</span>
                                    </label>
                                    <select id="workplace_id" name="workplace_id"
                                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200">
                                        <option value="">{{ __('Válasszon munkahelyet') }}</option>
                                        @foreach($workplaces as $workplace)
                                            <option value="{{ $workplace->id }}" {{ old('workplace_id', $user->workplace_id) == $workplace->id ? 'selected' : '' }}>
                                                {{ $workplace->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('workplace_id')" class="mt-2" />
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Address Information -->
                        @if(array_key_exists('street_address', $missingFields) || array_key_exists('city', $missingFields) || array_key_exists('postal_code', $missingFields) || array_key_exists('country', $missingFields))
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ __('Lakcím') }}
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Street Address -->
                                @if(array_key_exists('street_address', $missingFields))
                                <div class="md:col-span-2">
                                    <label for="street_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Utca, házszám') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input id="street_address" name="street_address" type="text" value="{{ old('street_address', $user->street_address) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200"
                                           placeholder="Fő utca 123">
                                    <x-input-error :messages="$errors->get('street_address')" class="mt-2" />
                                </div>
                                @endif

                                <!-- Postal Code -->
                                @if(array_key_exists('postal_code', $missingFields))
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Irányítószám') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $user->postal_code) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200"
                                           placeholder="1234">
                                    <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                                </div>
                                @endif

                                <!-- City -->
                                @if(array_key_exists('city', $missingFields))
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Város') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input id="city" name="city" type="text" value="{{ old('city', $user->city) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200"
                                           placeholder="Budapest">
                                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                </div>
                                @endif

                                <!-- Country -->
                                @if(array_key_exists('country', $missingFields))
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Ország') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input id="country" name="country" type="text" value="{{ old('country', $user->country) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200"
                                           placeholder="Magyarország">
                                    <x-input-error :messages="$errors->get('country')" class="mt-2" />
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Financial Information -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                {{ __('Pénzügyi adatok') }}
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Bank Account -->
                                @if(array_key_exists('bank_account_number', $missingFields))
                                <div>
                                    <label for="bank_account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Bankszámlaszám') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input id="bank_account_number" name="bank_account_number" type="text" value="{{ old('bank_account_number', $user->bank_account_number) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200"
                                           placeholder="12345678-12345678-12345678">
                                    <x-input-error :messages="$errors->get('bank_account_number')" class="mt-2" />
                                </div>
                                @endif

                                <!-- Social Security Number -->
                                @if(array_key_exists('social_security_number', $missingFields))
                                <div>
                                    <label for="social_security_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('TAJ szám') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input id="social_security_number" name="social_security_number" type="text" value="{{ old('social_security_number', $user->social_security_number) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200"
                                           placeholder="123 456 789">
                                    <x-input-error :messages="$errors->get('social_security_number')" class="mt-2" />
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                {{ __('Vészhelyzeti kapcsolattartó') }}
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Emergency Contact Name -->
                                @if(array_key_exists('emergency_contact_name', $missingFields))
                                <div>
                                    <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Kapcsolattartó neve') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input id="emergency_contact_name" name="emergency_contact_name" type="text" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200"
                                           placeholder="Nagy János">
                                    <x-input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
                                </div>
                                @endif

                                <!-- Emergency Contact Phone -->
                                @if(array_key_exists('emergency_contact_phone', $missingFields))
                                <div>
                                    <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Kapcsolattartó telefonja') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input id="emergency_contact_phone" name="emergency_contact_phone" type="text" value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200"
                                           placeholder="+36 30 123 4567">
                                    <x-input-error :messages="$errors->get('emergency_contact_phone')" class="mt-2" />
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button type="submit" 
                                    class="flex-1 flex justify-center items-center py-4 px-6 border border-transparent rounded-xl shadow-sm text-base font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('Profil kiegészítése') }}
                            </button>
                            
                            @if(count($missingFields) == 0)
                            <a href="{{ route('dashboard') }}" 
                               class="flex-1 flex justify-center items-center py-4 px-6 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('Folytatás a dashboardra') }}
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
