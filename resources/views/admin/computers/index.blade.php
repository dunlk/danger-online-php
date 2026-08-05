<x-layouts.admin title="Computadoras">
    <div class="space-y-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-rose-400">
                    Administración
                </p>

                <h2 class="mt-2 text-3xl font-bold text-white">
                    Computadoras
                </h2>

                <p class="mt-2 text-slate-400">
                    Gestiona los equipos, sus características y disponibilidad.
                </p>
            </div>

            <x-admin.button :href="route('admin.computers.create')">
                Nueva computadora
            </x-admin.button>
        </div>

        @if (session('success'))
            <x-admin.alert>
                {{ session('success') }}
            </x-admin.alert>
        @endif

        <x-admin.card :padding="false">
            <div class="border-b border-slate-800 p-5 sm:p-6">
                <form
                    action="{{ route('admin.computers.index') }}"
                    method="GET"
                    class="grid gap-3 md:grid-cols-4"
                >
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Buscar PC-01..."
                        class="rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500 focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 md:col-span-2"
                    >

                    <select
                        name="category_id"
                        class="rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10"
                    >
                        <option value="">Todas las categorías</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(request('category_id') == $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <select
                        name="status"
                        class="rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10"
                    >
                        <option value="">Todos los estados</option>
                        <option value="available" @selected(request('status') === 'available')>
                            Disponible
                        </option>
                        <option value="occupied" @selected(request('status') === 'occupied')>
                            Ocupada
                        </option>
                        <option value="maintenance" @selected(request('status') === 'maintenance')>
                            Mantenimiento
                        </option>
                        <option value="disabled" @selected(request('status') === 'disabled')>
                            Deshabilitada
                        </option>
                    </select>

                    <div class="flex gap-3 md:col-span-4">
                        <x-admin.button type="submit">
                            Filtrar
                        </x-admin.button>

                        @if (request()->hasAny(['search', 'category_id', 'status']))
                            <x-admin.button
                                variant="secondary"
                                :href="route('admin.computers.index')"
                            >
                                Limpiar
                            </x-admin.button>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-800">
                    <thead class="bg-slate-900/40">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Equipo
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Categoría
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Especificaciones
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Precio
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Estado
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800">
                        @forelse ($computers as $computer)
                            @php
                                $statusVariant = match ($computer->status) {
                                    'available' => 'success',
                                    'occupied' => 'warning',
                                    'maintenance' => 'info',
                                    'disabled' => 'danger',
                                    default => 'default',
                                };

                                $statusLabel = match ($computer->status) {
                                    'available' => 'Disponible',
                                    'occupied' => 'Ocupada',
                                    'maintenance' => 'Mantenimiento',
                                    'disabled' => 'Deshabilitada',
                                    default => $computer->status,
                                };
                            @endphp

                            <tr class="transition hover:bg-slate-800/30">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        @if ($computer->image)
                                            <img
                                                src="{{ asset('storage/' . $computer->image) }}"
                                                alt="{{ $computer->name }}"
                                                class="size-14 rounded-xl border border-slate-700 object-cover"
                                            >
                                        @else
                                            <div class="grid size-14 place-items-center rounded-xl bg-rose-500/10 font-bold text-rose-400">
                                                PC
                                            </div>
                                        @endif

                                        <div>
                                            <p class="font-semibold text-white">
                                                {{ $computer->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ $computer->monitor ?: 'Monitor no registrado' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-300">
                                    {{ $computer->category->name }}
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-400">
                                    <p>{{ $computer->processor }}</p>
                                    <p class="mt-1">
                                        {{ $computer->ram }} GB RAM ·
                                        {{ $computer->graphics ?: 'Gráfica integrada' }}
                                    </p>
                                    <p class="mt-1">
                                        {{ $computer->storage }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-5 font-semibold text-white">
                                    S/ {{ number_format($computer->hourly_price, 2) }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
                                    <x-admin.badge :variant="$statusVariant">
                                        {{ $statusLabel }}
                                    </x-admin.badge>
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <x-admin.button
                                            variant="secondary"
                                            :href="route('admin.computers.edit', $computer)"
                                        >
                                            Editar
                                        </x-admin.button>

                                        <form
                                            action="{{ route('admin.computers.destroy', $computer) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Eliminar esta computadora?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <x-admin.button
                                                type="submit"
                                                variant="danger"
                                            >
                                                Eliminar
                                            </x-admin.button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="6"
                                    class="px-6 py-16 text-center"
                                >
                                    <p class="font-semibold text-white">
                                        No se encontraron computadoras
                                    </p>

                                    <p class="mt-2 text-sm text-slate-400">
                                        Registra un equipo o modifica los filtros.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($computers->hasPages())
                <div class="border-t border-slate-800 px-6 py-4">
                    {{ $computers->links() }}
                </div>
            @endif
        </x-admin.card>
    </div>
</x-layouts.admin>
