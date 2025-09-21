<nav x-data="{ open: false }" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200/50 dark:border-gray-700/50 shadow-lg sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <!-- User Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.index')">
                        {{ __('Saját bejelentéseim') }}
                    </x-nav-link>
                    <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">
                        {{ __('Tudásbázis') }}
                    </x-nav-link>
                    <x-nav-link :href="route('data-change.index')" :active="request()->routeIs('data-change.*')">
                        {{ __('Adatváltozás bejelentés') }}
                    </x-nav-link>
                </div>



                <!-- Admin Navigation Links -->
                @if(auth()->user()->is_admin || 
                    auth()->user()->hasPermission('access_admin_dashboard') ||
                    auth()->user()->hasPermission('manage_all_tickets') ||
                    auth()->user()->hasPermission('view_assigned_tickets'))
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('admin-dashboard')" :active="request()->routeIs('admin.*')">
                        {{ __('Admin Felület') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.tickets.index')" :active="request()->routeIs('admin.tickets.*')">
                        {{ __('Jegyek Kezelése') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.*')">
                        {{ __('Tudásbázis Kezelése') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        {{ __('Kategóriák Kezelése') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                        {{ __('Szerepkörök Kezelése') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        {{ __('Felhasználók Kezelése') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.workplaces.index')" :active="request()->routeIs('admin.workplaces.*')">
                        {{ __('Munkahelyek Kezelése') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.pre-registered-users.index')" :active="request()->routeIs('admin.pre-registered-users.*')">
                        {{ __('Előregisztrált Felhasználók') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.data-change-approval.index')" :active="request()->routeIs('admin.data-change-approval.*')">
                        {{ __('Adatváltozás Jóváhagyás') }}
                    </x-nav-link>
                </div>
                @endif

            </div>

                        <!-- Theme Toggle -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <button id="theme-toggle" type="button" class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 transition-all duration-200">
                        <svg id="sun-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                        </svg>
                        <svg id="moon-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>

                    <!-- Language Selector -->
                    <div class="relative ml-3">
                        <div>
                            <button type="button" class="relative flex rounded-md bg-white/80 dark:bg-gray-800/80 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200" id="language-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open language menu</span>
                                <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                </svg>
                                <span class="ml-2 text-gray-700 dark:text-gray-300 font-medium">
                                    @if(app()->getLocale() == 'hu') HU
                                    @elseif(app()->getLocale() == 'en') EN
                                    @elseif(app()->getLocale() == 'es') ES
                                    @endif
                                </span>
                            </button>
                        </div>

                        <div class="absolute right-0 z-10 mt-2 w-32 origin-top-right rounded-md bg-white dark:bg-gray-800 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="language-menu-button" tabindex="-1" id="language-dropdown">
                            <a href="{{ route('locale.change', 'hu') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ app()->getLocale() == 'hu' ? 'bg-gray-100 dark:bg-gray-700' : '' }}" role="menuitem">
                                <span class="flex items-center">
                                    <span class="mr-2">🇭🇺</span>
                                    Magyar
                                </span>
                            </a>
                            <a href="{{ route('locale.change', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ app()->getLocale() == 'en' ? 'bg-gray-100 dark:bg-gray-700' : '' }}" role="menuitem">
                                <span class="flex items-center">
                                    <span class="mr-2">🇬🇧</span>
                                    English
                                </span>
                            </a>
                            <a href="{{ route('locale.change', 'es') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ app()->getLocale() == 'es' ? 'bg-gray-100 dark:bg-gray-700' : '' }}" role="menuitem">
                                <span class="flex items-center">
                                    <span class="mr-2">🇪🇸</span>
                                    Español
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>


                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
