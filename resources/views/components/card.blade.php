@props([
    'title' => null,
    'subtitle' => null,
    'image' => null,
    'imageAlt' => '',
    'href' => null,
    'padding' => 'p-6',
    'shadow' => 'card-shadow',
    'hover' => true,
    'rounded' => 'rounded-lg',
    'background' => 'bg-white'
])

@php
    $classes = [
        'block' => $href,
        'transition-all duration-300' => $hover,
        'hover:shadow-lg hover:-translate-y-1' => $hover && $href,
        'focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2' => $href,
        $background,
        $shadow,
        $rounded,
        $padding
    ];
    
    $classString = collect($classes)
        ->filter(fn($condition, $class) => $condition === true || is_numeric($condition))
        ->keys()
        ->implode(' ');
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $classString }}" role="article" tabindex="0">
        @if($image)
            <div class="mb-4 overflow-hidden {{ $rounded }}">
                <img src="{{ $image }}" alt="{{ $imageAlt }}" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105" loading="lazy">
            </div>
        @endif
        
        @if($title || $subtitle)
            <div class="mb-4">
                @if($title)
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <p class="text-sm text-gray-600 line-clamp-3">{{ $subtitle }}</p>
                @endif
            </div>
        @endif
        
        {{ $slot }}
    </a>
@else
    <div class="{{ $classString }}" role="article">
        @if($image)
            <div class="mb-4 overflow-hidden {{ $rounded }}">
                <img src="{{ $image }}" alt="{{ $imageAlt }}" class="w-full h-48 object-cover" loading="lazy">
            </div>
        @endif
        
        @if($title || $subtitle)
            <div class="mb-4">
                @if($title)
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <p class="text-sm text-gray-600">{{ $subtitle }}</p>
                @endif
            </div>
        @endif
        
        {{ $slot }}
    </div>
@endif