<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kezelés') }}: #{{ $ticket->id }} - {{ $ticket->subject }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Bal oldali oszlop: Adatok -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Bejelentés Részletei') }}</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ __('Beküldő') }}</p>
                                <p class="text-sm text-gray-900">{{ $ticket->user->name }} ({{ $ticket->user->email }})</p>
                            </div>
                            @if($ticket->attachment)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">{{ __('Csatolmány') }}</p>
                                    <a href="{{ route('tickets.download', $ticket) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">{{ __('Letöltés') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Jobb oldali oszlop: Műveletek -->
                    <div>
                         <h3 class="text-lg font-medium text-gray-900">{{ __('Műveletek') }}</h3>
                         <form method="POST" action="{{ route('admin.tickets.update', $ticket) }}" class="mt-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Státusz') }}</label>
                                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="Új" @selected($ticket->status === 'Új')>{{ __('Új') }}</option>
                                    <option value="Folyamatban" @selected($ticket->status === 'Folyamatban')>{{ __('Folyamatban') }}</option>
                                    <option value="Lezárva" @selected($ticket->status === 'Lezárva')>{{ __('Lezárva') }}</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                 <x-primary-button>
                                    {{ __('Státusz frissítése') }}
                                </x-primary-button>
                            </div>
                         </form>
                    </div>
                </div>

                <!-- Beszélgetésfolyam -->
                <div class="p-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Beszélgetés</h3>
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

                    <!-- Új hozzászólás űrlap -->
                    <div class="mt-6">
                        <form method="POST" action="{{ route('admin.tickets.comments.store', $ticket) }}">
                            @csrf
                            <textarea name="body" rows="4" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Írjon választ..."></textarea>
                            <div class="mt-2 flex justify-end">
                                <x-primary-button>Válasz küldése</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
