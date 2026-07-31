@props(['title' => null, 'subtitle' => null, 'icon' => null, 'padded' => true])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden']) }}>
    @if ($title || isset($actions) || isset($leading))
        <div class="px-6 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                @if ($icon)
                    <div class="w-9 h-9 rounded-xl bg-[#e0edf7] text-primary flex items-center justify-center shrink-0">
                        <i class="{{ $icon }} text-lg"></i>
                    </div>
                @endif
                <div class="min-w-0">
                    @if ($title)
                        <h2 class="text-sm font-bold text-slate-800 truncate">{{ $title }}</h2>
                    @endif
                    @if ($subtitle)
                        <p class="text-xs text-slate-400 mt-0.5 truncate">{{ $subtitle }}</p>
                    @endif
                </div>
                @if (isset($leading))
                    <div class="flex items-center gap-2 ml-2">{{ $leading }}</div>
                @endif
            </div>
            @if (isset($actions))
                <div class="flex items-center gap-2">{{ $actions }}</div>
            @endif
        </div>
    @endif
    <div @class(['p-6' => $padded])>
        {{ $slot }}
    </div>
</div>
