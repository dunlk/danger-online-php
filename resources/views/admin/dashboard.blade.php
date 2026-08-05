<x-layouts.admin title="Dashboard">
    <div class="space-y-8">
        <div>
            <p class="text-sm font-medium text-rose-400">
                Resumen general
            </p>

            <h2 class="mt-2 text-3xl font-bold text-white">
                Dashboard
            </h2>

            <p class="mt-2 text-slate-400">
                Consulta el estado actual de los equipos del cibercafé.
            </p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            <x-admin.card>
                <p class="text-sm font-medium text-slate-400">
                    Computadoras
                </p>

                <p class="mt-3 text-4xl font-bold text-white">
                    {{ $stats['computers'] }}
                </p>

                <p class="mt-2 text-sm text-slate-500">
                    Equipos registrados
                </p>
            </x-admin.card>

            <x-admin.card>
                <p class="text-sm font-medium text-slate-400">
                    Disponibles
                </p>

                <p class="mt-3 text-4xl font-bold text-emerald-400">
                    {{ $stats['available'] }}
                </p>

                <p class="mt-2 text-sm text-slate-500">
                    Listas para reservar
                </p>
            </x-admin.card>

            <x-admin.card>
                <p class="text-sm font-medium text-slate-400">
                    Ocupadas
                </p>

                <p class="mt-3 text-4xl font-bold text-amber-400">
                    {{ $stats['occupied'] }}
                </p>

                <p class="mt-2 text-sm text-slate-500">
                    En uso actualmente
                </p>
            </x-admin.card>

            <x-admin.card>
                <p class="text-sm font-medium text-slate-400">
                    Mantenimiento
                </p>

                <p class="mt-3 text-4xl font-bold text-blue-400">
                    {{ $stats['maintenance'] }}
                </p>

                <p class="mt-2 text-sm text-slate-500">
                    Equipos en revisión
                </p>
            </x-admin.card>

            <x-admin.card>
                <p class="text-sm font-medium text-slate-400">
                    Deshabilitadas
                </p>

                <p class="mt-3 text-4xl font-bold text-rose-400">
                    {{ $stats['disabled'] }}
                </p>

                <p class="mt-2 text-sm text-slate-500">
                    Fuera de servicio
                </p>
            </x-admin.card>

            <x-admin.card>
                <p class="text-sm font-medium text-slate-400">
                    Categorías
                </p>

                <p class="mt-3 text-4xl font-bold text-white">
                    {{ $stats['categories'] }}
                </p>

                <p class="mt-2 text-sm text-slate-500">
                    Tipos de computadora
                </p>
            </x-admin.card>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <x-admin.card class="xl:col-span-2">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-white">
                            Últimas computadoras
                        </h3>

                        <p class="mt-1 text-sm text-slate-400">
                            Equipos registrados recientemente.
                        </p>
                    </div>

                    <x-admin.button
                        variant="secondary"
                        :href="route('admin.computers.index')"
                    >
                        Ver todas
                    </x-admin.button>
                </div>

                <div class="mt-6 divide-y divide-slate-800">
                    @forelse ($latestComputers as $computer)
                        <div class="flex items-center justify-between gap-4 py-4">
                            <div class="flex min-w-0 items-center gap-4">
                                @if ($computer->image)
                                    <img
                                        src="{{ asset('storage/' . $computer->image) }}"
                                        alt="{{ $computer->name }}"
                                        class="size-12 rounded-xl border border-slate-700 object-cover"
                                    >
                                @else
                                    <div class="grid size-12 place-items-center rounded-xl bg-rose-500/10 font-bold text-rose-400">
                                        PC
                                    </div>
                                @endif

                                <div class="min-w-0">
                                    <p class="font-semibold text-white">
                                        {{ $computer->name }}
                                    </p>

                                    <p class="truncate text-sm text-slate-400">
                                        {{ $computer->category->name }}
                                        · {{ $computer->processor }}
                                    </p>
                                </div>
                            </div>

                            <p class="whitespace-nowrap font-semibold text-white">
                                S/ {{ number_format($computer->hourly_price, 2) }}
                            </p>
                        </div>
                    @empty
                        <p class="py-8 text-center text-slate-400">
                            Todavía no hay computadoras registradas.
                        </p>
                    @endforelse
                </div>
            </x-admin.card>

            <x-admin.card>
                <h3 class="text-lg font-semibold text-white">
                    Equipos por categoría
                </h3>

                <p class="mt-1 text-sm text-slate-400">
                    Distribución actual del catálogo.
                </p>

                <div class="mt-6 space-y-4">
                    @forelse ($categories as $category)
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-medium text-white">
                                    {{ $category->name }}
                                </p>

                                <p class="text-sm text-slate-500">
                                    Computadoras registradas
                                </p>
                            </div>

                            <x-admin.badge variant="info">
                                {{ $category->computers_count }}
                            </x-admin.badge>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">
                            No hay categorías registradas.
                        </p>
                    @endforelse
                </div>
            </x-admin.card>
        </div>
    </div>
</x-layouts.admin>
