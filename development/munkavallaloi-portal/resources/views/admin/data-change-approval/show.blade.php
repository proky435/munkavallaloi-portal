@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-lg border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        {{ __('Adatváltozás Kérés Részletei') }}
                    </h2>
                    <a href="{{ route('admin.data-change-approval.index') }}" 
                       class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                        {{ __('Vissza a listához') }}
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Ticket Info -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">{{ __('Kérés Információk') }}</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Tárgy:') }}</span>
                                    <p class="text-sm">{{ $ticket->subject }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Státusz:') }}</span>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($ticket->status == 'open') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($ticket->status == 'in_progress') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                        @if($ticket->status == 'open') {{ __('Nyitott') }}
                                        @elseif($ticket->status == 'in_progress') {{ __('Folyamatban') }}
                                        @else {{ __('Lezárt') }} @endif
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Prioritás:') }}</span>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($ticket->priority == 'high') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif($ticket->priority == 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                        @if($ticket->priority == 'high') {{ __('Magas') }}
                                        @elseif($ticket->priority == 'medium') {{ __('Közepes') }}
                                        @else {{ __('Alacsony') }} @endif
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Létrehozva:') }}</span>
                                    <p class="text-sm">{{ $ticket->created_at->format('Y.m.d H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Change Details -->
                        @if(!empty($changeDetails))
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">{{ __('Kért Változtatások') }}</h3>
                            <div class="space-y-3">
                                @foreach($changeDetails as $field => $newValue)
                                    <div class="border-l-4 border-blue-500 pl-4">
                                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $field }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">{{ __('Új érték:') }}</span> {{ $newValue }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Full Description -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">{{ __('Teljes Leírás') }}</h3>
                            <div class="prose dark:prose-invert max-w-none">
                                <pre class="whitespace-pre-wrap text-sm">{{ $ticket->description }}</pre>
                            </div>
                        </div>

                        <!-- Attachments -->
                        @if($ticket->attachments)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">{{ __('Csatolmányok') }}</h3>
                            <div class="space-y-2">
                                @foreach($ticket->attachments as $attachment)
                                    <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-600 rounded border">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            <span class="text-sm">{{ $attachment['name'] ?? 'Csatolmány' }}</span>
                                        </div>
                                        <a href="{{ $attachment['url'] ?? '#' }}" target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                            {{ __('Letöltés') }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Comments -->
                        @if($ticket->comments->count() > 0)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">{{ __('Megjegyzések') }}</h3>
                            <div class="space-y-4">
                                @foreach($ticket->comments as $comment)
                                    <div class="bg-white dark:bg-gray-600 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-sm font-medium mr-3">
                                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium">{{ $comment->user->name }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->format('Y.m.d H:i') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-sm">{{ $comment->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- User Info -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">{{ __('Felhasználó Adatok') }}</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-medium mr-4">
                                        {{ strtoupper(substr($ticket->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $ticket->user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->user->email }}</div>
                                    </div>
                                </div>
                                @if($ticket->user->phone)
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Telefon:') }}</span>
                                    <p class="text-sm">{{ $ticket->user->phone }}</p>
                                </div>
                                @endif
                                @if($ticket->user->workplace)
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Munkahely:') }}</span>
                                    <p class="text-sm">{{ $ticket->user->workplace->name }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        @if($ticket->status !== 'closed')
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">{{ __('Műveletek') }}</h3>
                            
                            <!-- Approve Form -->
                            <form method="POST" action="{{ route('admin.data-change-approval.approve', $ticket) }}" class="mb-4">
                                @csrf
                                <div class="mb-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="apply_changes" value="1" checked 
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm">{{ __('Változtatások automatikus alkalmazása') }}</span>
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <textarea name="admin_notes" rows="3" placeholder="{{ __('Opcionális megjegyzés...') }}"
                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm text-sm"></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                    {{ __('Jóváhagyás') }}
                                </button>
                            </form>

                            <!-- Reject Form -->
                            <form method="POST" action="{{ route('admin.data-change-approval.reject', $ticket) }}">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="admin_notes" rows="3" placeholder="{{ __('Elutasítás indoklása (kötelező)...') }}" required
                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm text-sm"></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors"
                                        onclick="return confirm('{{ __('Biztosan elutasítja ezt a kérést?') }}')">
                                    {{ __('Elutasítás') }}
                                </button>
                            </form>
                        </div>
                        @endif

                        <!-- Admin Notes -->
                        @if($ticket->admin_notes)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">{{ __('Admin Megjegyzések') }}</h3>
                            <p class="text-sm">{{ $ticket->admin_notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
