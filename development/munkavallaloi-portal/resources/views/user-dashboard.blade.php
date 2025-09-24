@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ __('Üdvözöljük!') }}
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Szia {{ auth()->user()->name }}! Itt kezelheti bejelentéseit és böngészheti a tudásbázist.
            </p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- My Reports Card -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('My Reports') }}</h3>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ auth()->user()->tickets()->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Workplace Card -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('Workplace') }}</h3>
                        <p class="text-lg font-semibold text-emerald-600 dark:text-emerald-400 mt-2">
                            {{ auth()->user()->workplace ?? __('Not set') }}
                        </p>
                    </div>
                    <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-full">
                        <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Role Card -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('Role') }}</h3>
                        <p class="text-lg font-semibold text-purple-600 dark:text-purple-400 mt-2">
                            {{ auth()->user()->role ? auth()->user()->role->display_name : __('User') }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ __('Quick Actions') }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('tickets.create') }}" class="group relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-4 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="font-medium">{{ __('New Report') }}</span>
                    </div>
                </a>
                
                <a href="{{ route('tickets.index') }}" class="group relative overflow-hidden bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-4 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="font-medium">{{ __('My Reports') }}</span>
                    </div>
                </a>
                
                <a href="{{ route('articles.index') }}" class="group relative overflow-hidden bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-4 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="font-medium">{{ __('Knowledge Base') }}</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Tickets -->
        @if($recentTickets->count() > 0)
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ __('Legutóbbi bejelentéseim') }}</h3>
            <div class="space-y-4">
                @foreach($recentTickets as $ticket)
                <div class="flex items-center justify-between p-4 bg-gray-50/50 dark:bg-gray-700/50 rounded-xl">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900 dark:text-white">{{ $ticket->title }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ $ticket->category?->name ?? 'Kategória nélkül' }} • {{ $ticket->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="px-3 py-1 text-xs font-medium rounded-full
                            @if($ticket->status === 'open') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                            @elseif($ticket->status === 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                            @elseif($ticket->status === 'resolved') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400
                            @endif">
                            {{ ucfirst($ticket->status) }}
                        </span>
                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div cl1ass="mt-6 text-center">
                <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    {{ __('Összes bejelentés megtekintése') }}
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
        @endif

        <!-- Recent Articles -->
        @if($recentArticles->count() > 0)
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ __('Legújabb tudásbázis cikkek') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recentArticles as $article)
                <div class="bg-gray-50/50 dark:bg-gray-700/50 rounded-xl p-4 hover:bg-gray-100/50 dark:hover:bg-gray-600/50 transition-colors duration-200">
                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">{{ $article->title }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($article->excerpt, 100) }}</p>
                    <a href="{{ route('articles.show', $article) }}" class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                        {{ __('Elolvasás') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Whistleblowing Link -->
        @include('layouts.whistleblowing-link')
    </div>
</div>
@endsection
