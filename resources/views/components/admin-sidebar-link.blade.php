@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-3 py-2 rounded-lg text-white bg-[#1e1e2f] font-semibold transition-colors duration-200 shadow-sm'
            : 'flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="w-5 h-5 flex items-center justify-center {{ ($active ?? false) ? 'text-white' : 'text-gray-500' }}">
        {{ $icon }}
    </span>
    <span x-show="sidebarOpen" x-transition class="text-sm font-medium whitespace-nowrap">{{ $slot }}</span>
</a>
