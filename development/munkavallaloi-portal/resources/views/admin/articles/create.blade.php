@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Create New Article') }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Új cikk létrehozása a tudásbázishoz</p>
            </div>
            <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Articles') }}
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Cím') }}</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('title') border-red-500 dark:border-red-400 @enderror">
                        @error('title')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Tartalom') }}</label>
                        <textarea name="content" id="content" rows="10" required
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('content') border-red-500 dark:border-red-400 @enderror">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="pdf_attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('PDF Melléklet') }}</label>
                        <input type="file" name="pdf_attachment" id="pdf_attachment" accept=".pdf"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('pdf_attachment') border-red-500 dark:border-red-400 @enderror">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Opcionális PDF fájl (max 10MB)') }}</p>
                        @error('pdf_attachment')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <input type="checkbox" name="is_published" id="is_published" value="1" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-400 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700"
                               {{ old('is_published') ? 'checked' : '' }}>
                        <label for="is_published" class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ __('Publikálás') }}
                        </label>
                    </div>
                </div>

                <div class="flex justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('Cikk Létrehozása') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
