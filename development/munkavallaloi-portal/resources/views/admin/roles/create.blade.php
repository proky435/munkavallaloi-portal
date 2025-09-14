@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Create New Role') }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Új szerepkör létrehozása jogosultságokkal</p>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Roles') }}
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Role Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('name') border-red-500 dark:border-red-400 @enderror">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Internal role identifier (e.g., hr_admin, finance_admin)') }}</p>
                    @error('name')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="display_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Display Name') }}</label>
                    <input type="text" name="display_name" id="display_name" value="{{ old('display_name') }}" 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('display_name') border-red-500 dark:border-red-400 @enderror">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Human-readable role name') }}</p>
                    @error('display_name')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Description') }}</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('description') border-red-500 dark:border-red-400 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('Permissions') }}</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($availablePermissions as $permission => $label)
                            <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <input type="checkbox" name="permissions[]" value="{{ $permission }}" id="perm_{{ $permission }}"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-400 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700"
                                       {{ in_array($permission, old('permissions', [])) ? 'checked' : '' }}>
                                <label for="perm_{{ $permission }}" class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('permissions')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Create Role') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
