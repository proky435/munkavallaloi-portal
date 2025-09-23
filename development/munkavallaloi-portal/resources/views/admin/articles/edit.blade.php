 <x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12">
        <!-- Header -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Cikk szerkesztése') }}</h1>
            <p class="text-gray-600 dark:text-gray-400">{{ __('Módosítsa a cikk részleteit') }}</p>
        </div>

        <!-- Back Button -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Articles') }}
            </a>
        </div>

        <!-- Form Container -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
                <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Cím') }}</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('title') border-red-500 dark:border-red-400 @enderror">
                            @error('title')
                                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Tartalom') }}</label>
                            <textarea name="content" id="content" rows="10" required
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('content') border-red-500 dark:border-red-400 @enderror">{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pdf_attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('PDF Melléklet') }}</label>
                            @if($article->pdf_attachment)
                                <div class="mb-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm text-green-700 dark:text-green-300">{{ $article->pdf_original_name }}</span>
                                            <span class="text-xs text-green-600 dark:text-green-400 ml-2">({{ number_format($article->pdf_size / 1024, 1) }} KB)</span>
                                        </div>
                                        <a href="{{ asset('storage/' . $article->pdf_attachment) }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                            {{ __('Megtekintés') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="pdf_attachment" id="pdf_attachment" accept=".pdf"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('pdf_attachment') border-red-500 dark:border-red-400 @enderror">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Új PDF fájl feltöltése (max 10MB). A régi fájl felülíródik.') }}</p>
                            @error('pdf_attachment')
                                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <input type="checkbox" name="is_published" id="is_published" value="1" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-400 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700"
                                   {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                            <label for="is_published" class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ __('Publikálás') }}
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 mt-8">
                        <a href="{{ route('admin.articles.index') }}" class="px-6 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 font-medium transition-colors duration-200">
                            {{ __('Mégse') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('Módosítások Mentése') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>