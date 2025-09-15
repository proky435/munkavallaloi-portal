@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-lg border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        {{ __('Adatváltozás bejelentés') }}
                    </h2>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                {{ __('Itt bejelentheti személyes adatainak változását. A bejelentés után egy admin felhasználó fogja feldolgozni a kérését.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('data-change.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Change Type Selection -->
                    <div>
                        <label for="change_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Változtatás típusa') }} <span class="text-red-500">*</span>
                        </label>
                        <select name="change_type" id="change_type" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                            <option value="">{{ __('Válasszon típust...') }}</option>
                            <option value="personal" {{ old('change_type') == 'personal' ? 'selected' : '' }}>{{ __('Személyes adatok') }}</option>
                            <option value="contact" {{ old('change_type') == 'contact' ? 'selected' : '' }}>{{ __('Kapcsolattartási adatok') }}</option>
                            <option value="financial" {{ old('change_type') == 'financial' ? 'selected' : '' }}>{{ __('Pénzügyi adatok') }}</option>
                            <option value="emergency" {{ old('change_type') == 'emergency' ? 'selected' : '' }}>{{ __('Vészhelyzeti kapcsolattartó') }}</option>
                        </select>
                        @error('change_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name Change -->
                        <div>
                            <label for="current_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Jelenlegi név') }}
                            </label>
                            <input type="text" name="current_name" id="current_name" value="{{ old('current_name', auth()->user()->name) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                        </div>
                        
                        <div>
                            <label for="new_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Új név') }}
                            </label>
                            <input type="text" name="new_name" id="new_name" value="{{ old('new_name') }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                        </div>

                        <!-- Phone Change -->
                        <div>
                            <label for="current_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Jelenlegi telefonszám') }}
                            </label>
                            <input type="text" name="current_phone" id="current_phone" value="{{ old('current_phone', auth()->user()->phone) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                        </div>
                        
                        <div>
                            <label for="new_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Új telefonszám') }}
                            </label>
                            <input type="text" name="new_phone" id="new_phone" value="{{ old('new_phone') }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                        </div>

                        <!-- Address Change -->
                        <div>
                            <label for="current_street_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Jelenlegi cím') }}
                            </label>
                            <input type="text" name="current_street_address" id="current_street_address" value="{{ old('current_street_address', auth()->user()->street_address) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                        </div>
                        
                        <div>
                            <label for="new_street_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Új cím') }}
                            </label>
                            <input type="text" name="new_street_address" id="new_street_address" value="{{ old('new_street_address') }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                        </div>

                        <!-- Bank Account Change -->
                        <div>
                            <label for="current_bank_account" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Jelenlegi bankszámlaszám') }}
                            </label>
                            <input type="text" name="current_bank_account" id="current_bank_account" value="{{ old('current_bank_account') }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200"
                                placeholder="{{ auth()->user()->bank_account_number ? '****' . substr(auth()->user()->bank_account_number, -4) : __('Nincs megadva') }}">
                        </div>
                        
                        <div>
                            <label for="new_bank_account" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Új bankszámlaszám') }}
                            </label>
                            <input type="text" name="new_bank_account" id="new_bank_account" value="{{ old('new_bank_account') }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                        </div>

                        <!-- Emergency Contact Change -->
                        <div>
                            <label for="current_emergency_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Jelenlegi vészhelyzeti kapcsolattartó') }}
                            </label>
                            <input type="text" name="current_emergency_name" id="current_emergency_name" value="{{ old('current_emergency_name', auth()->user()->emergency_contact_name) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                        </div>
                        
                        <div>
                            <label for="new_emergency_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Új vészhelyzeti kapcsolattartó') }}
                            </label>
                            <input type="text" name="new_emergency_name" id="new_emergency_name" value="{{ old('new_emergency_name') }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('További megjegyzések') }}
                        </label>
                        <textarea name="notes" id="notes" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200"
                            placeholder="{{ __('Írja le részletesen, milyen változtatásokat szeretne...') }}">{{ old('notes') }}</textarea>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Csatolmány') }}
                        </label>
                        <input type="file" name="attachment" id="attachment"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ __('Támogatott formátumok: PDF, JPG, PNG, DOC, DOCX. Maximum 5MB.') }}
                        </p>
                        @error('attachment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6">
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                            {{ __('Bejelentés elküldése') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
