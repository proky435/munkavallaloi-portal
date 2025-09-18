@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Új bejelentés') }}</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Válasszon kategóriát és töltse ki a szükséges mezőket</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
            <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data" x-data="dynamicTicketForm()">
                @csrf

                <!-- Category Selection -->
                <div class="mb-6">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Kategória') }}</label>
                    <select id="category_id" name="category_id" x-model="selectedCategory" @change="loadCategoryForm()" 
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('category_id') border-red-500 dark:border-red-400 @enderror" required>
                        <option value="">{{ __('-- Válassz kategóriát --') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Loading Indicator -->
                <div x-show="loading" class="flex items-center justify-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                    <span class="ml-2 text-gray-600 dark:text-gray-400">{{ __('Űrlap betöltése...') }}</span>
                </div>

                <!-- Dynamic Form Fields -->
                <div x-show="formFields.length > 0 && !loading" class="space-y-6">
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4" x-text="categoryName + ' - Űrlap mezők'"></h3>
                        
                        <div class="space-y-4">
                            <template x-for="(field, index) in formFields" :key="field.id">
                                <div class="form-field">
                                    <!-- Text Input -->
                                    <template x-if="field.type === 'text' || field.type === 'email' || field.type === 'tel'">
                                        <div>
                                            <label :for="`field_${field.id}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <span x-text="field.label"></span>
                                                <span x-show="field.is_required" class="text-red-500">*</span>
                                            </label>
                                            <input :type="field.type" :id="`field_${field.id}`" :name="`form_data[${field.id}]`" 
                                                   :required="field.is_required"
                                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
                                        </div>
                                    </template>

                                    <!-- Textarea -->
                                    <template x-if="field.type === 'textarea'">
                                        <div>
                                            <label :for="`field_${field.id}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <span x-text="field.label"></span>
                                                <span x-show="field.is_required" class="text-red-500">*</span>
                                            </label>
                                            <textarea :id="`field_${field.id}`" :name="`form_data[${field.id}]`" rows="4"
                                                      :required="field.is_required"
                                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200"></textarea>
                                        </div>
                                    </template>

                                    <!-- Select Dropdown -->
                                    <template x-if="field.type === 'select'">
                                        <div>
                                            <label :for="`field_${field.id}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <span x-text="field.label"></span>
                                                <span x-show="field.is_required" class="text-red-500">*</span>
                                            </label>
                                            <select :id="`field_${field.id}`" :name="`form_data[${field.id}]`" 
                                                    :required="field.is_required"
                                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
                                                <option value="">{{ __('-- Válasszon --') }}</option>
                                                <template x-for="option in field.field_options" :key="option">
                                                    <option :value="option" x-text="option"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </template>

                                    <!-- Date Input -->
                                    <template x-if="field.type === 'date'">
                                        <div>
                                            <label :for="`field_${field.id}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <span x-text="field.label"></span>
                                                <span x-show="field.is_required" class="text-red-500">*</span>
                                            </label>
                                            <input type="date" :id="`field_${field.id}`" :name="`form_data[${field.id}]`" 
                                                   :required="field.is_required"
                                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
                                        </div>
                                    </template>

                                    <!-- File Input -->
                                    <template x-if="field.type === 'file'">
                                        <div>
                                            <label :for="`field_${field.id}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <span x-text="field.label"></span>
                                                <span x-show="field.is_required" class="text-red-500">*</span>
                                            </label>
                                            <input type="file" :id="`field_${field.id}`" :name="`form_data[${field.id}]`" 
                                                   :required="field.is_required"
                                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
                                        </div>
                                    </template>

                                    <!-- Checkbox -->
                                    <div x-show="field.type === 'checkbox'">
                                        <label class="flex items-center">
                                            <input type="checkbox" :id="`field_${field.id}`" :name="`form_data[${field.id}]`" value="1"
                                                   :required="field.is_required"
                                                   class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-400">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                <span x-text="field.label"></span>
                                                <span x-show="field.is_required" class="text-red-500">*</span>
                                            </span>
                                        </label>
                                    </div>

                                    <!-- Number/Currency Input -->
                                    <template x-if="field.type === 'number' || field.type === 'currency'">
                                        <div>
                                            <label :for="`field_${field.id}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <span x-text="field.label"></span>
                                                <span x-show="field.is_required" class="text-red-500">*</span>
                                            </label>
                                            <input type="number" :id="`field_${field.id}`" :name="`form_data[${field.id}]`" 
                                                   :required="field.is_required" step="0.01" min="0"
                                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" :disabled="!selectedCategory || loading" 
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 disabled:from-gray-400 disabled:to-gray-500 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        {{ __('Bejelentés küldése') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function dynamicTicketForm() {
    return {
        selectedCategory: '{{ old('category_id') }}',
        formFields: [],
        categoryName: '',
        loading: false,
        async loadCategoryForm() {
            if (!this.selectedCategory) {
                this.formFields = [];
                return;
            }
            
            this.loading = true;
            
            try {
                const response = await fetch(`/api/categories/${this.selectedCategory}/form`);
                const data = await response.json();
                
                if (data.success) {
                    this.formFields = data.form_fields;
                    this.categoryName = data.category.name;
                } else {
                    console.error('Failed to load form fields');
                    this.formFields = [];
                }
            } catch (error) {
                console.error('Error loading form fields:', error);
                this.formFields = [];
            } finally {
                this.loading = false;
            }
        },
        
        init() {
            // Load form fields if category is pre-selected (from old input)
            if (this.selectedCategory) {
                this.loadCategoryForm();
            }
        }
    }
}
</script>
@endsection