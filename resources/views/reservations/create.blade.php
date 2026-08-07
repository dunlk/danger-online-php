<x-layouts.public :title="'Reservar ' . $computer->name">
    <div class="mx-auto max-w-4xl space-y-8 pt-[55px]">
        <div>
            <a
                href="{{ route('computers.show', $computer) }}"
                class="text-sm text-slate-400 transition hover:text-white"
            >
                ← Volver a {{ $computer->name }}
            </a>

            <p class="mt-8 text-sm font-medium text-rose-400">
                Reserva
            </p>

            <h1 class="mt-2 text-4xl font-bold text-white">
                Reservar {{ $computer->name }}
            </h1>

            <p class="mt-3 text-slate-400">
                Selecciona la fecha, hora y duración de tu reserva.
            </p>
        </div>

        @if ($errors->any())
            <x-admin.alert type="error">
                <p class="font-semibold">
                    No se pudo registrar la reserva.
                </p>

                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-admin.alert>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            <x-admin.card class="lg:col-span-1">
                @if ($computer->image)
                    <img
                        src="{{ asset('storage/' . $computer->image) }}"
                        alt="{{ $computer->name }}"
                        class="aspect-[4/3] w-full rounded-xl object-cover"
                    >
                @endif

                <h2 class="mt-5 text-xl font-bold text-white">
                    {{ $computer->name }}
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    {{ $computer->category->name }}
                </p>

                <div class="mt-5 border-t border-slate-800 pt-5">
                    <p class="text-sm text-slate-400">
                        Precio por hora
                    </p>

                    <p class="mt-1 text-3xl font-bold text-white">
                        S/ {{ number_format($computer->hourly_price, 2) }}
                    </p>
                </div>
            </x-admin.card>

            <x-admin.card class="lg:col-span-2">
                <form
                    action="{{ route('reservations.store', $computer) }}"
                    method="POST"
                >
                    @csrf

                    <input
                        type="hidden"
                        name="computer_id"
                        value="{{ $computer->id }}"
                    >

                    <div class="grid gap-6 sm:grid-cols-2">
                        <x-admin.input
                            label="Fecha"
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

                        <div class="rounded-xl border border-slate-800 bg-slate-900/40 p-4">
                            <p class="text-sm text-slate-400">
                                Precio estimado
                            </p>

                            <p
                                id="estimated-price"
                                class="mt-2 text-2xl font-bold text-white"
                            >
                                S/ {{ number_format($computer->hourly_price * old('duration_hours', 1), 2) }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                S/ {{ number_format($computer->hourly_price, 2) }} por hora
                            </p>
                        </div>

                        <div class="sm:col-span-2">
                            <x-admin.textarea
                                label="Observaciones"
                                name="notes"
                                :value="old('notes')"
                                placeholder="Alguna indicación adicional..."
                            />
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-3 border-t border-slate-800 pt-6">
                        <x-admin.button type="submit">
                            Confirmar reserva
                        </x-admin.button>

                        <x-admin.button
                            variant="secondary"
                            :href="route('computers.show', $computer)"
                        >
                            Cancelar
                        </x-admin.button>
                    </div>
                </form>
            </x-admin.card>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const durationInput = document.getElementById('duration_hours');
        const estimatedPrice = document.getElementById('estimated-price');

        const hourlyPrice = {{ (float) $computer->hourly_price }};

        const updatePrice = () => {
            const hours = Number(durationInput.value) || 0;
            const total = hourlyPrice * hours;

            estimatedPrice.textContent = `S/ ${total.toFixed(2)}`;
        };

        durationInput.addEventListener('input', updatePrice);

        updatePrice();
    });
</script>
</x-layouts.public>
