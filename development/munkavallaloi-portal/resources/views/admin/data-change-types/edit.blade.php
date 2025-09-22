@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-lg border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        {{ __('Adatváltozás Form Szerkesztése') }}
                    </h2>
                </div>

                <form method="POST" action="{{ route('admin.data-change-types.update', $dataChangeType) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Azonosító név') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $dataChangeType->name) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200"
                                   placeholder="pl: salary_change">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Csak angol betűk, számok és aláhúzás</p>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="display_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Megjelenítendő név') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $dataChangeType->display_name) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200"
                                   placeholder="pl: Fizetés módosítás">
                            @error('display_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Leírás') }}
                        </label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200"
                                  placeholder="Rövid leírás a form céljáról">{{ old('description', $dataChangeType->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Fields Configuration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                            {{ __('Form mezők') }} <span class="text-red-500">*</span>
                        </label>
                        
                        <div id="form-fields-container" class="space-y-4">
                            <!-- Dynamic form fields will be loaded here -->
                        </div>
                        
                        <button type="button" id="add-field-btn" 
                                class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('Új mező hozzáadása') }}
                        </button>
                        
                        <!-- Hidden input for JSON data -->
                        <input type="hidden" name="form_fields" id="form_fields_json" required>
                        @error('form_fields')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Required Documents -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                            {{ __('Szükséges dokumentumok') }}
                        </label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <input type="checkbox" name="documents[]" value="identity_document" id="doc_identity" 
                                       {{ in_array('identity_document', $dataChangeType->required_documents ?? []) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="doc_identity" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Személyazonosító okmány') }}</label>
                            </div>
                            <div>
                                <input type="checkbox" name="documents[]" value="marriage_certificate" id="doc_marriage" 
                                       {{ in_array('marriage_certificate', $dataChangeType->required_documents ?? []) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="doc_marriage" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Házassági anyakönyvi kivonat') }}</label>
                            </div>
                            <div>
                                <input type="checkbox" name="documents[]" value="transfer_request" id="doc_transfer" 
                                       {{ in_array('transfer_request', $dataChangeType->required_documents ?? []) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="doc_transfer" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Áthelyezési kérelem') }}</label>
                            </div>
                            <div>
                                <input type="checkbox" name="documents[]" value="address_certificate" id="doc_address" 
                                       {{ in_array('address_certificate', $dataChangeType->required_documents ?? []) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="doc_address" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Lakcímigazolás') }}</label>
                            </div>
                            <div>
                                <input type="checkbox" name="documents[]" value="bank_statement" id="doc_bank" 
                                       {{ in_array('bank_statement', $dataChangeType->required_documents ?? []) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="doc_bank" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Bankszámlakivonat') }}</label>
                            </div>
                            <div>
                                <input type="checkbox" name="documents[]" value="salary_certificate" id="doc_salary" 
                                       {{ in_array('salary_certificate', $dataChangeType->required_documents ?? []) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="doc_salary" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Fizetési igazolás') }}</label>
                            </div>
                        </div>
                        
                        <!-- Hidden input for JSON data -->
                        <input type="hidden" name="required_documents" id="required_documents_json">
                        @error('required_documents')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Settings -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Sorrend') }}
                            </label>
                            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $dataChangeType->sort_order) }}" min="0"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm transition-all duration-200">
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $dataChangeType->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                {{ __('Aktív') }}
                            </label>
                        </div>
                    </div>

                    <!-- Example Box -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('Példa form mezők:') }}</h4>
                        <pre class="text-xs text-gray-600 dark:text-gray-400 overflow-x-auto"><code>[
    {
        "name": "field_name",
        "type": "text|textarea|date|select",
        "label": "Mező címke",
        "required": true|false,
        "validation": "Laravel validációs szabályok",
        "options_source": "workplaces" // csak select típusnál
    }
]</code></pre>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.data-change-types.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('Vissza') }}
                        </a>
                        
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('Módosítások Mentése') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let fieldCounter = 0;
    const formFieldsContainer = document.getElementById('form-fields-container');
    const addFieldBtn = document.getElementById('add-field-btn');
    const formFieldsJson = document.getElementById('form_fields_json');
    const requiredDocsJson = document.getElementById('required_documents_json');
    
    // Existing form fields data
    const existingFields = @json($dataChangeType->form_fields);
    
    // Add field functionality
    addFieldBtn.addEventListener('click', function() {
        addFormField();
    });
    
    function addFormField(existingData = null) {
        fieldCounter++;
        const fieldId = `field_${fieldCounter}`;
        
        const fieldHtml = `
            <div class="form-field-item bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600" data-field-id="${fieldId}">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Mező #${fieldCounter}</h4>
                    <button type="button" class="remove-field text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mező neve (angol)</label>
                        <input type="text" class="field-name w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white" 
                               placeholder="pl: new_salary" value="${existingData?.name || ''}">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Megjelenített címke</label>
                        <input type="text" class="field-label w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white" 
                               placeholder="pl: Új fizetés" value="${existingData?.label || ''}">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mező típusa</label>
                        <select class="field-type w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                            <option value="text" ${existingData?.type === 'text' ? 'selected' : ''}>Rövid szöveg (max 255 karakter)</option>
                            <option value="textarea" ${existingData?.type === 'textarea' ? 'selected' : ''}>Hosszú szöveg (max 1000 karakter)</option>
                            <option value="date" ${existingData?.type === 'date' ? 'selected' : ''}>Dátum (jövőbeli)</option>
                            <option value="number" ${existingData?.type === 'number' || (existingData?.validation && existingData.validation.includes('numeric')) ? 'selected' : ''}>Szám (pozitív)</option>
                            <option value="select" ${existingData?.type === 'select' ? 'selected' : ''}>Munkahely választás</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kötelező-e a mező?</label>
                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <input type="radio" name="field_requirement_${fieldCounter}" value="required" class="field-required text-blue-600 focus:ring-blue-500 border-gray-300" 
                                       ${!existingData || existingData?.required !== false ? 'checked' : ''}>
                                <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Kötelező mező</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="radio" name="field_requirement_${fieldCounter}" value="optional" class="field-optional text-blue-600 focus:ring-blue-500 border-gray-300" 
                                       ${existingData?.validation && existingData.validation.includes('nullable') ? 'checked' : ''}>
                                <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Opcionális mező</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        formFieldsContainer.insertAdjacentHTML('beforeend', fieldHtml);
        
        // Add event listeners for the new field
        const newField = formFieldsContainer.lastElementChild;
        
        // Remove field functionality
        newField.querySelector('.remove-field').addEventListener('click', function() {
            newField.remove();
            updateFormFieldsJson();
        });
        
        // Type change handler
        newField.querySelector('.field-type').addEventListener('change', function() {
            updateFormFieldsJson();
        });
        
        // Update JSON when any field changes
        newField.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', updateFormFieldsJson);
            input.addEventListener('change', updateFormFieldsJson);
        });
        
        updateFormFieldsJson();
    }
    
    function updateFormFieldsJson() {
        const fields = [];
        
        document.querySelectorAll('.form-field-item').forEach(fieldItem => {
            const name = fieldItem.querySelector('.field-name').value;
            const label = fieldItem.querySelector('.field-label').value;
            const type = fieldItem.querySelector('.field-type').value;
            const requiredRadio = fieldItem.querySelector('.field-required').checked;
            const optionalRadio = fieldItem.querySelector('.field-optional').checked;
            
            if (name && label) {
                const field = {
                    name: name,
                    type: type === 'number' ? 'text' : type,
                    label: label,
                    required: requiredRadio
                };
                
                // Auto-generate validation based on type and required/optional status
                let validation = '';
                
                if (requiredRadio) {
                    validation = 'required|';
                } else if (optionalRadio) {
                    validation = 'nullable|';
                } else {
                    validation = 'required|';
                }
                
                switch (type) {
                    case 'text':
                        validation += 'string|max:255';
                        break;
                    case 'textarea':
                        validation += 'string|max:1000';
                        break;
                    case 'date':
                        validation += 'date|after_or_equal:today';
                        break;
                    case 'number':
                        validation += 'numeric|min:0';
                        break;
                    case 'select':
                        validation += 'exists:workplaces,id';
                        field.options_source = 'workplaces';
                        break;
                }
                
                field.validation = validation;
                
                fields.push(field);
            }
        });
        
        formFieldsJson.value = JSON.stringify(fields);
    }
    
    // Update required documents JSON
    function updateRequiredDocsJson() {
        const selectedDocs = [];
        document.querySelectorAll('input[name="documents[]"]:checked').forEach(checkbox => {
            selectedDocs.push(checkbox.value);
        });
        requiredDocsJson.value = selectedDocs.length > 0 ? JSON.stringify(selectedDocs) : '';
    }
    
    // Add event listeners for document checkboxes
    document.querySelectorAll('input[name="documents[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateRequiredDocsJson);
    });
    
    // Load existing fields
    if (existingFields && existingFields.length > 0) {
        existingFields.forEach(fieldData => {
            addFormField(fieldData);
        });
    } else {
        // Add initial empty field if no existing fields
        addFormField();
    }
    
    // Initialize required documents JSON
    updateRequiredDocsJson();
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!formFieldsJson.value || formFieldsJson.value === '[]') {
            e.preventDefault();
            alert('Legalább egy form mezőt hozzá kell adni!');
            return false;
        }
    });
});
</script>
@endsection
