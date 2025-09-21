@extends('layouts.admin')

@section('title', 'Pengaturan - Admin BPTD')
@section('page-title', 'Pengaturan Aplikasi')
@section('page-description', 'Kelola pengaturan sistem BPTD')

@section('content')
    <!-- Settings Content -->
    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Terjadi Kesalahan!</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Settings Form -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-cog text-primary mr-2"></i>
                    Pengaturan Umum
                </h3>
                <p class="text-sm text-gray-500 mt-1">Kelola pengaturan umum aplikasi</p>
            </div>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="space-y-12">
                    @foreach($settings as $group => $groupSettings)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                            {{ ucfirst($group) }}
                        </h3>
                        
                        <div class="space-y-6 pl-4">
                            @foreach($groupSettings as $setting)
                                <div class="setting-item">
                                    <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ $setting->label }}
                                        @if($setting->required)
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </label>
                                    
                                    @if($setting->description)
                                        <p class="text-xs text-gray-500 mb-2">{{ $setting->description }}</p>
                                    @endif
                                    
                                    @switch($setting->type)
                                        @case('textarea')
                                            <textarea 
                                                id="{{ $setting->key }}" 
                                                name="{{ $setting->key }}" 
                                                rows="3"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                                {{ $setting->required ? 'required' : '' }}
                                            >{{ old($setting->key, $setting->value) }}</textarea>
                                            @break
                                            
                                        @case('number')
                                            <input 
                                                type="number" 
                                                id="{{ $setting->key }}" 
                                                name="{{ $setting->key }}" 
                                                value="{{ old($setting->key, $setting->value) }}"
                                                @if(isset($setting->options['min'])) min="{{ $setting->options['min'] }}" @endif
                                                @if(isset($setting->options['max'])) max="{{ $setting->options['max'] }}" @endif
                                                step="{{ $setting->options['step'] ?? '1' }}"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                                {{ $setting->required ? 'required' : '' }}
                                            >
                                            @break
                                            
                                        @case('select')
                                            <select 
                                                id="{{ $setting->key }}" 
                                                name="{{ $setting->key }}" 
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                                {{ $setting->required ? 'required' : '' }}
                                            >
                                                @if(isset($setting->options) && is_array($setting->options))
                                                    @foreach($setting->options as $value => $label)
                                                        <option value="{{ $value }}" {{ old($setting->key, $setting->value) == $value ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @break
                                            
                                        @case('email')
                                            <input 
                                                type="email" 
                                                id="{{ $setting->key }}" 
                                                name="{{ $setting->key }}" 
                                                value="{{ old($setting->key, $setting->value) }}"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                                {{ $setting->required ? 'required' : '' }}
                                            >
                                            @break
                                            
                                        @case('json')
                                            <textarea 
                                                id="{{ $setting->key }}" 
                                                name="{{ $setting->key }}" 
                                                rows="4"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 font-mono text-sm"
                                                {{ $setting->required ? 'required' : '' }}
                                            >{{ is_string($setting->value) ? $setting->value : json_encode($setting->value, JSON_PRETTY_PRINT) }}</textarea>
                                            @break
                                            
                                        @default
                                            <input 
                                                type="text" 
                                                id="{{ $setting->key }}" 
                                                name="{{ $setting->key }}" 
                                                value="{{ old($setting->key, $setting->value) }}"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                                {{ $setting->required ? 'required' : '' }}
                                            >
                                    @endswitch
                                    
                                    @error($setting->key)
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                                    @break
                                    
                                @case('checkbox')
                                    <div class="flex items-center">
                                        <input 
                                            type="hidden" 
                                            name="{{ $setting->key }}" 
                                            value="0"
                                        >
                                        <input 
                                            type="checkbox" 
                                            id="{{ $setting->key }}" 
                                            name="{{ $setting->key }}" 
                                            value="1"
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                                            {{ old($setting->key, $setting->value) ? 'checked' : '' }}
                                        >
                                        <label for="{{ $setting->key }}" class="ml-2 block text-sm text-gray-700">
                                            {{ $setting->label }}
                                        </label>
                                    </div>
                                    @break
                                    
                                @default
                                    <input 
                                        type="{{ $setting->type }}" 
                                        id="{{ $setting->key }}" 
                                        name="{{ $setting->key }}" 
                                        value="{{ old($setting->key, $setting->value) }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                        {{ $setting->required ? 'required' : '' }}
                                    >
                            @endswitch
                            
                            @error($setting->key)
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-3 border-t border-gray-200 pt-6">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
