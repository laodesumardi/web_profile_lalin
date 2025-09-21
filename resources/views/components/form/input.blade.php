@props([
    'type' => 'text',
    'name' => '',
    'label' => null,
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => null,
    'help' => null,
    'icon' => null,
    'iconPosition' => 'left', // left, right
    'size' => 'md', // sm, md, lg
    'rounded' => 'rounded-md'
])

@php
    $inputId = $name ?: 'input_' . uniqid();
    
    $baseClasses = 'block w-full border-gray-300 focus:border-primary focus:ring-primary transition-colors duration-200';
    
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-4 py-3 text-base'
    ];
    
    $errorClasses = $error ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '';
    $disabledClasses = $disabled ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '';
    
    $inputClasses = collect([
        $baseClasses,
        $sizeClasses[$size] ?? $sizeClasses['md'],
        $rounded,
        $errorClasses,
        $disabledClasses,
        $icon ? ($iconPosition === 'left' ? 'pl-10' : 'pr-10') : ''
    ])->filter()->implode(' ');
@endphp

<div class="space-y-1">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-1" aria-label="required">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 {{ $iconPosition === 'left' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                <i class="{{ $icon }} text-gray-400" aria-hidden="true"></i>
            </div>
        @endif
        
        <input
            type="{{ $type }}"
            id="{{ $inputId }}"
            name="{{ $name }}"
            class="{{ $inputClasses }}"
            placeholder="{{ $placeholder }}"
            value="{{ old($name, $value) }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $attributes }}
            @if($error) aria-invalid="true" aria-describedby="{{ $inputId }}-error" @endif
            @if($help) aria-describedby="{{ $inputId }}-help" @endif
        >
    </div>
    
    @if($error)
        <p id="{{ $inputId }}-error" class="text-sm text-red-600" role="alert">
            <i class="fas fa-exclamation-circle mr-1" aria-hidden="true"></i>
            {{ $error }}
        </p>
    @endif
    
    @if($help && !$error)
        <p id="{{ $inputId }}-help" class="text-sm text-gray-500">
            {{ $help }}
        </p>
    @endif
</div>