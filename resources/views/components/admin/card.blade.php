@props([
    'padding' => true,
])

<div
    {{ $attributes->merge([
        'class' => 'rounded-2xl border border-slate-800 bg-[#0b1930]/90 shadow-2xl shadow-black/20 backdrop-blur-xl'
            . ($padding ? ' p-6 sm:p-8' : ''),
    ]) }}
>
    {{ $slot }}
</div>
