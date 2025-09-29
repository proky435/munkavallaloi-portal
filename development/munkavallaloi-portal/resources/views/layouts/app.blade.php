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

        <!-- Help Modal -->
        <div id="helpModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="helpTitle">{{ __('Segítség') }}</h3>
                        <button onclick="closeHelp()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="text-sm text-gray-700 dark:text-gray-300" id="helpContent">
                        <!-- Help content will be loaded here -->
                    </div>
                    <div class="flex justify-end mt-6">
                        <button onclick="closeHelp()" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200">
                            {{ __('Bezárás') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help System JavaScript -->
        <script>
        const helpContent = {
            'tickets-management': {
                title: '{{ __("Jegyek Kezelése - Segítség") }}',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🎫 {{ __("Jegyek áttekintése") }}</h4>
                            <p>{{ __("Itt láthatja az összes beérkezett bejelentést. A jegyek státusz szerint szűrhetők és kereshetők.") }}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🔍 {{ __("Szűrési lehetőségek") }}</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li><strong>{{ __("Kategória:") }}</strong> {{ __("Szűrés bejelentés típusa szerint") }}</li>
                                <li><strong>{{ __("Státusz:") }}</strong> {{ __("Nyitott, folyamatban, lezárt jegyek") }}</li>
                                <li><strong>{{ __("Keresés:") }}</strong> {{ __("Szöveg alapú keresés a jegyek között") }}</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">⚡ {{ __("Gyors műveletek") }}</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>{{ __("Kattintson egy jegyre a részletek megtekintéséhez") }}</li>
                                <li>{{ __("A státusz oszlopban láthatja az aktuális állapotot") }}</li>
                                <li>{{ __("A dátum oszlop mutatja a beérkezés idejét") }}</li>
                            </ul>
                        </div>
                    </div>
                `
            },
            'categories-management': {
                title: '{{ __("Kategóriák Kezelése - Segítség") }}',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📂 {{ __("Kategóriák áttekintése") }}</h4>
                            <p>{{ __("A kategóriák segítségével csoportosíthatja a különböző típusú bejelentéseket (IT, HR, Pénzügy, stb.).") }}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">➕ {{ __("Új kategória létrehozása") }}</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>{{ __("Kattintson az \"Új kategória\" gombra") }}</li>
                                <li>{{ __("Adja meg a kategória nevét és leírását") }}</li>
                                <li>{{ __("Állítsa be a felelős email címet (opcionális)") }}</li>
                                <li>{{ __("Mentse el a változtatásokat") }}</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">✏️ {{ __("Kategória szerkesztése") }}</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>{{ __("Kattintson a \"Szerkesztés\" gombra a kategória mellett") }}</li>
                                <li>{{ __("Módosítsa a szükséges adatokat") }}</li>
                                <li>{{ __("A form mezők hozzáadásához használja a \"Form kezelés\" menüt") }}</li>
                            </ul>
                        </div>
                    </div>
                `
            },
            'users-management': {
                title: '{{ __("Felhasználók Kezelése - Segítség") }}',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">👥 {{ __("Felhasználók áttekintése") }}</h4>
                            <p>{{ __("Itt kezelheti a rendszer összes felhasználóját, szerepköreit és jogosultságait.") }}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🔐 {{ __("Szerepkörök") }}</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li><strong>{{ __("Super Admin:") }}</strong> {{ __("Teljes rendszer hozzáférés") }}</li>
                                <li><strong>{{ __("Admin:") }}</strong> {{ __("Kategória-specifikus adminisztráció") }}</li>
                                <li><strong>{{ __("HR Admin:") }}</strong> {{ __("HR kategóriák kezelése") }}</li>
                                <li><strong>{{ __("Finance Admin:") }}</strong> {{ __("Pénzügyi kategóriák kezelése") }}</li>
                                <li><strong>{{ __("User:") }}</strong> {{ __("Alapvető felhasználói jogok") }}</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">⚙️ {{ __("Felhasználó szerkesztése") }}</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>{{ __("Szerepkör módosítása") }}</li>
                                <li>{{ __("Kategória hozzáférések beállítása") }}</li>
                                <li>{{ __("Munkahely információk frissítése") }}</li>
                                <li>{{ __("Admin jogosultságok kezelése") }}</li>
                            </ul>
                        </div>
                    </div>
                `
            },
            'roles-management': {
                title: '{{ __("Szerepkörök Kezelése - Segítség") }}',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🎭 {{ __("Szerepkörök áttekintése") }}</h4>
                            <p>{{ __("A szerepkörök határozzák meg, hogy a felhasználók milyen funkciókat érhetnek el a rendszerben.") }}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🔧 {{ __("Jogosultságok") }}</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li><strong>manage_all_tickets:</strong> {{ __("Összes jegy kezelése") }}</li>
                                <li><strong>manage_categories:</strong> {{ __("Kategóriák kezelése") }}</li>
                                <li><strong>manage_users:</strong> {{ __("Felhasználók kezelése") }}</li>
                                <li><strong>manage_roles:</strong> {{ __("Szerepkörök kezelése") }}</li>
                                <li><strong>view_admin_dashboard:</strong> {{ __("Admin dashboard elérése") }}</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">⚠️ {{ __("Figyelem") }}</h4>
                            <p class="text-amber-600 dark:text-amber-400">{{ __("A szerepkörök módosítása azonnal hatályba lép. Legyen óvatos a jogosultságok megváltoztatásakor!") }}</p>
                        </div>
                    </div>
                `
            },
            'workplaces-management': {
                title: 'Munkahelyek Kezelése - Segítség',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🏢 Munkahelyek áttekintése</h4>
                            <p>Itt kezelheti a különböző munkahelyeket és telephelyeket a rendszerben.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">➕ Új munkahely hozzáadása</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Adja meg a munkahely nevét</li>
                                <li>Írja be a címet és elérhetőségeket</li>
                                <li>Állítsa be a kapcsolattartó személyt</li>
                                <li>Mentse el az adatokat</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">👥 Felhasználók hozzárendelése</h4>
                            <p>A felhasználók szerkesztésekor kiválaszthatja, hogy melyik munkahelyen dolgoznak.</p>
                        </div>
                    </div>
                `
            },
            'user-workplaces-management': {
                title: 'Munkahely Hozzárendelések - Segítség',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🏢 Munkahely hozzárendelések áttekintése</h4>
                            <p>Itt kezelheti a felhasználók munkahely hozzárendeléseit, beleértve az állandó és időszakos hozzárendeléseket is.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">⚡ Hozzárendelés típusok</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li><strong>Állandó hozzárendelés:</strong> Időkorlát nélküli munkahely hozzárendelés</li>
                                <li><strong>Időszakos hozzárendelés:</strong> Meghatározott időtartamra szóló hozzárendelés</li>
                                <li><strong>Elsődleges munkahely:</strong> A felhasználó fő munkahelye</li>
                                <li><strong>Másodlagos munkahely:</strong> További munkahelyek</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">➕ Új hozzárendelés létrehozása</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Kattintson a "Manage" gombra a felhasználó mellett</li>
                                <li>Válassza ki a munkahelyet</li>
                                <li>Állítsa be a hozzárendelés típusát (állandó/időszakos)</li>
                                <li>Időszakos hozzárendelésnél adja meg a dátumokat</li>
                                <li>Jelölje meg, ha ez az elsődleges munkahely</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🔍 Státusz jelentések</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li><span class="px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs">Állandó</span> - Időkorlát nélküli hozzárendelés</li>
                                <li><span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Jelenlegi</span> - Aktív időszakos hozzárendelés</li>
                                <li><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">Jövőbeli</span> - Még nem kezdődött el</li>
                                <li><span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">Korábbi</span> - Lejárt hozzárendelés</li>
                            </ul>
                        </div>
                    </div>
                `
            },
            'preregistered-users': {
                title: 'Előregisztrált Felhasználók - Segítség',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📋 Előregisztráció áttekintése</h4>
                            <p>Az előregisztrált felhasználók még nem aktiválták a fiókjukat, de már szerepelnek a rendszerben.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">➕ Új előregisztráció</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Adja meg a felhasználó alapadatait</li>
                                <li>Állítsa be az adóazonosítót és születési dátumot</li>
                                <li>Válassza ki a munkahelyet</li>
                                <li>A felhasználó ezekkel az adatokkal tud majd bejelentkezni</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🔐 Első bejelentkezés</h4>
                            <p>Az előregisztrált felhasználók az adóazonosítójukkal és születési dátumukkal tudnak először bejelentkezni.</p>
                        </div>
                    </div>
                `
            },
            'data-change-requests': {
                title: 'Adatváltozás Kérések - Segítség',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📝 Adatváltozás kérések</h4>
                            <p>A felhasználók itt kérhetik személyes adataik módosítását (név, cím, bankszámlaszám, stb.).</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">✅ Jóváhagyási folyamat</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Tekintse át a kért változtatásokat</li>
                                <li>Ellenőrizze a csatolt dokumentumokat</li>
                                <li>Hagyja jóvá vagy utasítsa el a kérést</li>
                                <li>A jóváhagyott változtatások automatikusan érvénybe lépnek</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🔒 Biztonság</h4>
                            <p>Minden adatváltozás naplózásra kerül és visszakövethetően tárolódik a rendszerben.</p>
                        </div>
                    </div>
                `
            },
            'forms-management': {
                title: 'Formák Kezelése - Segítség',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📋 Dinamikus formák</h4>
                            <p>Itt kezelheti a kategóriákhoz tartozó form mezőket és azok beállításait.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🔧 Mező típusok</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li><strong>Rövid szöveg:</strong> Egyszerű szöveges bevitel (max 255 karakter)</li>
                                <li><strong>Hosszú szöveg:</strong> Többsoros szöveges terület</li>
                                <li><strong>Legördülő lista:</strong> Előre definiált opciók</li>
                                <li><strong>Dátum:</strong> Dátum választó</li>
                                <li><strong>Szám:</strong> Numerikus bevitel</li>
                                <li><strong>Fájl:</strong> Dokumentum feltöltés</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">⚙️ Mező beállítások</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Kötelező mező jelölése</li>
                                <li>Mező címke és leírás</li>
                                <li>Sorrend meghatározása</li>
                                <li>Validációs szabályok</li>
                            </ul>
                        </div>
                    </div>
                `
            },
            'field-mapping': {
                title: 'Mező Hozzárendelés - Segítség',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🔗 Mező hozzárendelés</h4>
                            <p>Itt rendelheti hozzá a form mezőket a felhasználói adatmodell mezőihez az automatikus adatfrissítéshez.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📊 Támogatott mezők</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li><strong>name:</strong> Teljes név</li>
                                <li><strong>email:</strong> Email cím</li>
                                <li><strong>phone:</strong> Telefonszám</li>
                                <li><strong>address:</strong> Lakcím</li>
                                <li><strong>bank_account:</strong> Bankszámlaszám</li>
                                <li><strong>tax_number:</strong> Adóazonosító</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">⚡ Automatikus frissítés</h4>
                            <p>A hozzárendelt mezők jóváhagyott adatváltozás kérések esetén automatikusan frissülnek a felhasználó profiljában.</p>
                        </div>
                    </div>
                `
            },
            'articles-management': {
                title: 'Tudásbázis Kezelése - Segítség',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📚 Tudásbázis áttekintése</h4>
                            <p>Itt kezelheti a tudásbázis cikkeit, amelyek segítséget nyújtanak a felhasználóknak a gyakori kérdésekben.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">✍️ Cikk létrehozása</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Adjon meg egy beszédes címet</li>
                                <li>Írja meg a cikk tartalmát Markdown formátumban</li>
                                <li>Állítsa be a cikk státuszát (draft/published)</li>
                                <li>Rendeljen hozzá kategóriákat a könnyebb kereséshez</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🔍 Keresés és szűrés</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Keresés cím és tartalom alapján</li>
                                <li>Szűrés státusz szerint</li>
                                <li>Rendezés dátum vagy népszerűség szerint</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📈 Statisztikák</h4>
                            <p>Követheti nyomon, hogy mely cikkek a legnépszerűbbek és melyek szorulnak frissítésre.</p>
                        </div>
                    </div>
                `
            },
            'admin-dashboard': {
                title: 'Admin Dashboard - Segítség',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🎯 Főbb funkciók</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li><strong>Jegyek:</strong> Bejelentések megtekintése és kezelése</li>
                                <li><strong>Kategóriák:</strong> Jegy kategóriák szerkesztése</li>
                                <li><strong>Tudásbázis:</strong> Cikkek és PDF-ek kezelése</li>
                                <li><strong>Adatváltozás:</strong> Felhasználói kérések jóváhagyása</li>
                                <li><strong>Felhasználók:</strong> Szerepkörök és jogosultságok</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📊 Statisztikák</h4>
                            <p>A dashboard kártyákon láthatja a rendszer aktuális állapotát és a sürgős teendőket.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">💡 Tipp</h4>
                            <p>A válaszoknál csatolhat dokumentumokat is!</p>
                        </div>
                    </div>
                `
            },
            'ticket-creation': {
                title: 'Bejelentés Létrehozása - Segítség',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📝 Hogyan működik</h4>
                            <ol class="list-decimal list-inside space-y-1 text-sm">
                                <li><strong>Kategória:</strong> Válassza ki a megfelelő kategóriát (IT, HR, Admin, stb.)</li>
                                <li><strong>Tárgy:</strong> Rövid, beszédes címet adjon meg</li>
                                <li><strong>Leírás:</strong> Részletesen írja le a problémát vagy kérést</li>
                                <li><strong>Prioritás:</strong> Válassza ki a sürgősségi szintet</li>
                                <li><strong>Fájlok:</strong> Csatoljon képernyőképeket vagy dokumentumokat</li>
                            </ol>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">💡 Tipp</h4>
                            <p>Minél részletesebb a leírás, annál gyorsabb a megoldás!</p>
                        </div>
                    </div>
                `
            },
            'data-change': {
                title: 'Adatváltozás Bejelentés - Segítség',
                content: `
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🔄 Hogyan működik</h4>
                            <ol class="list-decimal list-inside space-y-1 text-sm">
                                <li><strong>Típus választás:</strong> Kattintson a módosítani kívánt adat típusára</li>
                                <li><strong>Űrlap kitöltése:</strong> Adja meg az új adatokat</li>
                                <li><strong>Dokumentumok:</strong> Csatolja a szükséges igazoló dokumentumokat</li>
                                <li><strong>Jóváhagyás:</strong> A HR részleg ellenőrzi és jóváhagyja</li>
                                <li><strong>Értesítés:</strong> Email értesítést kap a döntésről</li>
                            </ol>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">⚠️ Fontos</h4>
                            <p>A változások csak jóváhagyás után lépnek életbe!</p>
                        </div>
                    </div>
                `
            }
        };

        function showHelp(helpKey) {
            const modal = document.getElementById('helpModal');
            const title = document.getElementById('helpTitle');
            const content = document.getElementById('helpContent');
            
            if (helpContent[helpKey]) {
                title.textContent = helpContent[helpKey].title;
                content.innerHTML = helpContent[helpKey].content;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeHelp() {
            const modal = document.getElementById('helpModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('helpModal');
            if (event.target === modal) {
                closeHelp();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeHelp();
            }
        });
        </script>
    </body>
</html>
