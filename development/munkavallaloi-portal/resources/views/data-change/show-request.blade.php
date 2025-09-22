@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Adatváltozás Kérés') }}</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('Kérés azonosító: #') }}{{ $dataChangeRequest->id }}
            </p>
        </div>

        <!-- Status Alert -->
        <div class="mb-6">
            @if($dataChangeRequest->status === 'pending')
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                {{ __('Kérés feldolgozás alatt') }}
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                <p>{{ __('Az adatváltozás kérése jelenleg feldolgozás alatt áll. Értesítést fog kapni, amikor a kérés elbírálásra kerül.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($dataChangeRequest->status === 'approved')
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800 dark:text-green-200">
                                {{ __('Kérés jóváhagyva') }}
                            </h3>
                            <div class="mt-2 text-sm text-green-700 dark:text-green-300">
                                <p>{{ __('Az adatváltozás kérése jóváhagyásra került. Az adatok frissítése hamarosan megtörténik.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($dataChangeRequest->status === 'rejected')
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                {{ __('Kérés elutasítva') }}
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                <p>{{ __('Az adatváltozás kérése elutasításra került.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Request Details -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
            <div class="space-y-6">
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Kérés típusa') }}
                        </label>
                        <p class="text-lg text-gray-900 dark:text-white">{{ $dataChangeRequest->dataChangeType->display_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Státusz') }}
                        </label>
                        @if($dataChangeRequest->status === 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                {{ __('Függőben') }}
                            </span>
                        @elseif($dataChangeRequest->status === 'processing')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                {{ __('Feldolgozás alatt') }}
                            </span>
                        @elseif($dataChangeRequest->status === 'approved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                {{ __('Jóváhagyva') }}
                            </span>
                        @elseif($dataChangeRequest->status === 'rejected')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                {{ __('Elutasítva') }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Form Data -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Beküldött adatok') }}</h3>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 space-y-3">
                        @foreach($dataChangeRequest->dataChangeType->form_fields as $field)
                            @php
                                $fieldName = str_replace(' ', '_', $field['name']);
                            @endphp
                            @if(isset($dataChangeRequest->form_data[$fieldName]))
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $field['label'] }}:</span>
                                    <span class="text-gray-900 dark:text-white">
                                        @if($field['type'] === 'select' && isset($field['options_source']) && $field['options_source'] === 'workplaces')
                                            @php
                                                $workplace = \App\Models\Workplace::find($dataChangeRequest->form_data[$fieldName]);
                                            @endphp
                                            {{ $workplace ? $workplace->name . ' (' . $workplace->code . ')' : $dataChangeRequest->form_data[$fieldName] }}
                                        @else
                                            {{ $dataChangeRequest->form_data[$fieldName] }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Attachments -->
                @if($dataChangeRequest->attachments && count($dataChangeRequest->attachments) > 0)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Csatolmányok') }}</h3>
                    <div class="space-y-2">
                        @foreach($dataChangeRequest->attachments as $attachment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $attachment['original_name'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($attachment['size'] / 1024, 1) }} KB</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($attachment['path']) }}" target="_blank"
                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-blue-600 hover:text-blue-500">
                                {{ __('Letöltés') }}
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Admin Notes -->
                @if($dataChangeRequest->admin_notes)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Adminisztrátori megjegyzések') }}</h3>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <p class="text-blue-800 dark:text-blue-200">{{ $dataChangeRequest->admin_notes }}</p>
                    </div>
                </div>
                @endif

                <!-- Timestamps -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Beküldve') }}
                        </label>
                        <p class="text-gray-900 dark:text-white">{{ $dataChangeRequest->created_at->format('Y.m.d H:i') }}</p>
                    </div>
                    @if($dataChangeRequest->processed_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Feldolgozva') }}
                        </label>
                        <p class="text-gray-900 dark:text-white">{{ $dataChangeRequest->processed_at->format('Y.m.d H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('data-change.index') }}" 
               class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Vissza az adatváltozás bejelentéshez') }}
            </a>
        </div>
    </div>
</div>
@endsection
