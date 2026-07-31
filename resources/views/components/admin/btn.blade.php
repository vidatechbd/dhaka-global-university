@props(['variant' => 'primary', 'type' => 'button', 'href' => null, 'size' => 'md'])

@php
    $variants = [
        'primary' => 'bg-primary hover:bg-primaryDark text-white shadow-md shadow-primary/20',
        'secondary' => 'bg-secondary hover:bg-secondaryDark text-white shadow-md shadow-secondary/25',
        'outline' => 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50',
        'ghost' => 'text-slate-500 hover:bg-slate-100 hover:text-slate-700',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white shadow-md shadow-rose-600/20',
        'danger-soft' => 'bg-rose-50 hover:bg-rose-100 text-rose-600',
        'amber-soft' => 'bg-amber-50 hover:bg-amber-100 text-amber-700',
        'navy-soft' => 'bg-[#e0edf7] hover:bg-[#d0e2f2] text-[#0a3a60]',
    ];

    $sizes = [
        'sm' => 'px-2.5 py-1.5 text-[10px] rounded-lg',
        'md' => 'px-4 py-2 text-xs rounded-lg',
        'lg' => 'px-6 py-3 text-sm rounded-xl',
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-2 font-bold transition-colors cursor-pointer ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary'])]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => 'inline-flex items-center justify-center gap-2 font-bold transition-colors cursor-pointer ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary'])]) }}>
        {{ $slot }}
    </button>
@endif
