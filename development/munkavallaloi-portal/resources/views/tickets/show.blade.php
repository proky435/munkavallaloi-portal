<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bejelentés') }}: #{{ $ticket->id }} - {{ $ticket->subject }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Beszélgetésfolyam -->
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Beszélgetés') }}</h3>
                    <div class="space-y-4">
                        <!-- Eredeti üzenet -->
                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0"></div>
                            <div class="w-full">
                                <div class="bg-gray-100 rounded-lg p-3">
                                    <p class="text-sm text-gray-800">{{ $ticket->message }}</p>
                                </div>
                                <span class="text-xs text-gray-500">{{ $ticket->created_at->diffForHumans() }} - {{ $ticket->user->name }}</span>
                            </div>
                        </div>
                        <!-- Válaszok -->
                        @foreach ($ticket->comments as $comment)
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full {{ $comment->user->is_admin ? 'bg-blue-200' : 'bg-gray-200' }} flex-shrink-0"></div>
                                <div class="w-full">
                                    <div class="{{ $comment->user->is_admin ? 'bg-blue-100' : 'bg-gray-100' }} rounded-lg p-3">
                                        <p class="text-sm text-gray-800">{{ $comment->body }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }} - {{ $comment->user->name }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Új hozzászólás űrlap (csak ha a ticket még nincs lezárva) -->
                @if($ticket->status !== 'Lezárva')
                    <div class="p-6 border-t border-gray-200">
                        <form method="POST" action="{{ route('tickets.comments.store', $ticket) }}">
                            @csrf
                            <textarea name="body" rows="4" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="{{ __('Írjon választ...') }}"></textarea>
                            <div class="mt-2 flex justify-end">
                                <x-primary-button>{{ __('Válasz küldése') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>