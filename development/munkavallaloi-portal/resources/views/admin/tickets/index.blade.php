@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-600 dark:from-white dark:to-slate-300 bg-clip-text text-transparent">
                            {{ __('Jegyek kezelése') }}
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400 mt-2">{{ __('Összes beérkezett jegy áttekintése és kezelése') }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            {{ $tickets->total() }} {{ __('jegy') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6">
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 dark:border-slate-700/50 p-4">
                <form method="GET" action="{{ route('admin.tickets.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-48">
                        <label for="category" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('Kategória') }}</label>
                        <select name="category" id="category" class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                            <option value="">{{ __('Minden kategória') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-48">
                        <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('Státusz') }}</label>
                        <select name="status" id="status" class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                            <option value="">{{ __('Minden státusz') }}</option>
                            <option value="Új" {{ request('status') == 'Új' ? 'selected' : '' }}>{{ __('Új') }}</option>
                            <option value="Folyamatban" {{ request('status') == 'Folyamatban' ? 'selected' : '' }}>{{ __('Folyamatban') }}</option>
                            <option value="Lezárva" {{ request('status') == 'Lezárva' ? 'selected' : '' }}>{{ __('Lezárva') }}</option>
                        </select>
                    </div>
                    <div class="flex-1 min-w-48">
                        <label for="search" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('Keresés') }}</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="{{ __('Keresés a jegyek között...') }}"
                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                            {{ __('Szűrés') }}
                        </button>
                        <a href="{{ route('admin.tickets.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-6 py-2 rounded-lg font-medium transition-all duration-200">
                            {{ __('Törlés') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tickets Table -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-xl shadow-xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
            @if($tickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">{{ __('ID') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">{{ __('Felhasználó') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">{{ __('Kategória') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">{{ __('Tárgy') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">{{ __('Státusz') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">{{ __('Létrehozva') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">{{ __('Műveletek') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-600">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">#{{ $ticket->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white font-medium text-sm">
                                                {{ substr($ticket->user->name, 0, 2) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-slate-900 dark:text-white">{{ $ticket->user->name }}</div>
                                                <div class="text-sm text-slate-500 dark:text-slate-400">{{ $ticket->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200">
                                            {{ $ticket->category?->name ?? 'Kategória nélkül' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900 dark:text-white max-w-xs truncate">
                                            @if($ticket->subject)
                                                {{ $ticket->subject }}
                                            @else
                                                <span class="italic text-slate-500 dark:text-slate-400">{{ __('Dinamikus űrlap bejelentés') }}</span>
                                            @endif
                                        </div>
                                        @if($ticket->form_data)
                                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                                {{ __('Dinamikus űrlap') }} • {{ count($ticket->form_data) }} {{ __('mező') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'Új' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                'Folyamatban' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                'Lezárva' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400'
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ __($ticket->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                                        <div>{{ $ticket->created_at->format('Y.m.d') }}</div>
                                        <div class="text-xs">{{ $ticket->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.tickets.show', $ticket) }}" 
                                               class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200 shadow hover:shadow-lg">
                                                {{ __('Megtekintés') }}
                                            </a>
                                            @if($ticket->attachment)
                                                <a href="{{ route('tickets.download', $ticket) }}" 
                                                   class="bg-slate-500 hover:bg-slate-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200">
                                                    {{ __('Letöltés') }}
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($tickets->hasPages())
                    <div class="bg-slate-50 dark:bg-slate-700/50 px-6 py-4 border-t border-slate-200 dark:border-slate-600">
                        {{ $tickets->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-r from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">{{ __('Nincsenek jegyek') }}</h3>
                    <p class="text-slate-500 dark:text-slate-400">{{ __('Jelenleg nincsenek jegyek a rendszerben.') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
