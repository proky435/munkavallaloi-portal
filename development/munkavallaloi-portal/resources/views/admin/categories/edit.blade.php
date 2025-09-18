@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Kategória szerkesztése') }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $category->name }} kategória módosítása</p>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Categories') }}
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Kategória neve') }}</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" required autofocus
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('name') border-red-500 dark:border-red-400 @enderror">
                        @error('name')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="responsible_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Felelős email címe') }}</label>
                        <input id="responsible_email" type="email" name="responsible_email" value="{{ old('responsible_email', $category->responsible_email) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('responsible_email') border-red-500 dark:border-red-400 @enderror">
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Az ebbe a kategóriába tartozó bejelentések automatikusan továbbítva lesznek erre az email címre.</p>
                        @error('responsible_email')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Builder Section -->
                    <div x-data="formBuilderEdit()" class="space-y-4">
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Űrlap mezők konfigurálása') }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Válassza ki és konfigurálja az űrlap mezőket ehhez a kategóriához.</p>
                            
                            <!-- Add Field Dropdown -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Új mező hozzáadása') }}</label>
                                <select x-model="selectedFieldType" @change="addField()" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">{{ __('Válasszon mező típust...') }}</option>
                                    @foreach($formFields as $field)
                                        <option value="{{ $field->id }}" data-type="{{ $field->type }}" data-name="{{ $field->name }}">{{ $field->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Form Fields List -->
                            <div class="space-y-4" x-show="fields.length > 0">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white">{{ __('Hozzáadott mezők') }}</h4>
                                <div class="space-y-3">
                                    <template x-for="(field, index) in fields" :key="index">
                                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300" x-text="field.fieldName"></span>
                                                <button type="button" @click="removeField(index)" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">{{ __('Címke') }}</label>
                                                    <input type="text" x-model="field.label" :name="`form_fields[${index}][label]`" required
                                                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                                    <input type="hidden" :name="`form_fields[${index}][field_id]`" :value="field.fieldId">
                                                    <input type="hidden" :name="`form_fields[${index}][order]`" :value="index">
                                                    <template x-for="(option, optIndex) in field.fieldOptions" :key="optIndex">
                                                        <input type="hidden" :name="`form_fields[${index}][field_options][${optIndex}]`" :value="option">
                                                    </template>
                                                </div>
                                                
                                                <div class="flex items-center">
                                                    <label class="flex items-center">
                                                        <input type="checkbox" x-model="field.isRequired" :name="`form_fields[${index}][is_required]`" value="1"
                                                               class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-400">
                                                        <span class="ml-2 text-xs text-gray-600 dark:text-gray-400">{{ __('Kötelező mező') }}</span>
                                                    </label>
                                                </div>
                                                
                                                <div class="flex items-center space-x-2">
                                                    <button type="button" @click="moveFieldUp(index)" :disabled="index === 0" 
                                                            class="px-2 py-1 text-xs bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded disabled:opacity-50">
                                                        ↑
                                                    </button>
                                                    <button type="button" @click="moveFieldDown(index)" :disabled="index === fields.length - 1"
                                                            class="px-2 py-1 text-xs bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded disabled:opacity-50">
                                                        ↓
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Field Options for Select Fields -->
                                            <div x-show="field.fieldType === 'select'" class="mt-4">
                                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">{{ __('Opciók (soronként egy)') }}</label>
                                                <textarea x-model="field.options" @input="updateFieldOptions(index)" @change="updateFieldOptions(index)" rows="3"
                                                          class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                                          placeholder="Opció 1&#10;Opció 2&#10;Opció 3"></textarea>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        {{ __('Kategória frissítése') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function formBuilderEdit() {
    return {
        fields: {!! json_encode($category->formFields->map(function($field) {
            return [
                'fieldId' => $field->id,
                'fieldName' => $field->name,
                'fieldType' => $field->type,
                'label' => $field->pivot->label,
                'isRequired' => (bool) $field->pivot->is_required,
                'options' => $field->pivot->field_options ? implode("\n", json_decode($field->pivot->field_options, true)) : '',
                'fieldOptions' => $field->pivot->field_options ? json_decode($field->pivot->field_options, true) : []
            ];
        })->toArray()) !!},
        selectedFieldType: '',
        
        addField() {
            if (!this.selectedFieldType) return;
            
            const select = document.querySelector('select[x-model="selectedFieldType"]');
            const selectedOption = select.options[select.selectedIndex];
            
            if (selectedOption) {
                const field = {
                    fieldId: this.selectedFieldType,
                    fieldName: selectedOption.dataset.name,
                    fieldType: selectedOption.dataset.type,
                    label: selectedOption.dataset.name,
                    isRequired: false,
                    options: '',
                    fieldOptions: []
                };
                
                this.fields.push(field);
                this.selectedFieldType = '';
            }
        },
        
        removeField(index) {
            this.fields.splice(index, 1);
        },
        
        moveFieldUp(index) {
            if (index > 0) {
                const field = this.fields.splice(index, 1)[0];
                this.fields.splice(index - 1, 0, field);
            }
        },
        
        moveFieldDown(index) {
            if (index < this.fields.length - 1) {
                const field = this.fields.splice(index, 1)[0];
                this.fields.splice(index + 1, 0, field);
            }
        },
        
        updateFieldOptions(index) {
            const field = this.fields[index];
            if (field.fieldType === 'select') {
                field.fieldOptions = field.options.split('\n').filter(option => option.trim() !== '');
            }
        }
    }
}
</script>
@endsection
