<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Irányítópult') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ÚJ: Statisztikai Kártyák -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h4 class="text-sm font-medium text-gray-500">{{ __('Új bejelentések') }}</h4>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['new_tickets'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h4 class="text-sm font-medium text-gray-500">{{ __('Folyamatban lévő') }}</h4>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['in_progress_tickets'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h4 class="text-sm font-medium text-gray-500">{{ __('Összes felhasználó') }}</h4>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Összes bejelentés') }}</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Beküldő') }}</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Téma') }}</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Státusz') }}</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Dátum') }}</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">{{ __('Kezelés') }}</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($tickets as $ticket)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $ticket->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->subject }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
    @if ($ticket->status === 'Új')
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
            {{ __('Új') }}
        </span>
    @elseif ($ticket->status === 'Folyamatban')
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
            {{ __('Folyamatban') }}
        </span>
    @else
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
            {{ __('Lezárva') }}
        </span>
    @endif
</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->created_at->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Kezelés') }}</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ __('Nincsenek bejelentések.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- ÚJ: Lapozó Linkek -->
                   <div class="mt-4">
                       {{ $tickets->links() }}
                   </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>