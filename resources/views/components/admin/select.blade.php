@props([
    'label',
    'name',
])

<div>
    <label
        for="{{ $name }}"
        class="mb-2 block text-sm font-medium text-slate-200"
    >
        {{ $label }}
    </label>

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'w-full rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none transition focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10',
        ]) }}
    >
        {{ $slot }}
    </select>

    @error($name)
        <p class="mt-2 text-sm text-rose-400">
            {{ $message }}
        </p>
    @enderror
</div>
