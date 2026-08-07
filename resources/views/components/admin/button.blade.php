@props([
    'type' => 'button',
    'variant' => 'primary',
    'href' => null,
])

@php
    $classes = match ($variant) {
        'danger' => 'bg-rose-500 hover:bg-rose-600 focus:ring-rose-500/30',
        'secondary' => 'border border-slate-700 bg-slate-800/70 hover:border-slate-600 hover:bg-slate-700',
        default => 'bg-rose-500 hover:bg-rose-600 focus:ring-rose-500/30 shadow-lg shadow-rose-500/20',
    };
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge([
            'class' => "inline-flex items-center justify-center rounded-xl px-4 py-2.5 text-sm font-semibold text-white transition focus:outline-none focus:ring-4 {$classes}",
        ]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' => "inline-flex items-center justify-center rounded-xl px-4 py-2.5 text-sm font-semibold text-white transition focus:outline-none focus:ring-4 {$classes}",
        ]) }}
    >
        {{ $slot }}
    </button>
@endif
