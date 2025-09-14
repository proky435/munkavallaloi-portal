@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Tudásbázis') }}</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('Hasznos információk és útmutatók') }}</p>
        </div>

        @if($articles->count() > 0)
            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                    <div class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-xl border border-gray-200/60 dark:border-gray-600/60 p-6 hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:bg-white/90 dark:hover:bg-gray-700/90">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                    <a href="{{ route('articles.show', $article->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit($article->content, 150) }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500 dark:text-gray-500">
                                        {{ $article->updated_at->format('Y.m.d') }}
                                    </span>
                                    <a href="{{ route('articles.show', $article->slug) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium transition-colors duration-200">
                                        {{ __('Olvasás →') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-xl border border-gray-200/60 dark:border-gray-600/60 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">{{ __('Nincs elérhető cikk') }}</h3>
                <p class="text-gray-500 dark:text-gray-400">{{ __('A tudásbázis jelenleg üres. Kérjük, látogasson vissza később.') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
