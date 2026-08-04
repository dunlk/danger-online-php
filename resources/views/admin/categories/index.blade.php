<x-layouts.admin title="Categorías">
    <div class="space-y-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-rose-400">
                    Administración
                </p>

                <h2 class="mt-2 text-3xl font-bold text-white">
                    Categorías
                </h2>

                <p class="mt-2 text-slate-400">
                    Organiza las computadoras según su tipo y características.
                </p>
            </div>

            <x-admin.button :href="route('admin.categories.create')">
                Nueva categoría
            </x-admin.button>
        </div>

        @if (session('success'))
            <div
                class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-300"
            >
                {{ session('success') }}
            </div>
        @endif

        <div
            class="overflow-hidden rounded-2xl border border-slate-800 bg-[#0b1930]/90 shadow-2xl shadow-black/20 backdrop-blur-xl"
        >
            <div class="border-b border-slate-800 p-5 sm:p-6">
                <form
                    action="{{ route('admin.categories.index') }}"
                    method="GET"
                    class="flex flex-col gap-3 sm:flex-row"
                >
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Buscar por nombre..."
                        class="min-w-0 flex-1 rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10"
                    >

                    <x-admin.button type="submit">
                        Buscar
                    </x-admin.button>

                    @if (request('search'))
                        <x-admin.button
                            variant="secondary"
                            :href="route('admin.categories.index')"
                        >
                            Limpiar
                        </x-admin.button>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-800">
                    <thead class="bg-slate-900/40">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400"
                            >
                                Nombre
                            </th>

                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400"
                            >
                                Descripción
                            </th>

                            <th
                                class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400"
                            >
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800">
                        @forelse ($categories as $category)
                            <tr class="transition hover:bg-slate-800/30">
                                <td class="whitespace-nowrap px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="grid size-10 place-items-center rounded-xl bg-rose-500/10 font-bold text-rose-400"
                                        >
                                            {{ mb_strtoupper(mb_substr($category->name, 0, 1)) }}
                                        </div>

                                        <span class="font-semibold text-white">
                                            {{ $category->name }}
                                        </span>
                                    </div>
                                </td>

                                <td class="max-w-xl px-6 py-5 text-sm text-slate-400">
                                    {{ $category->description ?: 'Sin descripción' }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <x-admin.button
                                            variant="secondary"
                                            :href="route('admin.categories.edit', $category)"
                                        >
                                            Editar
                                        </x-admin.button>

                                        <form
                                            action="{{ route('admin.categories.destroy', $category) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?')"
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
                                    colspan="3"
                                    class="px-6 py-16 text-center"
                                >
                                    <p class="font-semibold text-white">
                                        No se encontraron categorías
                                    </p>

                                    <p class="mt-2 text-sm text-slate-400">
                                        Crea una categoría o modifica los términos de búsqueda.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="border-t border-slate-800 px-6 py-4">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
