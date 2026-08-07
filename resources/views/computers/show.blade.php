<x-layouts.public :title="$computer->name">
    <div class="space-y-8 mt-[55px]">
        <a
            href="{{ route('computers.index') }}"
            class="inline-flex items-center gap-2 text-sm text-slate-400 transition hover:text-white"
        >
            ← Volver al catálogo
        </a>

        <div class="grid gap-10 items- lg:grid-cols-2">

            {{-- Imagen --}}
            <div class="overflow-hidden flex flex-col text-white rounded-3xl border border-slate-800 bg-[#0b1930]">
                @if ($computer->image)
                    <img
                        src="{{ asset('storage/' . $computer->image) }}"
                        alt="{{ $computer->name }}"
                        class="aspect-[16/10] w-full object-cover"
                    />

                @endif
                <div class="text-center mt-5 h-full my-auto">
                    <h2 class="text-xl font-semibold">Descripción</h2>

                    <p class="mt-2">
                        {{ $computer->description ?: 'No se ha agregado una descripción para esta computadora.' }}
                    </p>
                </div>
            </div>

            {{-- Información --}}
            <div class="flex flex-col">

                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm font-medium text-rose-400">
                            {{ $computer->category->name }}
                        </p>

                        <h1 class="mt-2 text-4xl font-bold text-white">
                            {{ $computer->name }}
                        </h1>
                    </div>

                    @php
                        $variant = match ($computer->status) {
                            'available' => 'success',
                            'occupied' => 'warning',
                            'maintenance' => 'danger',
                            default => 'default',
                        };

                        $label = match ($computer->status) {
                            'available' => 'Disponible',
                            'occupied' => 'Ocupada',
                            'maintenance' => 'Mantenimiento',
                            default => 'Deshabilitada',
                        };
                    @endphp

                    <x-admin.badge :variant="$variant">
                        {{ $label }}
                    </x-admin.badge>

                </div>

                <div class="mt-8">

                    <p class="text-sm text-slate-400">
                        Precio por hora
                    </p>

                    <p class="mt-2 text-5xl font-bold text-white">
                        S/ {{ number_format($computer->hourly_price, 2) }}
                    </p>

                </div>

                <div class="mt-10 grid gap-4 sm:grid-cols-2">

                    <div class="rounded-xl border border-slate-800 bg-[#0b1930]/90 p-4">
                        <p class="text-sm text-slate-400">
                            Procesador
                        </p>

                        <p class="mt-1 font-semibold text-white">
                            {{ $computer->processor }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-[#0b1930]/90 p-4">
                        <p class="text-sm text-slate-400">
                            RAM
                        </p>

                        <p class="mt-1 font-semibold text-white">
                            {{ $computer->ram }} GB
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-[#0b1930]/90 p-4">
                        <p class="text-sm text-slate-400">
                            Tarjeta gráfica
                        </p>

                        <p class="mt-1 font-semibold text-white">
                            {{ $computer->graphics ?: 'Integrada' }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-[#0b1930]/90 p-4">
                        <p class="text-sm text-slate-400">
                            Almacenamiento
                        </p>

                        <p class="mt-1 font-semibold text-white">
                            {{ $computer->storage }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-[#0b1930]/90 p-4">
                        <p class="text-sm text-slate-400">
                            Monitor
                        </p>

                        <p class="mt-1 font-semibold text-white">
                            {{ $computer->monitor }}
                        </p>
                    </div>

                </div>

                <div class="mt-auto pt-10">

                    @auth
                        @if ($computer->status === 'available')
                            <x-admin.button
                                :href="route('reservations.create', $computer)"
                                class="w-full justify-center"
                            >
                                Reservar ahora
                            </x-admin.button>
                        @else
                            <button
                                disabled
                                class="w-full cursor-not-allowed rounded-xl bg-slate-700 px-4 py-3 text-sm font-semibold text-slate-400"
                            >
                                No disponible para reservar
                            </button>
                        @endif
                    @else
                        <x-admin.button
                            :href="route('login')"
                            class="w-full justify-center"
                        >
                            Inicia sesión para reservar
                        </x-admin.button>
                    @endauth

                </div>

            </div>

        </div>
    </div>
</x-layouts.public>
