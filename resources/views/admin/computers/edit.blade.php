<x-layouts.admin title="Editar computadora">
    <div class="mx-auto max-w-5xl">
        <div class="mb-8">
            <p class="text-sm font-medium text-rose-400">
                Computadoras
            </p>

            <h2 class="mt-2 text-3xl font-bold text-white">
                Editar {{ $computer->name }}
            </h2>

            <p class="mt-2 text-slate-400">
                Actualiza las características, estado o imagen del equipo.
            </p>
        </div>

        <x-admin.card>
            <form
                action="{{ route('admin.computers.update', $computer) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @include('admin.computers._form', [
                    'computer' => $computer,
                ])
            </form>
        </x-admin.card>
    </div>
</x-layouts.admin>
