@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, outline, ghost, danger
    'size' => 'md', // sm, md, lg, xl
    'href' => null,
    'disabled' => false,
    'loading' => false,
    'icon' => null,
    'iconPosition' => 'left', // left, right
    'fullWidth' => false,
    'rounded' => 'rounded-md'
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variantClasses = [
        'primary' => 'bg-primary text-white hover:bg-primary-light focus:ring-primary',
        'secondary' => 'bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-500',
        'outline' => 'border-2 border-primary text-primary bg-transparent hover:bg-primary hover:text-white focus:ring-primary',
        'ghost' => 'text-primary bg-transparent hover:bg-primary hover:bg-opacity-10 focus:ring-primary',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500'
    ];
    
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'xl' => 'px-8 py-4 text-lg'
    ];
    
    $classes = collect([
        $baseClasses,
        $variantClasses[$variant] ?? $variantClasses['primary'],
        $sizeClasses[$size] ?? $sizeClasses['md'],
        $rounded,
        $fullWidth ? 'w-full' : '',
        $loading ? 'cursor-wait' : ''
    ])->filter()->implode(' ');
@endphp

@if($href && !$disabled)
    <a href="{{ $href }}" class="{{ $classes }}" role="button" {{ $attributes->except(['type', 'disabled']) }}>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Loading...
        @else
            @if($icon && $iconPosition === 'left')
                <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'mr-2' : '' }}" aria-hidden="true"></i>
            @endif
            
            {{ $slot }}
            
            @if($icon && $iconPosition === 'right')
                <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'ml-2' : '' }}" aria-hidden="true"></i>
            @endif
        @endif
    </a>
@else
    <button 
        type="{{ $type }}"
        class="{{ $classes }}"
        {{ $disabled || $loading ? 'disabled' : '' }}
        {{ $attributes }}
        aria-busy="{{ $loading ? 'true' : 'false' }}"
    >
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="sr-only">Loading...</span>
        @else
            @if($icon && $iconPosition === 'left')
                <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'mr-2' : '' }}" aria-hidden="true"></i>
            @endif
            
            {{ $slot }}
            
            @if($icon && $iconPosition === 'right')
                <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'ml-2' : '' }}" aria-hidden="true"></i>
            @endif
        @endif
    </button>
@endif