@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Profil') }}</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Kezelje személyes adatait és beállításait</p>
        </div>

        <!-- User Info Summary -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Felhasználói Információk</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-4 rounded-xl border border-blue-200/50 dark:border-blue-700/50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-blue-800 dark:text-blue-300">{{ __('Munkahely') }}</h3>
                            @php
                                $currentWorkplace = auth()->user()->getCurrentWorkplace();
                                $allCurrentWorkplaces = auth()->user()->getAllCurrentWorkplaces();
                                $permanentWorkplaces = auth()->user()->getPermanentWorkplaces();
                                $nextTransition = auth()->user()->getNextWorkplaceTransition();
                                $allAssignments = auth()->user()->getAllWorkplaceAssignments();
                            @endphp
                            
                            <div class="mt-1">
                                <p class="text-blue-600 dark:text-blue-400 font-medium">
                                    {{ $currentWorkplace ? $currentWorkplace->name : (auth()->user()->workplace ?? __('Nincs beállítva')) }}
                                </p>
                                
                                @if($permanentWorkplaces->count() > 0)
                                    <div class="mt-2 p-2 bg-purple-50 dark:bg-purple-900/20 rounded border border-purple-200 dark:border-purple-800">
                                        <p class="text-xs text-purple-700 dark:text-purple-300 font-medium">
                                            🏢 {{ __('Állandó munkahelyek') }}
                                        </p>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($permanentWorkplaces as $workplace)
                                                <span class="inline-block px-2 py-1 text-xs bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300 rounded">
                                                    {{ $workplace->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                @if($allCurrentWorkplaces->count() > 1)
                                    <div class="mt-2 p-2 bg-green-50 dark:bg-green-900/20 rounded border border-green-200 dark:border-green-800">
                                        <p class="text-xs text-green-700 dark:text-green-300 font-medium">
                                            📍 {{ __('Összes jelenlegi munkahely') }}
                                        </p>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($allCurrentWorkplaces as $workplace)
                                                <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 rounded">
                                                    {{ $workplace->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                @if($nextTransition)
                                    <div class="mt-2 p-2 bg-amber-50 dark:bg-amber-900/20 rounded border border-amber-200 dark:border-amber-800">
                                        <p class="text-xs text-amber-700 dark:text-amber-300 font-medium">
                                            🔄 {{ __('Közelgő váltás') }}
                                        </p>
                                        <p class="text-sm text-amber-800 dark:text-amber-200">
                                            {{ $nextTransition->workplace->name }} 
                                            <span class="text-xs">({{ $nextTransition->start_date->format('Y.m.d') }}-től)</span>
                                        </p>
                                    </div>
                                @endif
                                
                                @if($allAssignments->count() > 1)
                                    <button onclick="toggleWorkplaceHistory()" class="mt-2 text-xs text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 underline">
                                        {{ __('Munkahely történet megtekintése') }} ({{ $allAssignments->count() }} {{ __('bejegyzés') }})
                                    </button>
                                    
                                    <div id="workplaceHistory" class="hidden mt-2 space-y-1">
                                        @foreach($allAssignments as $assignment)
                                            <div class="text-xs p-2 bg-gray-50 dark:bg-gray-800 rounded border">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-medium">{{ $assignment->workplace->name }}</span>
                                                    <span class="px-2 py-1 rounded text-xs
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
                                                </div>
                                                <div class="text-gray-600 dark:text-gray-400 mt-1">
                                                    @if($assignment->is_permanent)
                                                        <span class="text-purple-600 dark:text-purple-400 font-medium">{{ __('Állandó hozzárendelés') }}</span>
                                                    @else
                                                        {{ $assignment->start_date->format('Y.m.d') }} - 
                                                        {{ $assignment->end_date ? $assignment->end_date->format('Y.m.d') : __('folyamatban') }}
                                                    @endif
                                                </div>
                                                @if($assignment->notes)
                                                    <div class="text-gray-500 dark:text-gray-500 mt-1 italic">
                                                        {{ $assignment->notes }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 p-4 rounded-xl border border-emerald-200/50 dark:border-emerald-700/50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-full">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-emerald-800 dark:text-emerald-300">{{ __('Szerepkör') }}</h3>
                            <p class="text-emerald-600 dark:text-emerald-400">{{ auth()->user()->role ? auth()->user()->role->display_name : __('Felhasználó') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 p-4 rounded-xl border border-purple-200/50 dark:border-purple-700/50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-purple-800 dark:text-purple-300">Admin jogosultság</h3>
                            <p class="text-purple-600 dark:text-purple-400">{{ auth()->user()->is_admin ? __('Igen') : __('Nem') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="space-y-6">
            <!-- Profile Information -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
                <div class="max-w-4xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Personal Data -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
                <div class="max-w-4xl">
                    @include('profile.partials.update-personal-data-form')
                </div>
            </div>

            <!-- Password -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleWorkplaceHistory() {
    const historyDiv = document.getElementById('workplaceHistory');
    if (historyDiv.classList.contains('hidden')) {
        historyDiv.classList.remove('hidden');
    } else {
        historyDiv.classList.add('hidden');
    }
}
</script>
@endsection
