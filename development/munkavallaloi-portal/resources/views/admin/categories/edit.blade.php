<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kategória szerkesztése') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Kategória neve')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $category->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="responsible_email" :value="__('Felelős email címe')" />
                            <x-text-input id="responsible_email" class="block mt-1 w-full" type="email" name="responsible_email" :value="old('responsible_email', $category->responsible_email)" />
                            <x-input-error :messages="$errors->get('responsible_email')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-600">Az ebbe a kategóriába tartozó bejelentések automatikusan továbbítva lesznek erre az email címre.</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                {{ __('Mégse') }}
                            </a>
                            <x-primary-button>
                                {{ __('Kategória frissítése') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
