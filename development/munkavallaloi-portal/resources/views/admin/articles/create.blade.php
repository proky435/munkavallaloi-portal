<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Új Cikk Létrehozása
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.articles.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">Cím</label>
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('title') }}" required>
                        </div>

                        <div class="mt-4">
                            <label for="content" class="block font-medium text-sm text-gray-700">Tartalom</label>
                            <textarea name="content" id="content" rows="10" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('content') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="is_published" class="inline-flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ms-2 text-sm text-gray-600">Publikálás</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.articles.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Mégse</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Cikk Létrehozása
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
