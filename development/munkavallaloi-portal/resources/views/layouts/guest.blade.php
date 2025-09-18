<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Theme Toggle Script -->
        <script>
            // Theme toggle functionality
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="font-sans antialiased h-full">
        <div class="min-h-full flex">
            <!-- Left side - Branding/Image -->
            <div class="hidden lg:flex lg:flex-1 lg:relative">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-800"></div>
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="relative flex flex-col justify-center items-center p-12 text-white">
                    <div class="max-w-md text-center">
                        <h1 class="text-4xl font-bold mb-6">Munkavállalói Portál</h1>
                        <p class="text-xl text-blue-100 mb-8">Egyszerű és biztonságos bejelentési rendszer minden munkavállalónak</p>
                        <div class="grid grid-cols-1 gap-4 text-left">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-blue-100">Gyors és egyszerű bejelentések</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-blue-100">Biztonságos adatkezelés</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-blue-100">24/7 elérhető rendszer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side - Login Form -->
            <div class="flex-1 flex flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white dark:bg-gray-900 transition-colors duration-200">
                <div class="mx-auto w-full max-w-sm lg:w-96">
                    <!-- Theme Toggle -->
                    <div class="flex justify-end mb-8">
                        <button type="button" id="theme-toggle" class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Logo and Title -->
                    <div class="text-center mb-8">
                        <div class="mx-auto w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Bejelentkezés</h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Jelentkezz be a fiókodba</p>
                    </div>

                    <!-- Login Form -->
                    <div class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-8">
                        {{ $slot }}
                    </div>

                    <!-- Footer -->
                    <div class="mt-8 text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            © {{ date('Y') }} Munkavállalói Portál. Minden jog fenntartva.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme Toggle Script -->
        <script>
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            // Show the correct icon based on current theme
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            themeToggleBtn.addEventListener('click', function() {
                // Toggle icons
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // Toggle theme
                if (localStorage.getItem('theme')) {
                    if (localStorage.getItem('theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    }
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    }
                }
            });
        </script>
    </body>
</html>
