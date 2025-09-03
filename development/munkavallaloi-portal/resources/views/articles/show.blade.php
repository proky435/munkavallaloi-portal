 <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tudásbázis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $article->title }}</h1>
                    <p class="text-sm text-gray-500 mt-2">Publikálva: {{ $article->created_at->format('Y. F d.') }}</p>

                    <div class="mt-6 prose max-w-none">
                        {!! $article->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>