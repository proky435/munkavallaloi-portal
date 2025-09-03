@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-6">{{ __('Tudásbázis') }}</h1>
                
                @forelse ($articles as $article)
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                        <h2 class="text-xl font-semibold mb-2">
                            <a href="{{ route('articles.show', $article->slug) }}" class="text-blue-600 hover:text-blue-800">
                                {{ $article->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 mb-2">{{ Str::limit($article->content, 200) }}</p>
                        <p class="text-sm text-gray-500">{{ __('Utolsó frissítés') }}: {{ $article->updated_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">{{ __('Nincsenek elérhető cikkek.') }}</p>
                @endforelse
                
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
