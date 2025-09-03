<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tudásbázis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="space-y-4">
                        @forelse ($articles as $article)
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <a href="{{ route('articles.show', $article) }}" class="hover:text-indigo-600">{{ $article->title }}</a>
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ Str::limit(strip_tags($article->content), 150) }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500">Jelenleg nincsenek publikált cikkek a tudásbázisban.</p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
