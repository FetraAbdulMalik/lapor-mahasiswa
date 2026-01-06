@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, outline, danger, success
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'iconPosition' => 'left', // left, right
    'animated' => true,
    'disabled' => false,
])

@php
    $baseClass = 'btn-with-icon inline-flex items-center justify-center gap-2 font-semibold rounded-lg transition-all duration-300';
    
    // Size variants
    $sizeClass = match($size) {
        'sm' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-8 py-3 text-lg',
        default => 'px-4 py-2 text-base',
    };
    
    // Color variants
    $colorClass = match($variant) {
        'secondary' => 'bg-navy-600 hover:bg-navy-700 text-white shadow-md hover:shadow-lg active:scale-95 active:shadow-inner',
        'outline' => 'border-2 border-navy-600 text-navy-600 hover:bg-navy-50 active:scale-95 active:bg-navy-100',
        'danger' => 'bg-red-500 hover:bg-red-600 text-white shadow-md hover:shadow-lg active:scale-95 active:shadow-inner',
        'success' => 'bg-green-500 hover:bg-green-600 text-white shadow-md hover:shadow-lg active:scale-95 active:shadow-inner',
        default => 'bg-cyan-500 hover:bg-cyan-600 text-white shadow-md hover:shadow-lg active:scale-95 active:shadow-inner',
    };
    
    $disabledClass = $disabled ? 'opacity-50 cursor-not-allowed' : '';
    
    $elementTag = $href ? 'a' : ($type === 'submit' ? 'button' : 'button');
@endphp

@if($elementTag === 'a')
    <a href="{{ $href }}" 
       class="{{ $baseClass }} {{ $sizeClass }} {{ $colorClass }} {{ $disabledClass }}"
       @if($disabled) onclick="return false;" @endif
       x-data="{ clicked: false }"
       @click="clicked = true; setTimeout(() => clicked = false, 400)"
       :class="clicked ? 'scale-95' : 'scale-100'">
        
        @if($icon && $iconPosition === 'left')
            <span class="icon-animated icon-glow transition-all duration-300"
                  :class="clicked ? 'scale-110 rotate-12' : 'scale-100'">
                {!! $icon !!}
            </span>
        @endif
        
        <span class="text-animated">{{ $slot }}</span>
        
        @if($icon && $iconPosition === 'right')
            <span class="icon-animated icon-glow transition-all duration-300"
                  :class="clicked ? 'scale-110 rotate-12' : 'scale-100'">
                {!! $icon !!}
            </span>
        @endif
    </a>
@else
    <button type="{{ $type }}" 
            class="{{ $baseClass }} {{ $sizeClass }} {{ $colorClass }} {{ $disabledClass }}"
            @if($disabled) disabled @endif
            x-data="{ clicked: false }"
            @click="clicked = true; setTimeout(() => clicked = false, 400)"
            :class="clicked ? 'scale-95' : 'scale-100'">
        
        @if($icon && $iconPosition === 'left')
            <span class="icon-animated icon-glow transition-all duration-300"
                  :class="clicked ? 'scale-110 rotate-12' : 'scale-100'">
                {!! $icon !!}
            </span>
        @endif
        
        <span class="text-animated">{{ $slot }}</span>
        
        @if($icon && $iconPosition === 'right')
            <span class="icon-animated icon-glow transition-all duration-300"
                  :class="clicked ? 'scale-110 rotate-12' : 'scale-100'">
                {!! $icon !!}
            </span>
        @endif
    </button>
@endif
