@props(['color' => 'slate'])

@php
    $colors = [
        'green' => 'bg-emerald-50 border border-emerald-200 text-emerald-700',
        'amber' => 'bg-amber-50 border border-amber-200 text-amber-600',
        'navy' => 'bg-[#e0edf7] border border-[#0a3a60]/20 text-[#0a3a60]',
        'orange' => 'bg-[#fde9d0] border border-[#f7941d]/30 text-[#d97d10]',
        'red' => 'bg-rose-50 border border-rose-200 text-rose-600',
        'blue' => 'bg-blue-50 border border-blue-200 text-blue-700',
        'slate' => 'bg-slate-100 border border-slate-200 text-slate-600',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide ' . ($colors[$color] ?? $colors['slate'])]) }}>
    {{ $slot }}
</span>
