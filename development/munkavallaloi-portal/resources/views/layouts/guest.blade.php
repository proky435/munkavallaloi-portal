<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Theme Script -->
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <!-- Background with gradient and pattern -->
        <div class="min-h-screen relative bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
            <!-- Animated background pattern -->
            <div class="absolute inset-0 opacity-20 dark:opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #3b82f6 0%, transparent 50%), radial-gradient(circle at 75% 75%, #8b5cf6 0%, transparent 50%);"></div>
            </div>
            
            <!-- Theme Toggle Button -->
            <div class="absolute top-6 right-6 z-50">
                <button id="theme-toggle" type="button" class="relative p-3 text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all duration-200 shadow-lg hover:shadow-xl border border-gray-200 dark:border-gray-600 cursor-pointer">
                    <svg id="sun-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                    </svg>
                    <svg id="moon-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>
            </div>

            <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 min-h-screen relative z-10">
                <!-- Logo Section -->
                <div class="mb-8">
                    <a href="/" class="block">
                        <x-application-logo class="w-24 h-24 fill-current text-blue-600 dark:text-blue-400 drop-shadow-lg hover:scale-105 transition-transform duration-300" />
                    </a>
                </div>

                <!-- Main Card -->
                <div class="w-full sm:max-w-md">
                    <div class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 p-8 transition-all duration-300 hover:shadow-3xl">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme Toggle Script -->
        <script>
            // Initialize theme immediately
            function initTheme() {
                if (localStorage.getItem('theme') === 'dark' || 
                    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
            
            // Call immediately
            initTheme();

            document.addEventListener('DOMContentLoaded', function() {
                const themeToggle = document.getElementById('theme-toggle');
                const sunIcon = document.getElementById('sun-icon');
                const moonIcon = document.getElementById('moon-icon');

                console.log('Theme toggle elements:', {
                    themeToggle: !!themeToggle,
                    sunIcon: !!sunIcon,
                    moonIcon: !!moonIcon
                });

                if (!themeToggle || !sunIcon || !moonIcon) {
                    console.error('Theme toggle elements not found');
                    return;
                }

                function updateThemeIcons() {
                    const isDark = document.documentElement.classList.contains('dark');
                    console.log('Updating icons, isDark:', isDark);
                    
                    if (isDark) {
                        sunIcon.classList.remove('hidden');
                        moonIcon.classList.add('hidden');
                    } else {
                        sunIcon.classList.add('hidden');
                        moonIcon.classList.remove('hidden');
                    }
                }

                // Initial icon update
                updateThemeIcons();

                // Theme toggle event listener
                themeToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    console.log('Theme toggle clicked');
                    
                    const isDark = document.documentElement.classList.contains('dark');
                    
                    if (isDark) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                        console.log('Switched to light theme');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                        console.log('Switched to dark theme');
                    }
                    
                    updateThemeIcons();
                });

                // Add visual feedback on hover
                themeToggle.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                });

                themeToggle.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        </script>
    </body>
</html>
