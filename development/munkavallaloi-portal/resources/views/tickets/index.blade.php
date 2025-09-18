@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Saját bejelentéseim') }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Kezelje és kövesse nyomon bejelentéseit</p>
            </div>
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('Új bejelentés') }}
            </a>
        </div>

        <!-- Tickets Container -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
            @if($tickets->count() > 0)
                <!-- Table Header -->
                <div class="bg-gray-50/80 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200/50 dark:border-gray-600/50">
                    <div class="grid grid-cols-12 gap-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        <div class="col-span-4">{{ __('Téma') }}</div>
                        <div class="col-span-2">{{ __('Státusz') }}</div>
                        <div class="col-span-3">{{ __('Utolsó frissítés') }}</div>
                        <div class="col-span-2">{{ __('Kategória') }}</div>
                        <div class="col-span-1 text-center">{{ __('Csatolmány') }}</div>
                    </div>
                </div>

                <!-- Table Body -->
                <div class="divide-y divide-gray-200/50 dark:divide-gray-600/50">
                    @foreach($tickets as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}" class="block px-6 py-4 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors duration-200 cursor-pointer">
                            <div class="grid grid-cols-12 gap-4 items-center">
                                <!-- Subject -->
                                <div class="col-span-4">
                                    <p class="font-medium text-gray-900 dark:text-white truncate hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        {{ $ticket->subject ?: ($ticket->form_data ? 'Dinamikus űrlap bejelentés' : 'Bejelentés #' . $ticket->id) }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                        {{ $ticket->message ?: ($ticket->form_data ? 'Dinamikus űrlap alapú bejelentés' : 'Nincs leírás') }}
                                    </p>
                                </div>

                                <!-- Status -->
                                <div class="col-span-2">
                                    @php
                                        $statusColors = [
                                            'Új' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-300 dark:border-red-700',
                                            'Folyamatban' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-300 dark:border-yellow-700',
                                            'Lezárva' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-700'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                        {{ __($ticket->status) }}
                                    </span>
                                </div>

                                <!-- Last Updated -->
                                <div class="col-span-3">
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $ticket->updated_at->format('Y.m.d H:i') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->updated_at->diffForHumans() }}</p>
                                </div>

                                <!-- Category -->
                                <div class="col-span-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $ticket->category ? $ticket->category->name : 'Nincs kategória' }}
                                    </span>
                                </div>

                                <!-- Attachment -->
                                <div class="col-span-1 text-center">
                                    @if($ticket->attachment)
                                        <div class="inline-flex items-center justify-center w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full">
                                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-600">-</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($tickets->hasPages())
                    <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-700/30 border-t border-gray-200/50 dark:border-gray-600/50">
                        {{ $tickets->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Nincs bejelentés</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Még nem küldött be egyetlen bejelentést sem.</p>
                    <div class="mt-6">
                        <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Első bejelentés létrehozása
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection