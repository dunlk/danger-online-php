@props([
    'type' => 'success',
])

@php
    $classes = match ($type) {
        'error' => 'border-red-500/20 bg-red-500/10 text-red-300',
        'warning' => 'border-amber-500/20 bg-amber-500/10 text-amber-300',
        default => 'border-emerald-500/20 bg-emerald-500/10 text-emerald-300',
    };
@endphp

<div
    {{ $attributes->merge([
        'class' => "rounded-2xl border px-5 py-4 text-sm {$classes}",
    ]) }}
>
    {{ $slot }}
</div>
