@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-xs text-slate-600']) }}>
    {{ $value ?? $slot }}
</label>
