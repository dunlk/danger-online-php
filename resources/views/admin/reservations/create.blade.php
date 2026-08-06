<x-layouts.admin title="Nueva reserva">
    <div class="mx-auto max-w-4xl">
        <div class="mb-8">
            <p class="text-sm font-medium text-rose-400">
                Reservas
            </p>

            <h2 class="mt-2 text-3xl font-bold text-white">
                Registrar reserva
            </h2>

            <p class="mt-2 text-slate-400">
                Selecciona una computadora, fecha, horario y duración.
            </p>
        </div>

        @if ($errors->any())
            <x-admin.alert type="error" class="mb-6">
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

        <x-admin.card>
            <form
                action="{{ route('admin.reservations.store') }}"
                method="POST"
            >
                @include('admin.reservations._form')
            </form>
        </x-admin.card>
    </div>
</x-layouts.admin>
