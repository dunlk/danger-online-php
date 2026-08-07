@csrf

@if (isset($category))
    @method('PUT')
@endif

<div class="space-y-6">
    <x-admin.input
        label="Nombre"
        name="name"
        :value="old('name', isset($category) ? $category->name : '')"
        placeholder="Ejemplo: Gamer"
        required
    />

    <x-admin.textarea
        label="Descripción"
        name="description"
        :value="old('description', isset($category) ? $category->description : '')"
        placeholder="Describe el tipo de computadoras de esta categoría"
    />

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
