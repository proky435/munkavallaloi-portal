@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Create New User') }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Új felhasználó létrehozása a rendszerben</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Users') }}
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('name') border-red-500 dark:border-red-400 @enderror">
                    @error('name')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('email') border-red-500 dark:border-red-400 @enderror">
                    @error('email')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Password') }}</label>
                    <input type="password" name="password" id="password" 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('password') border-red-500 dark:border-red-400 @enderror">
                    @error('password')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
                </div>

                <div>
                    <label for="workplace" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Workplace') }}</label>
                    <select name="workplace" id="workplace" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('workplace') border-red-500 dark:border-red-400 @enderror">
                        <option value="">{{ __('Select Workplace') }}</option>
                        <option value="Brema" {{ old('workplace') == 'Brema' ? 'selected' : '' }}>Brema</option>
                        <option value="Boden" {{ old('workplace') == 'Boden' ? 'selected' : '' }}>Boden</option>
                        <option value="Tarragona" {{ old('workplace') == 'Tarragona' ? 'selected' : '' }}>Tarragona</option>
                    </select>
                    @error('workplace')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Role') }}</label>
                    <select name="role_id" id="role_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 @error('role_id') border-red-500 dark:border-red-400 @enderror">
                        <option value="">{{ __('No Role') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8">
                <div class="flex items-center">
                    <input type="checkbox" name="is_admin" id="is_admin" value="1" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-400 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700"
                           {{ old('is_admin') ? 'checked' : '' }}>
                    <label for="is_admin" class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                        {{ __('Admin User') }}
                    </label>
                </div>
                @error('is_admin')
                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('Accessible Categories') }}</label>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('Select categories this user can manage (leave empty for super admin access)') }}</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($categories as $category)
                        <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <input type="checkbox" name="accessible_categories[]" value="{{ $category->id }}" id="cat_{{ $category->id }}"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-400 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700"
                                   {{ in_array($category->id, old('accessible_categories', [])) ? 'checked' : '' }}>
                            <label for="cat_{{ $category->id }}" class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ $category->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('accessible_categories')
                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Create User') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
