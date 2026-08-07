<x-layouts.admin title="Nueva computadora">
    <div class="mx-auto max-w-5xl">
        <div class="mb-8">
            <p class="text-sm font-medium text-rose-400">
                Computadoras
            </p>

            <h2 class="mt-2 text-3xl font-bold text-white">
                Registrar computadora
            </h2>

            <p class="mt-2 text-slate-400">
                Agrega un nuevo equipo al catálogo del cibercafé.
            </p>
        </div>

        <x-admin.card>
            <form
                action="{{ route('admin.computers.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @include('admin.computers._form')
            </form>
        </x-admin.card>
    </div>
</x-layouts.admin>
