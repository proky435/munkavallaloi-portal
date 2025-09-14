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
        
        <script>
        // Theme Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing theme toggle...');
            
            const themeToggle = document.getElementById('theme-toggle');
            const htmlElement = document.documentElement;
            
            console.log('Theme toggle button:', themeToggle);
            
            // Check for saved theme preference or default to 'light'
            const currentTheme = localStorage.getItem('theme') || 'light';
            console.log('Current theme:', currentTheme);
            
            // Apply the current theme
            if (currentTheme === 'dark') {
                htmlElement.classList.add('dark');
                updateToggleIcon(true);
            } else {
                htmlElement.classList.remove('dark');
                updateToggleIcon(false);
            }
            
            // Theme toggle event listener
            if (themeToggle) {
                themeToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Theme toggle clicked!');
                    
                    const isDark = htmlElement.classList.contains('dark');
                    console.log('Current state is dark:', isDark);
                    
                    if (isDark) {
                        htmlElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                        updateToggleIcon(false);
                        console.log('Switched to light theme');
                    } else {
                        htmlElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                        updateToggleIcon(true);
                        console.log('Switched to dark theme');
                    }
                });
            } else {
                console.error('Theme toggle button not found!');
            }
            
            function updateToggleIcon(isDark) {
                const sunIcon = document.getElementById('sun-icon');
                const moonIcon = document.getElementById('moon-icon');
                
                console.log('Updating icons - isDark:', isDark, 'sunIcon:', sunIcon, 'moonIcon:', moonIcon);
                
                if (sunIcon && moonIcon) {
                    if (isDark) {
                        sunIcon.classList.remove('hidden');
                        moonIcon.classList.add('hidden');
                    } else {
                        sunIcon.classList.add('hidden');
                        moonIcon.classList.remove('hidden');
                    }
                }
            }
            
            // Language dropdown functionality
            const languageButton = document.getElementById('language-menu-button');
            const languageDropdown = document.getElementById('language-dropdown');
            
            if (languageButton && languageDropdown) {
                languageButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    languageDropdown.classList.toggle('hidden');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!languageButton.contains(e.target) && !languageDropdown.contains(e.target)) {
                        languageDropdown.classList.add('hidden');
                    }
                });
            }
        });
        </script>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-slate-900">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-lg border-b border-gray-200/50 dark:border-gray-700/50">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="relative">
                <!-- Flash Messages with Modern Design -->
                @if (session('success'))
                    <div class="py-4">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="bg-emerald-50 border-l-4 border-emerald-400 p-4 rounded-r-lg shadow-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="py-4">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
                {{ $slot ?? '' }}
            </main>
        </div>
    </body>
</html>
