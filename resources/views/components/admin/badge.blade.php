@props([
    'variant' => 'default',
])

@php
    $classes = match ($variant) {
        'success' => 'bg-emerald-500/10 text-emerald-300 ring-emerald-500/20',
        'warning' => 'bg-amber-500/10 text-amber-300 ring-amber-500/20',
        'danger' => 'bg-red-500/10 text-red-300 ring-red-500/20',
        'info' => 'bg-blue-500/10 text-blue-300 ring-blue-500/20',
        default => 'bg-slate-700/50 text-slate-300 ring-slate-600/40',
    };
@endphp

<span
    {{ $attributes->merge([
        'class' => "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {$classes}",
    ]) }}
>
    {{ $slot }}
</span>
