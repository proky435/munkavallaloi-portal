@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $dataChangeType->display_name }}</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ $dataChangeType->description }}
            </p>
        </div>

        <!-- Form -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
            <form method="POST" action="{{ route('data-change.store', $dataChangeType) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Dynamic Form Fields -->
                @foreach($dataChangeType->form_fields as $field)
                <div>
                    <label for="{{ str_replace(' ', '_', $field['name']) }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ $field['label'] }}
                        @if($field['required'])
                            <span class="text-red-500">*</span>
                        @endif
                    </label>
                    
                    @if($field['type'] === 'text')
                        <div class="relative">
                            <input id="{{ str_replace(' ', '_', $field['name']) }}" name="{{ str_replace(' ', '_', $field['name']) }}" type="text" 
                                   value="{{ old(str_replace(' ', '_', $field['name'])) }}"
                                   @if($field['required']) required @endif
                                   class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200">
                        </div>
                    @elseif($field['type'] === 'textarea')
                        <div class="relative">
                            <textarea id="{{ str_replace(' ', '_', $field['name']) }}" name="{{ str_replace(' ', '_', $field['name']) }}" rows="4"
                                      @if($field['required']) required @endif
                                      class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200">{{ old(str_replace(' ', '_', $field['name'])) }}</textarea>
                        </div>
                    @elseif($field['type'] === 'date')
                        <div class="relative">
                            <input id="{{ str_replace(' ', '_', $field['name']) }}" name="{{ str_replace(' ', '_', $field['name']) }}" type="date" 
                                   value="{{ old(str_replace(' ', '_', $field['name'])) }}"
                                   @if($field['required']) required @endif
                                   class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200">
                        </div>
                    @elseif($field['validation'] && str_contains($field['validation'], 'numeric'))
                        <div class="relative">
                            <input id="{{ str_replace(' ', '_', $field['name']) }}" name="{{ str_replace(' ', '_', $field['name']) }}" type="number" 
                                   value="{{ old(str_replace(' ', '_', $field['name'])) }}"
                                   min="0" step="0.01"
                                   @if($field['required']) required @endif
                                   class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200">
                        </div>
                    @elseif($field['type'] === 'select' && isset($field['options_source']))
                        <div class="relative">
                            <select id="{{ str_replace(' ', '_', $field['name']) }}" name="{{ str_replace(' ', '_', $field['name']) }}"
                                    @if($field['required']) required @endif
                                    class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200">
                                <option value="">{{ __('Válasszon...') }}</option>
                                @if($field['options_source'] === 'workplaces')
                                    @foreach($workplaces as $workplace)
                                        <option value="{{ $workplace->id }}" {{ old(str_replace(' ', '_', $field['name'])) == $workplace->id ? 'selected' : '' }}>
                                            {{ $workplace->name }} ({{ $workplace->code }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif
                    
                    <x-input-error class="mt-2" :messages="$errors->get(str_replace(' ', '_', $field['name']))" />
                </div>
                @endforeach

                <!-- Document Upload -->
                @if($dataChangeType->required_documents)
                <div>
                    <label for="documents" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Szükséges dokumentumok') }}
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="documents" name="documents[]" type="file" multiple
                               accept=".pdf,.jpg,.jpeg,.png"
                               required
                               class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-colors duration-200">
                    </div>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Szükséges dokumentumok:') }}
                        </p>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach($dataChangeType->required_documents as $doc)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                {{ ucfirst(str_replace('_', ' ', $doc)) }}
                            </span>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ __('Támogatott formátumok: PDF, JPG, PNG. Maximum 5MB fájlonként.') }}
                        </p>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('documents')" />
                </div>
                @endif

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('data-change.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Vissza') }}
                    </a>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        {{ __('Bejelentés elküldése') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
