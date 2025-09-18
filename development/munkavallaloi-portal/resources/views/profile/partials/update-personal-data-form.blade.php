<div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
    <header class="mb-8">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('Személyes adatok') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Személyes adatok megtekintése. Módosításhoz használja az "Adatváltozás bejelentés" funkciót.') }}
                </p>
            </div>
        </div>
        
        <!-- Information Notice -->
        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        {{ __('Adatváltozás bejelentése szükséges') }}
                    </p>
                    <p class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                        {{ __('A személyes adatok módosításához kérjük használja az "Adatváltozás bejelentés" funkciót a bejelentések között. Ez biztosítja a megfelelő dokumentáció és jóváhagyási folyamat betartását.') }}
                    </p>
                </div>
            </div>
        </div>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <!-- Workplace Selection -->
        <div>
            <label for="workplace_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('Munkahely') }}
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <select id="workplace_id" name="workplace_id" 
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-colors duration-200">
                    <option value="">{{ __('Válasszon munkahelyet') }}</option>
                    @foreach($workplaces as $workplace)
                        <option value="{{ $workplace->id }}" {{ old('workplace_id', $user->workplace_id) == $workplace->id ? 'selected' : '' }}>
                            {{ $workplace->name }} ({{ $workplace->code }})
                        </option>
                    @endforeach
                </select>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('workplace_id')" />
        </div>

        <!-- Personal Information Section -->
        <section>
            <header>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2 flex items-center">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{ __('Személyes adatok') }}
                </h2>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 cursor-not-allowed backdrop-blur-sm"
                               placeholder="+36 20 123 4567" readonly>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <!-- Birth Date -->
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Születési dátum') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white cursor-not-allowed backdrop-blur-sm"
                               readonly>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                </div>
            </div>

            <!-- Birth Place -->
            <div class="mt-6">
                <label for="birth_place" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Születési hely') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <input id="birth_place" name="birth_place" type="text" value="{{ old('birth_place', $user->birth_place) }}"
                           class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 cursor-not-allowed backdrop-blur-sm"
                           placeholder="Budapest, Magyarország" readonly>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('birth_place')" />
            </div>
        </div>

        <!-- Address Information Section -->
        <div class="bg-white/50 dark:bg-gray-700/30 backdrop-blur-sm rounded-xl p-6 border border-gray-200/30 dark:border-gray-600/30">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ __('Lakcím') }}
            </h3>
            
            <div class="space-y-6">
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Utca, házszám') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <input id="address" name="address" type="text" value="{{ old('address', $user->address) }}"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 cursor-not-allowed backdrop-blur-sm"
                               placeholder="Kossuth Lajos utca 12." readonly>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Város') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <input id="city" name="city" type="text" value="{{ old('city', $user->city) }}"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 cursor-not-allowed backdrop-blur-sm"
                                   placeholder="Budapest" readonly>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('city')" />
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Irányítószám') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                </svg>
                            </div>
                            <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $user->postal_code) }}"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 cursor-not-allowed backdrop-blur-sm"
                                   placeholder="1051" readonly>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
                    </div>

                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Ország') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <input id="country" name="country" type="text" value="{{ old('country', $user->country) }}"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 cursor-not-allowed backdrop-blur-sm"
                                   placeholder="Magyarország" readonly>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('country')" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Information Section -->
        <div class="bg-white/50 dark:bg-gray-700/30 backdrop-blur-sm rounded-xl p-6 border border-gray-200/30 dark:border-gray-600/30">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('Pénzügyi adatok') }}
            </h3>
            
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="bank_account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Bankszámlaszám') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <input id="bank_account_number" name="bank_account_number" type="text" value="{{ old('bank_account_number', $user->bank_account_number) }}"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 cursor-not-allowed backdrop-blur-sm"
                                   placeholder="12345678-12345678-12345678" readonly>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('bank_account_number')" />
                    </div>

                    <div>
                        <label for="tax_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Adószám') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <input id="tax_number" name="tax_number" type="text" value="{{ old('tax_number', $user->tax_number) }}"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 cursor-not-allowed backdrop-blur-sm"
                                   placeholder="12345678-1-23" readonly>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('tax_number')" />
                    </div>
                </div>

                <div>
                    <label for="social_security_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('TAJ szám') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <input id="social_security_number" name="social_security_number" type="text" value="{{ old('social_security_number', $user->social_security_number) }}"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 cursor-not-allowed backdrop-blur-sm"
                               placeholder="123 456 789" readonly>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('social_security_number')" />
                </div>
            </div>
        </div>

        <!-- Emergency Contact Section -->
        <div class="bg-white/50 dark:bg-gray-700/30 backdrop-blur-sm rounded-xl p-6 border border-gray-200/30 dark:border-gray-600/30">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                {{ __('Vészhelyzeti kapcsolattartó') }}
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Név') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input id="emergency_contact_name" name="emergency_contact_name" type="text" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 cursor-not-allowed backdrop-blur-sm"
                               placeholder="Nagy Péter" readonly>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('emergency_contact_name')" />
                </div>

                <div>
                    <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Telefon') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <input id="emergency_contact_phone" name="emergency_contact_phone" type="text" value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300/50 dark:border-gray-500/50 rounded-xl bg-white/80 dark:bg-gray-600/80 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 cursor-not-allowed backdrop-blur-sm"
                               placeholder="+36 30 987 6543" readonly>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('emergency_contact_phone')" />
                </div>
            </div>
        </div>

        <!-- Information Notice -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('A személyes adatok módosításához használja az') }} 
                    <span class="font-semibold text-blue-600 dark:text-blue-400">{{ __('"Adatváltozás bejelentés"') }}</span> 
                    {{ __('funkciót a bejelentések között.') }}
                </p>
            </div>
        </div>
    </form>
</div>
