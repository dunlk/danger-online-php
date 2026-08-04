@csrf

@if (isset($category))
    @method('PUT')
@endif

<div class="space-y-6">
    <x-admin.input
        label="Nombre"
        name="name"
        :value="$category->name ?? null"
        placeholder="Ejemplo: Gamer"
        required
    />

    <div>
        <label
            for="description"
            class="mb-2 block text-sm font-medium text-slate-200"
        >
            Descripción
        </label>

        <textarea
            id="description"
            name="description"
            rows="5"
            placeholder="Describe el tipo de computadoras de esta categoría"
            class="w-full resize-none rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10"
        >{{ old('description', $category->description ?? '') }}</textarea>

        @error('description')
            <p class="mt-2 text-sm text-rose-400">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="flex flex-wrap items-center gap-3 border-t border-slate-800 pt-6">
        <x-admin.button type="submit">
            {{ isset($category) ? 'Actualizar categoría' : 'Guardar categoría' }}
        </x-admin.button>

        <x-admin.button
            variant="secondary"
            :href="route('admin.categories.index')"
        >
            Cancelar
        </x-admin.button>
    </div>
</div>
