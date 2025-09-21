@props([
    'type' => 'info', // success, error, warning, info
    'title' => null,
    'dismissible' => false,
    'icon' => null,
    'rounded' => 'rounded-md'
])

@php
    $alertId = 'alert_' . uniqid();
    
    $typeConfig = [
        'success' => [
            'classes' => 'bg-green-50 border-green-200 text-green-800',
            'icon' => $icon ?: 'fas fa-check-circle',
            'iconColor' => 'text-green-400'
        ],
        'error' => [
            'classes' => 'bg-red-50 border-red-200 text-red-800',
            'icon' => $icon ?: 'fas fa-exclamation-circle',
            'iconColor' => 'text-red-400'
        ],
        'warning' => [
            'classes' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
            'icon' => $icon ?: 'fas fa-exclamation-triangle',
            'iconColor' => 'text-yellow-400'
        ],
        'info' => [
            'classes' => 'bg-blue-50 border-blue-200 text-blue-800',
            'icon' => $icon ?: 'fas fa-info-circle',
            'iconColor' => 'text-blue-400'
        ]
    ];
    
    $config = $typeConfig[$type] ?? $typeConfig['info'];
    
    $classes = collect([
        'border p-4',
        $config['classes'],
        $rounded,
        'fade-in'
    ])->implode(' ');
@endphp

<div 
    id="{{ $alertId }}"
    class="{{ $classes }}"
    role="alert"
    aria-live="polite"
    {{ $attributes }}
>
    <div class="flex items-start">
        @if($config['icon'])
            <div class="flex-shrink-0">
                <i class="{{ $config['icon'] }} {{ $config['iconColor'] }} text-lg" aria-hidden="true"></i>
            </div>
        @endif
        
        <div class="{{ $config['icon'] ? 'ml-3' : '' }} flex-1">
            @if($title)
                <h3 class="text-sm font-medium mb-1">
                    {{ $title }}
                </h3>
            @endif
            
            <div class="text-sm {{ $title ? '' : 'font-medium' }}">
                {{ $slot }}
            </div>
        </div>
        
        @if($dismissible)
            <div class="ml-auto pl-3">
                <button 
                    type="button"
                    class="inline-flex {{ $config['iconColor'] }} hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-transparent focus:ring-current rounded-md p-1.5 transition-opacity"
                    onclick="document.getElementById('{{ $alertId }}').remove()"
                    aria-label="Dismiss alert"
                >
                    <span class="sr-only">Dismiss</span>
                    <i class="fas fa-times text-sm" aria-hidden="true"></i>
                </button>
            </div>
        @endif
    </div>
</div>