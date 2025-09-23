@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-lg border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            {{ __('Field Mapping Elemzés') }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            {{ __('Kérés azonosító: #') }}{{ $dataChangeRequest->id }} - {{ $dataChangeRequest->user->name }}
                        </p>
                    </div>
                    <a href="{{ route('admin.data-change-requests.show', $dataChangeRequest) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Vissza') }}
                    </a>
                </div>

                <!-- Field Analysis -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Mező Elemzés és Mapping') }}</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Form Mező') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Érték') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Jelenlegi Mapping') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Javasolt Mapping') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Alkalmazva lesz?') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($fieldAnalysis as $field => $analysis)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $field }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-white max-w-xs truncate">
                                                @if(is_array($analysis['value']))
                                                    <span class="text-gray-500 italic">Array ({{ count($analysis['value']) }} elemek)</span>
                                                @else
                                                    {{ Str::limit($analysis['value'], 50) }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($analysis['current_mapping'] === 'NINCS MAPPING')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    {{ __('Nincs mapping') }}
                                                </span>
                                            @elseif($analysis['current_mapping'] === null)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">
                                                    {{ __('Kihagyva') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    {{ $analysis['current_mapping'] }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                {{ $analysis['suggested_mapping'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($analysis['will_be_applied'])
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('Igen') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('Nem') }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Összefoglaló') }}</h4>
                        
                        @php
                            $totalFields = count($fieldAnalysis);
                            $mappedFields = collect($fieldAnalysis)->where('current_mapping', '!=', 'NINCS MAPPING')->count();
                            $appliedFields = collect($fieldAnalysis)->where('will_be_applied', true)->count();
                            $ignoredFields = collect($fieldAnalysis)->where('current_mapping', null)->count();
                        @endphp
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $totalFields }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Összes mező') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $appliedFields }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Alkalmazva lesz') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-600">{{ $ignoredFields }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Kihagyva') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-600">{{ $totalFields - $mappedFields }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Nincs mapping') }}</div>
                            </div>
                        </div>
                        
                        @if($totalFields - $mappedFields > 0)
                        <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                <strong>{{ __('Figyelem:') }}</strong> {{ $totalFields - $mappedFields }} mező nincs még leképezve. 
                                Ezek a mezők nem lesznek alkalmazva a felhasználó profiljára.
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
