<section>
    <header class="mb-8">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('Jelszó módosítása') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Győződjön meg róla, hogy fiókja hosszú, véletlenszerű jelszót használ a biztonság érdekében.') }}
                </p>
            </div>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-6">
            <!-- Current Password -->
            <div>
                <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Jelenlegi jelszó') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent transition-colors duration-200"
                           placeholder="Adja meg jelenlegi jelszavát">
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <!-- New Password -->
            <div>
                <label for="update_password_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Új jelszó') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent transition-colors duration-200"
                           placeholder="Minimum 8 karakter">
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Jelszó megerősítése') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent transition-colors duration-200"
                           placeholder="Ismételje meg az új jelszót">
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    {{ __('Jelszó frissítése') }}
                </button>

                @if (session('status') === 'password-updated')
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                         class="inline-flex items-center px-4 py-2 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-800 dark:text-green-200">{{ __('Jelszó sikeresen frissítve!') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </form>
</section>
