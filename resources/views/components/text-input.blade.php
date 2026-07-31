@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-slate-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm px-3 py-2 text-sm text-slate-800 bg-white']) }}>
