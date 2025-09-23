@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Bejelentés') }} #{{ $ticket->id }}</h1>
                <p class="mt-2 text-xl text-gray-600 dark:text-gray-400">{{ $ticket->subject }}</p>
                <div class="mt-4 flex items-center space-x-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($ticket->status === 'Új') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                        @elseif($ticket->status === 'Folyamatban') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300
                        @elseif($ticket->status === 'Lezárva') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                        @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 @endif">
                        {{ $ticket->status }}
                    </span>
                    @if($ticket->category)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                            {{ $ticket->category->name }}
                        </span>
                    @endif
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $ticket->created_at->format('Y.m.d H:i') }}
                    </span>
                </div>
            </div>
            <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Vissza') }}
            </a>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Ticket Content -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
            <!-- Original Message -->
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Eredeti üzenet') }}</h3>
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                            <span class="text-sm font-medium text-white">{{ substr($ticket->user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $ticket->message }}</p>
                        </div>
                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ $ticket->user->name }} • {{ $ticket->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                @if($ticket->attachment)
                    <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            <a href="{{ route('tickets.download', $ticket) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                {{ __('Melléklet letöltése') }}
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Dynamic Form Data -->
                @if($ticket->form_data && count($ticket->form_data) > 0)
                    <div class="mt-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Beküldött adatok') }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($ticket->form_data as $fieldId => $fieldData)
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $fieldData['label'] ?? 'Mező #' . $fieldId }}</p>
                                    @if($fieldData['type'] === 'file')
                                        @if(isset($fieldData['path']) && $fieldData['path'])
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                </svg>
                                                <span class="text-blue-600 dark:text-blue-400 text-sm">
                                                    📎 {{ $fieldData['original_name'] ?? basename($fieldData['path']) }}
                                                </span>
                                            </div>
                                        @else
                                            <p class="text-gray-400 dark:text-gray-500 italic text-sm">Nincs fájl csatolva</p>
                                        @endif
                                    @elseif(array_key_exists('value', $fieldData) && !empty($fieldData['value']))
                                        <p class="text-gray-900 dark:text-white">{{ $fieldData['value'] }}</p>
                                    @else
                                        <p class="text-gray-400 dark:text-gray-500 italic text-sm">Nincs megadva</p>
                                    @endif
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Típus: {{ $fieldData['type'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Comments -->
            @if($ticket->comments->count() > 0)
                <div class="border-t border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Válaszok') }}</h3>
                    <div class="space-y-4">
                        @foreach($ticket->comments as $comment)
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full {{ $comment->user->is_admin ? 'bg-gradient-to-r from-green-500 to-blue-500' : 'bg-gradient-to-r from-gray-500 to-gray-600' }} flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">{{ substr($comment->user->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="{{ $comment->user->is_admin ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-gray-50 dark:bg-gray-700/50' }} rounded-lg p-4">
                                        <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $comment->body }}</p>
                                        
                                        @if($comment->attachment_path)
                                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                    </svg>
                                                    <a href="{{ route('comments.download', $comment) }}" 
                                                       class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline">
                                                        {{ $comment->attachment_original_name }}
                                                    </a>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                        ({{ number_format($comment->attachment_size / 1024, 1) }} KB)
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $comment->user->name }}
                                        @if($comment->user->is_admin)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 ml-2">
                                                {{ __('Admin') }}
                                            </span>
                                        @endif
                                        • {{ $comment->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Comment Form -->
            @if($ticket->status !== 'Lezárva')
                <div class="border-t border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Válasz írása') }}</h3>
                    <form method="POST" action="{{ route('tickets.comments.store', $ticket) }}">
                        @csrf
                        <div class="mb-4">
                            <textarea name="body" rows="4" 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200" 
                                placeholder="{{ __('Írjon választ...') }}" 
                                required>{{ old('body') }}</textarea>
                            @error('body')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                {{ __('Válasz küldése') }}
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-200 dark:border-gray-700 p-6">
                    <div class="text-center py-4">
                        <div class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span class="text-gray-600 dark:text-gray-400">{{ __('Ez a bejelentés le van zárva') }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection