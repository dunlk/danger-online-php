@csrf

@if (isset($computer))
    @method('PUT')
@endif

<div class="grid gap-6 md:grid-cols-2">
    <x-admin.select
        label="Categoría"
        name="category_id"
        required
    >
        <option value="">Selecciona una categoría</option>

        @foreach ($categories as $category)
            <option
                value="{{ $category->id }}"
                @selected(
                    old('category_id', $computer->category_id ?? null)
                    == $category->id
                )
            >
                {{ $category->name }}
            </option>
        @endforeach
    </x-admin.select>

    <x-admin.input
        label="Nombre"
        name="name"
        :value="$computer->name ?? null"
        placeholder="Ejemplo: PC-01"
        required
    />

    <x-admin.input
        label="Procesador"
        name="processor"
        :value="$computer->processor ?? null"
        placeholder="Ejemplo: Ryzen 5 5600"
        required
    />

    <x-admin.input
        label="RAM (GB)"
        name="ram"
        type="number"
        :value="$computer->ram ?? null"
        min="1"
        max="1024"
        placeholder="16"
        required
    />

    <x-admin.input
        label="Tarjeta gráfica"
        name="graphics"
        :value="$computer->graphics ?? null"
        placeholder="Ejemplo: RTX 3060"
    />

    <x-admin.input
        label="Almacenamiento"
        name="storage"
        :value="$computer->storage ?? null"
        placeholder="Ejemplo: SSD NVMe 1 TB"
        required
    />

    <x-admin.input
        label="Monitor"
        name="monitor"
        :value="$computer->monitor ?? null"
        placeholder='Ejemplo: 24" 144 Hz'
    />

    <x-admin.input
        label="Precio por hora"
        name="hourly_price"
        type="number"
        :value="$computer->hourly_price ?? null"
        min="0"
        step="0.10"
        placeholder="4.50"
        required
    />

    <x-admin.select
        label="Estado"
        name="status"
        required
    >
        <option
            value="available"
            @selected(old('status', $computer->status ?? 'available') === 'available')
        >
            Disponible
        </option>

        <option
            value="occupied"
            @selected(old('status', $computer->status ?? null) === 'occupied')
        >
            Ocupada
        </option>

        <option
            value="maintenance"
            @selected(old('status', $computer->status ?? null) === 'maintenance')
        >
            En mantenimiento
        </option>

        <option
            value="disabled"
            @selected(old('status', $computer->status ?? null) === 'disabled')
        >
            Deshabilitada
        </option>
    </x-admin.select>

    <div>
        <label
            for="image"
            class="mb-2 block text-sm font-medium text-slate-200"
        >
            Imagen
        </label>

        <input
            id="image"
            name="image"
            type="file"
            accept=".jpg,.jpeg,.png,.webp"
            class="block w-full rounded-xl border border-slate-700 bg-[#0d1b31] text-sm text-slate-300 file:mr-4 file:border-0 file:bg-rose-500 file:px-4 file:py-3 file:font-semibold file:text-white hover:file:bg-rose-600"
        >

        @error('image')
            <p class="mt-2 text-sm text-rose-400">
                {{ $message }}
            </p>
        @enderror

        @if (isset($computer) && $computer->image)
            <div class="mt-4">
                <p class="mb-2 text-xs uppercase tracking-wide text-slate-500">
                    Imagen actual
                </p>

                <img
                    src="{{ asset('storage/' . $computer->image) }}"
                    alt="{{ $computer->name }}"
                    class="h-32 w-48 rounded-xl border border-slate-700 object-cover"
                >
            </div>
        @endif
    </div>

    <div class="md:col-span-2">
        <x-admin.textarea
            label="Descripción"
            name="description"
            :value="$computer->description ?? null"
            placeholder="Describe las características o el uso recomendado de esta computadora"
        />
    </div>
</div>

<div class="mt-8 flex flex-wrap items-center gap-3 border-t border-slate-800 pt-6">
    <x-admin.button type="submit">
        {{ isset($computer) ? 'Actualizar computadora' : 'Guardar computadora' }}
    </x-admin.button>

    <x-admin.button
        variant="secondary"
        :href="route('admin.computers.index')"
    >
        Cancelar
    </x-admin.button>
</div>
