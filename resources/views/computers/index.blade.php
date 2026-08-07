<x-layouts.public title="Computadoras">
    <div class="space-y-8 pt-[50px]">
        <div>
            <p class="text-sm font-medium text-rose-400">
                Catálogo
            </p>

            <h1 class="mt-2 text-4xl font-bold text-white">
                Elige tu computadora
            </h1>

            <p class="mt-3 max-w-2xl text-slate-400">
                Consulta las características, precios y disponibilidad de nuestros equipos.
            </p>
        </div>

        <x-admin.card>
            <form
                action="{{ route('computers.index') }}"
                method="GET"
                class="grid gap-3 md:grid-cols-4"
            >
                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Buscar PC-01..."
                    class="rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500 focus:border-rose-500 md:col-span-2"
                >

                <select
                    name="category_id"
                    class="rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none focus:border-rose-500"
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
                    class="rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none focus:border-rose-500"
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
                </select>

                <div class="flex gap-3 md:col-span-4">
                    <x-admin.button type="submit">
                        Filtrar
                    </x-admin.button>

                    @if (request()->hasAny(['search', 'category_id', 'status']))
                        <x-admin.button
                            variant="secondary"
                            :href="route('computers.index')"
                        >
                            Limpiar
                        </x-admin.button>
                    @endif
                </div>
            </form>
        </x-admin.card>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($computers as $computer)
                <article class="flex flex-col overflow-hidden rounded-2xl border border-slate-800 bg-[#0b1930]/90">
                    @if ($computer->image)
                        <div class="overflow-hidden rounded-2xl">
                            <img
                                src="{{ asset('storage/' . $computer->image) }}"
                                class="h-56 w-full object-cover"
                            >
                        </div>
                    @else
                        <div class="grid h-52 place-items-center bg-slate-900/60 text-4xl font-bold text-rose-400">
                            PC
                        </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-bold text-white">
                                    {{ $computer->name }}
                                </h2>

                                <p class="mt-1 text-sm text-slate-400">
                                    {{ $computer->category->name }}
                                </p>
                            </div>

                            <x-admin.badge
                                :variant="$computer->status === 'available' ? 'success' : 'warning'"
                            >
                                {{ $computer->status === 'available' ? 'Disponible' : 'No disponible' }}
                            </x-admin.badge>
                        </div>

                        <div class="mt-5 space-y-2 text-sm text-slate-300">
                            <p>{{ $computer->processor }}</p>
                            <p>{{ $computer->ram }} GB RAM</p>
                            <p>{{ $computer->graphics ?: 'Gráfica integrada' }}</p>
                            <p>{{ $computer->storage }}</p>
                        </div>

                        <div class="mt-6 flex items-center justify-between gap-4">
                            <p class="text-lg font-bold text-white">
                                S/ {{ number_format($computer->hourly_price, 2) }}
                                <span class="text-xs font-normal text-slate-500">
                                    / hora
                                </span>
                            </p>

                            <x-admin.button
                                :href="route('computers.show', $computer)"
                            >
                                Ver detalle
                            </x-admin.button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="md:col-span-2 xl:col-span-3">
                    <x-admin.card>
                        <p class="text-center text-slate-400">
                            No se encontraron computadoras.
                        </p>
                    </x-admin.card>
                </div>
            @endforelse
        </div>

        {{ $computers->links() }}
    </div>
</x-layouts.public>
