@csrf

<div class="grid gap-6 md:grid-cols-2">
    <x-admin.select
        label="Computadora"
        name="computer_id"
        required
    >
        <option value="">Selecciona una computadora</option>

        @foreach ($computers as $computer)
            <option
                value="{{ $computer->id }}"
                @selected(old('computer_id') == $computer->id)
            >
                {{ $computer->name }}
                — {{ $computer->category->name }}
                — S/ {{ number_format($computer->hourly_price, 2) }}/hora
            </option>
        @endforeach
    </x-admin.select>

    <x-admin.input
        label="Fecha de reserva"
        name="reservation_date"
        type="date"
        :value="old('reservation_date')"
        :min="now()->format('Y-m-d')"
        required
    />

    <x-admin.input
        label="Hora de inicio"
        name="start_time"
        type="time"
        :value="old('start_time')"
        required
    />

    <x-admin.input
        label="Duración (horas)"
        name="duration_hours"
        type="number"
        :value="old('duration_hours', 1)"
        min="1"
        max="12"
        required
    />

    <div class="md:col-span-2">
        <x-admin.textarea
            label="Observaciones"
            name="notes"
            :value="old('notes')"
            placeholder="Ejemplo: El cliente solicita audífonos o software específico"
        />
    </div>
</div>

<div class="mt-8 flex flex-wrap items-center gap-3 border-t border-slate-800 pt-6">
    <x-admin.button type="submit">
        Registrar reserva
    </x-admin.button>

    <x-admin.button
        variant="secondary"
        :href="route('admin.reservations.index')"
    >
        Cancelar
    </x-admin.button>
</div>
