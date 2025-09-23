@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-lg border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6 text-gray-900 dark:text-gray-100">
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

                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            {{ __('Adatváltozás Kérés Részletei') }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            {{ __('Kérés azonosító: #') }}{{ $dataChangeRequest->id }}
                        </p>
                    </div>
                    <a href="{{ route('admin.data-change-requests.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Vissza') }}
                    </a>
                </div>

                <!-- Status Update Form -->
                <div class="mb-8 bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Kérés Kezelése') }}</h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Status Update -->
                        <div>
                            <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">{{ __('Státusz Frissítése') }}</h4>
                            <form method="POST" action="{{ route('admin.data-change-requests.update', $dataChangeRequest) }}" class="space-y-4">
                                @csrf
                                @method('PUT')
                                
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Új státusz') }}
                                    </label>
                                    <select name="status" id="status" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                        <option value="pending" {{ $dataChangeRequest->status === 'pending' ? 'selected' : '' }}>{{ __('Függőben') }}</option>
                                        <option value="processing" {{ $dataChangeRequest->status === 'processing' ? 'selected' : '' }}>{{ __('Feldolgozás alatt') }}</option>
                                        <option value="approved" {{ $dataChangeRequest->status === 'approved' ? 'selected' : '' }}>{{ __('Jóváhagyva') }}</option>
                                        <option value="completed" {{ $dataChangeRequest->status === 'completed' ? 'selected' : '' }}>{{ __('Befejezve') }}</option>
                                        <option value="rejected" {{ $dataChangeRequest->status === 'rejected' ? 'selected' : '' }}>{{ __('Elutasítva') }}</option>
                                        <option value="revision_required" {{ $dataChangeRequest->status === 'revision_required' ? 'selected' : '' }}>{{ __('Javításra visszaküldve') }}</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Adminisztrátori megjegyzések') }}
                                    </label>
                                    <textarea name="admin_notes" id="admin_notes" rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                              placeholder="Opcionális megjegyzések...">{{ old('admin_notes', $dataChangeRequest->admin_notes) }}</textarea>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('Státusz Frissítése') }}
                                </button>
                            </form>
                        </div>
                        
                        <!-- Apply Changes -->
                        @if($dataChangeRequest->status === 'approved')
                        <div>
                            <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">{{ __('Adatok Alkalmazása') }}</h4>
                            
                            <!-- Field Mapping Preview -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <h5 class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ __('Alkalmazandó változások:') }}</h5>
                                    <a href="{{ route('admin.field-mapping.preview', $dataChangeRequest) }}" 
                                       class="text-xs text-blue-600 hover:text-blue-800 underline">
                                        {{ __('Részletes elemzés') }}
                                    </a>
                                </div>
                                <div class="space-y-1 text-xs text-blue-700 dark:text-blue-300">
                                    @foreach($dataChangeRequest->form_data as $field => $value)
                                        <div class="flex justify-between">
                                            <span class="font-medium">{{ $field }}:</span>
                                            <span class="truncate ml-2">{{ is_array($value) ? 'Array' : Str::limit($value, 30) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-4">
                                <p class="text-sm text-green-800 dark:text-green-200 mb-3">
                                    {{ __('Ez a kérés jóváhagyásra került. Az adatváltozások alkalmazásához kattintson az alábbi gombra.') }}
                                </p>
                                <p class="text-xs text-green-700 dark:text-green-300">
                                    <strong>{{ __('Figyelem:') }}</strong> {{ __('Az adatok alkalmazása után a változások nem vonhatók vissza könnyen.') }}
                                </p>
                            </div>
                            
                            <!-- Apply Changes Options -->
                            <div class="space-y-4">
                                <!-- Immediate Application -->
                                <form method="POST" action="{{ route('admin.data-change-requests.apply', $dataChangeRequest) }}" 
                                      onsubmit="return confirm('Biztosan azonnal alkalmazni szeretné ezeket az adatváltozásokat?')">
                                    @csrf
                                    @method('POST')
                                    
                                    <button type="submit" 
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ __('Azonnali Alkalmazás') }}
                                    </button>
                                </form>

                                <!-- Scheduled Application -->
                                <div class="border border-blue-200 dark:border-blue-800 rounded-lg p-4 bg-blue-50 dark:bg-blue-900/20">
                                    <h6 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-3">{{ __('Ütemezett Alkalmazás') }}</h6>
                                    <form method="POST" action="{{ route('admin.data-change-requests.apply', $dataChangeRequest) }}" class="space-y-3">
                                        @csrf
                                        @method('POST')
                                        <div>
                                            <label for="scheduled_for" class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-1">
                                                {{ __('Alkalmazás dátuma és ideje') }}
                                            </label>
                                            <input type="datetime-local" 
                                                   id="scheduled_for" 
                                                   name="scheduled_for"
                                                   min="{{ now()->format('Y-m-d\TH:i') }}"
                                                   class="w-full px-3 py-2 border border-blue-300 dark:border-blue-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                                        </div>
                                        <button type="submit" 
                                                onclick="return confirm('Biztosan ütemezni szeretné ezt az adatváltozást?')"
                                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('Ütemezett Alkalmazás') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Request Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Alapadatok') }}</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('Beküldő') }}
                                    </label>
                                    <p class="text-gray-900 dark:text-white">{{ $dataChangeRequest->user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $dataChangeRequest->user->email }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('Kérés típusa') }}
                                    </label>
                                    <p class="text-gray-900 dark:text-white">{{ $dataChangeRequest->dataChangeType->display_name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('Jelenlegi státusz') }}
                                    </label>
                                    @if($dataChangeRequest->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                            {{ __('Függőben') }}
                                        </span>
                                    @elseif($dataChangeRequest->status === 'processing')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ __('Feldolgozás alatt') }}
                                        </span>
                                    @elseif($dataChangeRequest->status === 'approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            {{ __('Jóváhagyva') }}
                                        </span>
                                    @elseif($dataChangeRequest->status === 'rejected')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                            {{ __('Elutasítva') }}
                                        </span>
                                    @elseif($dataChangeRequest->status === 'revision_required')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                                            {{ __('Javításra visszaküldve') }}
                                        </span>
                                    @elseif($dataChangeRequest->status === 'completed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                            {{ __('Befejezve') }}
                                        </span>
                                    @endif
                                    
                                    @if($dataChangeRequest->is_scheduled && $dataChangeRequest->scheduled_for)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 ml-2">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('Ütemezve') }}
                                        </span>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('Beküldve') }}
                                    </label>
                                    <p class="text-gray-900 dark:text-white">{{ $dataChangeRequest->created_at->format('Y.m.d H:i') }}</p>
                                </div>
                                
                                @if($dataChangeRequest->processed_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('Feldolgozva') }}
                                    </label>
                                    <p class="text-gray-900 dark:text-white">{{ $dataChangeRequest->processed_at->format('Y.m.d H:i') }}</p>
                                </div>
                                @endif
                                
                                @if($dataChangeRequest->is_scheduled && $dataChangeRequest->scheduled_for)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('Ütemezett alkalmazás') }}
                                    </label>
                                    <p class="text-gray-900 dark:text-white">{{ $dataChangeRequest->scheduled_for->format('Y.m.d H:i') }}</p>
                                    @if($dataChangeRequest->reminder_sent_at)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ __('Emlékeztető elküldve:') }} {{ $dataChangeRequest->reminder_sent_at->format('Y.m.d H:i') }}
                                        </p>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Form Data -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Beküldött adatok') }}</h3>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 space-y-3">
                                @foreach($dataChangeRequest->dataChangeType->form_fields as $field)
                                    @php
                                        $fieldName = str_replace(' ', '_', $field['name']);
                                    @endphp
                                    @if(isset($dataChangeRequest->form_data[$fieldName]))
                                        <div class="border-b border-gray-200 dark:border-gray-600 pb-2 last:border-b-0">
                                            <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $field['label'] }}:</span>
                                            <span class="text-gray-900 dark:text-white">
                                                @if($field['type'] === 'select' && isset($field['options_source']) && $field['options_source'] === 'workplaces')
                                                    @php
                                                        $workplace = \App\Models\Workplace::find($dataChangeRequest->form_data[$fieldName]);
                                                    @endphp
                                                    {{ $workplace ? $workplace->name . ' (' . $workplace->code . ')' : $dataChangeRequest->form_data[$fieldName] }}
                                                @elseif($field['type'] === 'textarea')
                                                    <pre class="whitespace-pre-wrap text-sm">{{ $dataChangeRequest->form_data[$fieldName] }}</pre>
                                                @else
                                                    {{ $dataChangeRequest->form_data[$fieldName] }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Attachments -->
                        @if($dataChangeRequest->attachments && count($dataChangeRequest->attachments) > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Csatolmányok') }}</h3>
                            <div class="space-y-2">
                                @foreach($dataChangeRequest->attachments as $attachment)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $attachment['original_name'] }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($attachment['size'] / 1024, 1) }} KB</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($attachment['path']) }}" target="_blank"
                                       class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-blue-600 hover:text-blue-500">
                                        {{ __('Letöltés') }}
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Admin Notes -->
                        @if($dataChangeRequest->admin_notes)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Adminisztrátori megjegyzések') }}</h3>
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                <p class="text-blue-800 dark:text-blue-200">{{ $dataChangeRequest->admin_notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
