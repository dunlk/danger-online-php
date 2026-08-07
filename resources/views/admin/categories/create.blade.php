<x-layouts.admin title="Crear categoría">
    <div class="mx-auto max-w-3xl">
        <div class="mb-8">
            <p class="text-sm font-medium text-rose-400">
                Categorías
            </p>

            <h2 class="mt-2 text-3xl font-bold text-white">
                Nueva categoría
            </h2>

            <p class="mt-2 text-slate-400">
                Registra un nuevo tipo de computadora.
            </p>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-[#0b1930]/90 p-6 shadow-2xl shadow-black/20 backdrop-blur-xl sm:p-8">
            <form
                action="{{ route('admin.categories.store') }}"
                method="POST"
            >
                @include('admin.categories._form')
            </form>
        </div>
    </div>
</x-layouts.admin>
