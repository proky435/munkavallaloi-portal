@extends('layouts.app')

@section('content')

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Admin Dashboard') }}</h1>
                        <x-help-tooltip 
                            title="Admin Dashboard Használata"
                            content="<strong>Főbb funkciók:</strong><br>
                            • <strong>Jegyek:</strong> Bejelentések megtekintése és kezelése<br>
                            • <strong>Kategóriák:</strong> Jegy kategóriák szerkesztése<br>
                            • <strong>Tudásbázis:</strong> Cikkek és PDF-ek kezelése<br>
                            • <strong>Adatváltozás:</strong> Felhasználói kérések jóváhagyása<br>
                            • <strong>Felhasználók:</strong> Szerepkörök és jogosultságok<br><br>
                            <strong>Tipp:</strong> A válaszoknál csatolhat dokumentumokat is!" />
                    </div>
                    
                    <!-- Confidential Reporting Button -->
                    <div class="flex-shrink-0">
                        <a href="https://maximont.hu/hu/visszaeles-bejelentes/" 
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            {{ __('Confidential Reporting') }}
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M7 7l10 10M17 7l-4 4"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">{{ __('Rendszer áttekintés és gyors műveletek') }}</p>
            </div>
            
            <!-- Statisztikai Kártyák -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- New Tickets Card -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('Új bejelentések') }}</h3>
                            <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $stats['new_tickets'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Azonnali figyelmet igényelnek</p>
                        </div>
                        <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-full">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- In Progress Card -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('Folyamatban lévő') }}</h3>
                            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">{{ $stats['in_progress_tickets'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Aktívan kezelés alatt</p>
                        </div>
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Closed Tickets Card -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('Lezárt bejelentések') }}</h3>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $stats['closed_tickets'] ?? 0 }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sikeresen megoldva</p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Total Users Card -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('Összes felhasználó') }}</h3>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $stats['total_users'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Regisztrált dolgozók</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gyors Műveletek -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Jegyek Kezelése -->
                <a href="{{ route('admin.tickets.index') }}" class="group bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Jegyek Kezelése') }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Összes bejelentés megtekintése és kezelése</p>
                </a>

                <!-- Kategóriák -->
                <a href="{{ route('admin.categories.index') }}" class="group bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Kategóriák') }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Bejelentési kategóriák kezelése</p>
                </a>

                <!-- Felhasználók -->
                <a href="{{ route('admin.users.index') }}" class="group bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Felhasználók') }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Felhasználók adminisztrációja</p>
                </a>
            </div>

            <!-- Legutóbbi Bejelentések -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Legutóbbi Bejelentések') }}</h3>
                        <a href="{{ route('admin.tickets.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                            {{ __('Összes megtekintése') }} →
                        </a>
                    </div>
                </div>
                    
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($tickets->take(5) as $ticket)
                        <div class="px-6 py-4 hover:bg-gray-50/80 dark:hover:bg-gray-700/50 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                                            <span class="text-sm font-medium text-white">{{ substr($ticket->user->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $ticket->user->name }}</p>
                                            @if($ticket->category)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                    {{ $ticket->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate">{{ $ticket->subject ?: 'Dinamikus űrlap bejelentés' }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500">{{ $ticket->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @if ($ticket->status === 'Új')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                            {{ __('Új') }}
                                        </span>
                                    @elseif ($ticket->status === 'Folyamatban')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                            {{ __('Folyamatban') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                            {{ __('Lezárva') }}
                                        </span>
                                    @endif
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors duration-200 text-sm">
                                        {{ __('Kezelés') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">{{ __('Nincsenek bejelentések') }}</h3>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">{{ __('Jelenleg nincsenek bejelentések a rendszerben.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Confidential Reporting Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            @include('layouts.whistleblowing-link')
        </div>
    </div>
@endsection