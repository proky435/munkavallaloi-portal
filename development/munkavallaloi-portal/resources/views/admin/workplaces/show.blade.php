@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $workplace->name }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Munkahely részletes adatai</p>
            </div>
            <a href="{{ route('admin.workplaces.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg">
                {{ __('Vissza') }}
            </a>
        </div>

        <!-- Workplace Details -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">{{ $workplace->name }}</h2>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Kód</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $workplace->code }}</p>
                </div>
                
                @if($workplace->address)
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Cím</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $workplace->address }}</p>
                </div>
                @endif
                
                @if($workplace->city)
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Város</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $workplace->city }}</p>
                </div>
                @endif
                
                @if($workplace->phone)
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Telefon</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $workplace->phone }}</p>
                </div>
                @endif
            </div>

            <!-- Employees List -->
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    Dolgozók ({{ $workplace->users->count() }})
                </h3>
                
                @if($workplace->users->count() > 0)
                    <div class="space-y-2">
                        @foreach($workplace->users as $user)
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">Nincsenek dolgozók hozzárendelve.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
