@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-lg border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            {{ __('Field Mapping Kezelés') }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            {{ __('Form mezők és felhasználói adatok közötti kapcsolatok kezelése') }}
                        </p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Vissza') }}
                    </a>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-blue-100">Összes mező</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $allFormFields->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-green-100">Leképezett</p>
                                <p class="text-2xl font-bold text-green-600">{{ count($currentMappings) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-red-100">Nincs mapping</p>
                                <p class="text-2xl font-bold text-red-600">{{ $unmappedFields->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/20 border border-gray-200 dark:border-gray-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-100">Kihagyott</p>
                                <p class="text-2xl font-bold text-gray-600">{{ collect($currentMappings)->filter(fn($v) => $v === null)->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Field Mapping Form -->
                <div class="space-y-8">
                    <!-- Unmapped Fields -->
                    @if($unmappedFields->count() > 0)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            {{ __('Leképezetlen Mezők') }}
                        </h3>
                        
                        <form method="POST" action="{{ route('admin.field-mapping.update') }}" class="space-y-4">
                            @csrf
                            
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                                <p class="text-sm text-red-800 dark:text-red-200 mb-4">
                                    {{ __('Ezek a mezők még nincsenek leképezve. Válassza ki, hogy melyik felhasználói adathoz tartoznak, vagy hagyja őket kihagyva.') }}
                                </p>
                                
                                <div class="space-y-4">
                                    @foreach($unmappedFields as $fieldData)
                                    @php
                                        $field = is_array($fieldData) ? $fieldData['name'] : $fieldData;
                                        $description = is_array($fieldData) ? $fieldData['description'] : 'Ismeretlen mező';
                                        $suggestion = is_array($fieldData) ? $fieldData['suggestion'] : null;
                                        $sampleValue = is_array($fieldData) ? $fieldData['sample_value'] : '';
                                        $fieldType = is_array($fieldData) ? $fieldData['type'] : 'unknown';
                                        
                                        // Create a readable suggestion text
                                        $suggestionText = '';
                                        if ($suggestion === null) {
                                            $suggestionText = 'Kihagyva (nem felhasználói adat)';
                                        } elseif ($suggestion === false) {
                                            $suggestionText = 'Ismeretlen - kézi beállítás szükséges';
                                        } else {
                                            $suggestionText = $suggestion;
                                        }
                                    @endphp
                                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                                                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-lg text-sm font-mono mr-3">
                                                        {{ $field }}
                                                    </span>
                                                    <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded text-xs">
                                                        {{ ucfirst($fieldType) }}
                                                    </span>
                                                </label>
                                                
                                                @if($suggestion !== false)
                                                    <div class="mb-2">
                                                        <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded text-xs">
                                                            {{ __('Javaslat:') }} {{ $suggestionText }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="mb-2">
                                                        <span class="bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200 px-2 py-1 rounded text-xs">
                                                            {{ __('Javaslat:') }} {{ $suggestionText }}
                                                        </span>
                                                    </div>
                                                @endif
                                                
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                                    {{ $description }}
                                                </p>
                                                
                                                @if($sampleValue)
                                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                                        {{ __('Példa érték:') }} 
                                                        <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">
                                                            @if(is_array($sampleValue))
                                                                {{ Str::limit(json_encode($sampleValue), 50) }}
                                                            @else
                                                                {{ Str::limit($sampleValue, 50) }}
                                                            @endif
                                                        </code>
                                                    </p>
                                                @endif
                                            </div>
                                            <select name="mappings[{{ $field }}]" 
                                                    class="w-64 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                                                <option value="">{{ __('Válasszon...') }}</option>
                                            <option value="name">{{ __('Név (name)') }}</option>
                                            <option value="email">{{ __('Email (email)') }}</option>
                                            <option value="phone">{{ __('Telefon (phone)') }}</option>
                                            <option value="birth_date">{{ __('Születési dátum (birth_date)') }}</option>
                                            <option value="birth_place">{{ __('Születési hely (birth_place)') }}</option>
                                            <option value="address_street">{{ __('Utca, házszám (address_street)') }}</option>
                                            <option value="address_city">{{ __('Város (address_city)') }}</option>
                                            <option value="address_postal_code">{{ __('Irányítószám (address_postal_code)') }}</option>
                                            <option value="address_country">{{ __('Ország (address_country)') }}</option>
                                            <option value="bank_account">{{ __('Bankszámlaszám (bank_account)') }}</option>
                                            <option value="tax_number">{{ __('Adószám (tax_number)') }}</option>
                                            <option value="social_security_number">{{ __('TAJ szám (social_security_number)') }}</option>
                                            <option value="emergency_contact_name">{{ __('Vészhelyzeti kapcsolattartó neve (emergency_contact_name)') }}</option>
                                            <option value="emergency_contact_phone">{{ __('Vészhelyzeti kapcsolattartó telefonja (emergency_contact_phone)') }}</option>
                                            <option value="workplace_id">{{ __('Munkahely (workplace_id)') }}</option>
                                            <option value="null">{{ __('Kihagyva (nem felhasználói adat)') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-6 flex items-center justify-between">
                                    <button type="button" 
                                            onclick="applyAllSuggestions()"
                                            class="inline-flex items-center px-4 py-2 border border-green-300 rounded-lg shadow-sm text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        {{ __('Javaslatok Alkalmazása') }}
                                    </button>
                                    
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ __('Mapping-ek Mentése') }}
                                    </button>
                                </div>

                                <script>
                                function applyAllSuggestions() {
                                    let appliedCount = 0;
                                    @foreach($unmappedFields as $fieldData)
                                    @php
                                        $field = is_array($fieldData) ? $fieldData['name'] : $fieldData;
                                        $suggestion = is_array($fieldData) ? $fieldData['suggestion'] : null;
                                    @endphp
                                    @if($suggestion && $suggestion !== false)
                                    const select{{ $loop->index }} = document.querySelector('select[name="mappings[{{ $field }}]"]');
                                    if (select{{ $loop->index }}) {
                                        @if($suggestion === null)
                                        select{{ $loop->index }}.value = 'null';
                                        @else
                                        select{{ $loop->index }}.value = '{{ $suggestion }}';
                                        @endif
                                        appliedCount++;
                                    }
                                    @endif
                                    @endforeach
                                    
                                    // Visual feedback
                                    const button = event.target;
                                    const originalText = button.innerHTML;
                                    button.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Alkalmazva!';
                                    button.classList.add('bg-green-200');
                                    
                                    setTimeout(() => {
                                        button.innerHTML = originalText;
                                        button.classList.remove('bg-green-200');
                                    }, 2000);
                                    
                                    // Show notification
                                    if (appliedCount > 0) {
                                        alert(`${appliedCount} javaslat alkalmazva! Most mentsd el a változásokat.`);
                                    } else {
                                        alert('Nincsenek alkalmazható javaslatok.');
                                    }
                                }
                                </script>
                            </div>
                        </form>
                    </div>
                    @endif

                    <!-- Current Mappings -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('Jelenlegi Mapping-ek') }}
                        </h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Form Mező') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Felhasználói Adat') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Státusz') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Műveletek') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($currentMappings as $formField => $userAttribute)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $formField }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($userAttribute === null)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">
                                                    {{ __('Kihagyva') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    {{ $userAttribute }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($userAttribute === null)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">
                                                    {{ __('Nem alkalmazva') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    {{ __('Alkalmazva lesz') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form method="POST" action="{{ route('admin.field-mapping.delete', $formField) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Biztosan törölni szeretné ezt a mapping-et?')"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    {{ __('Törlés') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('Nincsenek mapping-ek definiálva.') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
