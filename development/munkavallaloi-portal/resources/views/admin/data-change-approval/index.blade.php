@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-lg border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        {{ __('Adatváltozás Jóváhagyás') }}
                    </h2>
                </div>

                <!-- Filters -->
                <div class="mb-6 bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                    <form method="GET" class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-48">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="{{ __('Keresés név vagy email alapján...') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm">
                        </div>
                        <div>
                            <select name="status" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm">
                                <option value="">{{ __('Minden státusz') }}</option>
                                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>{{ __('Nyitott') }}</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('Folyamatban') }}</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>{{ __('Lezárt') }}</option>
                            </select>
                        </div>
                        <div>
                            <select name="priority" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm">
                                <option value="">{{ __('Minden prioritás') }}</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>{{ __('Alacsony') }}</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>{{ __('Közepes') }}</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>{{ __('Magas') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            {{ __('Szűrés') }}
                        </button>
                        <a href="{{ route('admin.data-change-approval.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                            {{ __('Törlés') }}
                        </a>
                    </form>
                </div>

                @if($tickets->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Felhasználó') }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Tárgy') }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Prioritás') }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Státusz') }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Létrehozva') }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Műveletek') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($tickets as $ticket)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-medium">
                                                        {{ strtoupper(substr($ticket->user->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $ticket->user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $ticket->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ Str::limit($ticket->subject, 50) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($ticket->priority == 'high') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @elseif($ticket->priority == 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                                @if($ticket->priority == 'high') {{ __('Magas') }}
                                                @elseif($ticket->priority == 'medium') {{ __('Közepes') }}
                                                @else {{ __('Alacsony') }} @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($ticket->status == 'open') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @elseif($ticket->status == 'in_progress') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                                @if($ticket->status == 'open') {{ __('Nyitott') }}
                                                @elseif($ticket->status == 'in_progress') {{ __('Folyamatban') }}
                                                @else {{ __('Lezárt') }} @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $ticket->created_at->format('Y.m.d H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.data-change-approval.show', $ticket) }}" 
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                                                {{ __('Megtekintés') }}
                                            </a>
                                            @if($ticket->status !== 'closed')
                                                <button onclick="quickApprove({{ $ticket->id }})" 
                                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3">
                                                    {{ __('Gyors jóváhagyás') }}
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $tickets->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Nincsenek adatváltozás kérések') }}</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Jelenleg nincsenek feldolgozásra váró adatváltozás kérések.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Approval Modal -->
<div id="quickApprovalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Gyors jóváhagyás') }}</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Biztosan jóváhagyja ezt az adatváltozás kérést?') }}
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmApproval" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                    {{ __('Jóváhagyás') }}
                </button>
                <button onclick="closeQuickApprovalModal()" class="mt-3 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    {{ __('Mégse') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentTicketId = null;

function quickApprove(ticketId) {
    currentTicketId = ticketId;
    document.getElementById('quickApprovalModal').classList.remove('hidden');
}

function closeQuickApprovalModal() {
    document.getElementById('quickApprovalModal').classList.add('hidden');
    currentTicketId = null;
}

document.getElementById('confirmApproval').addEventListener('click', function() {
    if (currentTicketId) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/data-change-approval/${currentTicketId}/approve`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        const applyChanges = document.createElement('input');
        applyChanges.type = 'hidden';
        applyChanges.name = 'apply_changes';
        applyChanges.value = '1';
        form.appendChild(applyChanges);
        
        document.body.appendChild(form);
        form.submit();
    }
});
</script>
@endsection
