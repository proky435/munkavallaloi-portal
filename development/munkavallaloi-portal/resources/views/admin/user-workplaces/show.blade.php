@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }} - {{ __('Munkahely Hozzárendelések') }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.user-workplaces.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Vissza') }}
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Current Status -->
            <div class="lg:col-span-2">
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">{{ __('Jelenlegi Állapot') }}</h2>
                    
                    @php
                        $currentWorkplace = $user->getCurrentWorkplace();
                        $nextTransition = $user->getNextWorkplaceTransition();
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                            <h3 class="font-medium text-green-800 dark:text-green-300">{{ __('Jelenlegi Munkahely') }}</h3>
                            <p class="text-green-600 dark:text-green-400 mt-1">
                                {{ $currentWorkplace ? $currentWorkplace->name : __('Nincs beállítva') }}
                            </p>
                        </div>
                        
                        <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800">
                            <h3 class="font-medium text-amber-800 dark:text-amber-300">{{ __('Következő Váltás') }}</h3>
                            <p class="text-amber-600 dark:text-amber-400 mt-1">
                                @if($nextTransition)
                                    {{ $nextTransition->workplace->name }} ({{ $nextTransition->start_date->format('Y.m.d') }})
                                @else
                                    {{ __('Nincs tervezve') }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Workplace Assignments -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('Munkahely Hozzárendelések') }}</h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Munkahely') }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Időszak') }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Státusz') }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Megjegyzés') }}
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Műveletek') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($user->userWorkplaces->sortBy('start_date') as $assignment)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($assignment->is_primary)
                                                    <svg class="w-4 h-4 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endif
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $assignment->workplace->name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                            @if($assignment->is_permanent)
                                                <span class="text-purple-600 dark:text-purple-400 font-medium">{{ __('Állandó') }}</span>
                                            @else
                                                {{ $assignment->start_date->format('Y.m.d') }} - 
                                                {{ $assignment->end_date ? $assignment->end_date->format('Y.m.d') : __('folyamatban') }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                @if($assignment->status === 'permanent') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                                                @elseif($assignment->status === 'current') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                @elseif($assignment->status === 'future') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                                                @endif">
                                                @if($assignment->status === 'permanent') {{ __('Állandó') }}
                                                @elseif($assignment->status === 'current') {{ __('Jelenlegi') }}
                                                @elseif($assignment->status === 'future') {{ __('Jövőbeli') }}
                                                @else {{ __('Korábbi') }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $assignment->notes ?: '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <button onclick="editAssignment({{ $assignment->id }})" 
                                                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition-colors duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <form action="{{ route('admin.user-workplaces.destroy', [$user, $assignment]) }}" 
                                                      method="POST" class="inline" 
                                                      onsubmit="return confirm('Biztosan törölni szeretné ezt a hozzárendelést?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors duration-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                            <p class="text-lg font-medium">Nincsenek munkahely hozzárendelések</p>
                                            <p class="mt-2">Adjon hozzá egy új hozzárendelést a jobb oldali panelen.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Actions Panel -->
            <div class="space-y-6">
                <!-- Quick Transition -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Gyors Munkahely Váltás') }}</h3>
                    
                    <form action="{{ route('admin.user-workplaces.transition', $user) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="current_workplace_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Jelenlegi Munkahely') }}
                            </label>
                            <select name="current_workplace_id" id="current_workplace_id" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                <option value="">{{ __('Válasszon...') }}</option>
                                @foreach($workplaces as $workplace)
                                    <option value="{{ $workplace->id }}" 
                                            {{ $currentWorkplace && $currentWorkplace->id == $workplace->id ? 'selected' : '' }}>
                                        {{ $workplace->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="new_workplace_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Új Munkahely') }}
                            </label>
                            <select name="new_workplace_id" id="new_workplace_id" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                <option value="">{{ __('Válasszon...') }}</option>
                                @foreach($workplaces as $workplace)
                                    <option value="{{ $workplace->id }}">{{ $workplace->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="transition_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Váltás Dátuma') }}
                            </label>
                            <input type="date" name="transition_date" id="transition_date" required
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Megjegyzés') }}
                            </label>
                            <textarea name="notes" id="notes" rows="3" 
                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Opcionális megjegyzés a váltásról..."></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            {{ __('Váltás Ütemezése') }}
                        </button>
                    </form>
                </div>

                <!-- Add New Assignment -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Új Hozzárendelés') }}</h3>
                    
                    <form action="{{ route('admin.user-workplaces.store', $user) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="workplace_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Munkahely') }}
                            </label>
                            <select name="workplace_id" id="workplace_id" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                <option value="">{{ __('Válasszon...') }}</option>
                                @foreach($workplaces as $workplace)
                                    <option value="{{ $workplace->id }}">{{ $workplace->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Hozzárendelés típusa') }}
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="assignment_type" value="permanent" id="permanent_type"
                                           class="text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('Állandó hozzárendelés') }} 
                                        <span class="text-xs text-gray-500">(időkorlát nélkül)</span>
                                    </span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="assignment_type" value="temporary" id="temporary_type" checked
                                           class="text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('Időszakos hozzárendelés') }}
                                        <span class="text-xs text-gray-500">(dátumokkal)</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div id="date_fields" class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Kezdés') }}
                                </label>
                                <input type="date" name="start_date" id="start_date"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Befejezés') }}
                                </label>
                                <input type="date" name="end_date" id="end_date"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_primary" id="is_primary" value="1"
                                   class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                            <label for="is_primary" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                {{ __('Elsődleges munkahely') }}
                            </label>
                        </div>

                        <div>
                            <label for="assignment_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Megjegyzés') }}
                            </label>
                            <textarea name="notes" id="assignment_notes" rows="3" 
                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Opcionális megjegyzés..."></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('Hozzárendelés Létrehozása') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function editAssignment(assignmentId) {
    // TODO: Implement edit functionality
    alert('Szerkesztés funkció hamarosan elérhető!');
}
</script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const permanentType = document.getElementById('permanent_type');
    const temporaryType = document.getElementById('temporary_type');
    const dateFields = document.getElementById('date_fields');
    const startDateInput = document.getElementById('start_date');
    
    function toggleDateFields() {
        if (permanentType.checked) {
            dateFields.style.display = 'none';
            startDateInput.removeAttribute('required');
        } else {
            dateFields.style.display = 'grid';
            startDateInput.setAttribute('required', 'required');
        }
    }
    
    permanentType.addEventListener('change', toggleDateFields);
    temporaryType.addEventListener('change', toggleDateFields);
    
    // Initial state
    toggleDateFields();
});
</script>
@endpush
