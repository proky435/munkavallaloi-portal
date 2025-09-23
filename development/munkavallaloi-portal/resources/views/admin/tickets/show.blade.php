@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ __('Bejelentés Kezelése') }} #{{ $ticket->id }}
                    </h1>
                    <x-help-tooltip 
                        title="Bejelentés Kezelése"
                        content="<strong>Kezelési lépések:</strong><br>
                        1. <strong>Státusz:</strong> Módosítsa a bejelentés állapotát<br>
                        2. <strong>Válasz:</strong> Írjon részletes választ a felhasználónak<br>
                        3. <strong>Melléklet:</strong> Csatoljon dokumentumokat a válaszhoz<br>
                        4. <strong>Prioritás:</strong> Állítsa be a sürgősségi szintet<br><br>
                        <strong>Fájl típusok:</strong> PDF, DOC, DOCX, JPG, PNG, TXT (max 10MB)<br>
                        <strong>Értesítés:</strong> A felhasználó automatikusan értesítést kap!" />
                </div>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    {{ $ticket->subject ?: ($ticket->form_data ? 'Dinamikus űrlap alapú bejelentés' : 'Bejelentés részletei') }}
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Vissza a jegyekhez') }}
                </a>
                @php
                    $statusColors = [
                        'Új' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-300 dark:border-red-700',
                        'Folyamatban' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-300 dark:border-yellow-700',
                        'Lezárva' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-700'
                    ];
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600' }}">
                    {{ $ticket->status }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Ticket Details -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="bg-gray-50/80 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200/50 dark:border-gray-600/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Bejelentés Részletei') }}</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- User Info -->
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                                {{ substr($ticket->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $ticket->user->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->user->email }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $ticket->created_at->format('Y.m.d H:i') }}</p>
                            </div>
                        </div>

                        <!-- Category -->
                        @if($ticket->category)
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Kategória') }}</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                {{ $ticket->category->name }}
                            </span>
                        </div>
                        @endif

                        <!-- Dynamic Form Data or Traditional Message -->
                        @if($ticket->form_data && is_array($ticket->form_data) && !empty($ticket->form_data))
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">{{ __('Dinamikus űrlap adatok') }}</p>
                            <div class="space-y-4">
                                @foreach($ticket->form_data as $fieldId => $fieldData)
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $fieldData['label'] ?? 'Mező #' . $fieldId }}</p>
                                        @if($fieldData['type'] === 'file')
                                            @if(isset($fieldData['path']) && $fieldData['path'])
                                                <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                                    📎 {{ $fieldData['original_name'] ?? basename($fieldData['path']) }}
                                                </a>
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
                        @elseif($ticket->subject === 'Lakás - Bejelentés' && $ticket->message === 'Dinamikus űrlap alapján létrehozott bejelentés')
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Dinamikus űrlap') }}</p>
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-200 mb-1">{{ __('Üres űrlap') }}</h4>
                                        <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                            {{ __('Ez a bejelentés dinamikus űrlapból jött, de nem tartalmaz kitöltött adatokat. A felhasználó valószínűleg üres űrlapot küldött el.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Üzenet') }}</p>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <p class="text-gray-900 dark:text-white">{{ $ticket->message ?: 'Nincs üzenet' }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Attachment -->
                        @if($ticket->attachment)
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Csatolmány') }}</p>
                            <a href="{{ route('tickets.download', $ticket) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-lg hover:bg-indigo-200 dark:hover:bg-indigo-900/50 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ __('Letöltés') }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Status Management -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="bg-gray-50/80 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200/50 dark:border-gray-600/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Műveletek') }}</h3>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.tickets.update', $ticket) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Státusz') }}</label>
                                <select id="status" name="status" 
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
                                    <option value="Új" @selected($ticket->status === 'Új')>{{ __('Új') }}</option>
                                    <option value="Folyamatban" @selected($ticket->status === 'Folyamatban')>{{ __('Folyamatban') }}</option>
                                    <option value="Lezárva" @selected($ticket->status === 'Lezárva')>{{ __('Lezárva') }}</option>
                                </select>
                            </div>
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('Státusz frissítése') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="bg-gray-50/80 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200/50 dark:border-gray-600/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Információk') }}</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Létrehozva') }}</p>
                            <p class="text-gray-900 dark:text-white">{{ $ticket->created_at->format('Y.m.d H:i') }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $ticket->created_at->diffForHumans() }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Utoljára frissítve') }}</p>
                            <p class="text-gray-900 dark:text-white">{{ $ticket->updated_at->format('Y.m.d H:i') }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $ticket->updated_at->diffForHumans() }}</p>
                        </div>
                        @if($ticket->form_data)
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Űrlap típus') }}</p>
                            <p class="text-gray-900 dark:text-white">{{ __('Dinamikus űrlap') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="bg-gray-50/80 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200/50 dark:border-gray-600/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Beszélgetés') }}</h3>
                    </div>
                    <div class="p-6">
                        <!-- Conversation -->
                        <div class="space-y-6 max-h-96 overflow-y-auto">
                            @if(!$ticket->form_data && $ticket->message)
                            <div class="flex space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center text-white font-semibold text-xs flex-shrink-0">
                                    {{ substr($ticket->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="bg-gray-100 dark:bg-gray-700 rounded-xl px-3 py-2">
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $ticket->message }}</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $ticket->created_at->diffForHumans() }} - {{ $ticket->user->name }}
                                    </p>
                                </div>
                            </div>
                            @endif

                            <!-- Comments -->
                            @foreach($ticket->comments as $comment)
                            <div class="flex space-x-3">
                                @php
                                    $isAdmin = $comment->user->is_admin || ($comment->user->role && ($comment->user->hasRole('super_admin') || $comment->user->hasRole('admin')));
                                @endphp
                                <div class="w-8 h-8 bg-gradient-to-br {{ $isAdmin ? 'from-blue-500 to-blue-600' : 'from-gray-400 to-gray-500' }} rounded-full flex items-center justify-center text-white font-semibold text-xs flex-shrink-0">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="bg-{{ $isAdmin ? 'blue-100' : 'gray-100' }} dark:bg-{{ $isAdmin ? 'blue-900/30' : 'gray-700' }} rounded-xl px-3 py-2">
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $comment->body }}</p>
                                        
                                        @if($comment->attachment_path)
                                            <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                    </svg>
                                                    <a href="{{ route('comments.download', $comment) }}" 
                                                       class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline">
                                                        {{ $comment->attachment_original_name }}
                                                    </a>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                        ({{ number_format($comment->attachment_size / 1024, 1) }} KB)
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $comment->created_at->diffForHumans() }} - {{ $comment->user->name }}
                                        @if($isAdmin)
                                            <span class="text-blue-600 dark:text-blue-400">(Admin)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Reply Form -->
                        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <form method="POST" action="{{ route('admin.tickets.comments.store', $ticket) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Válasz') }}</label>
                                    <textarea name="body" id="body" rows="3" required
                                              class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200"
                                              placeholder="Írjon választ..."></textarea>
                                    @error('body')
                                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Melléklet') }}</label>
                                    <input type="file" name="attachment" id="attachment" 
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt"
                                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Opcionális fájl (PDF, DOC, DOCX, JPG, PNG, TXT - max 10MB)') }}</p>
                                    @error('attachment')
                                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        {{ __('Küldés') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
