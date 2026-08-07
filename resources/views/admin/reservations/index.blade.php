<x-layouts.admin title="Reservas">
    <div class="space-y-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-rose-400">
                    Administración
                </p>

                <h2 class="mt-2 text-3xl font-bold text-white">
                    Reservas
                </h2>

                <p class="mt-2 text-slate-400">
                    Consulta y administra las solicitudes de reserva.
                </p>
            </div>

            <x-admin.button :href="route('admin.reservations.create')">
                Nueva reserva
            </x-admin.button>
        </div>

        @if (session('success'))
            <x-admin.alert>
                {{ session('success') }}
            </x-admin.alert>
        @endif

        @if (session('error'))
            <x-admin.alert type="error">
                {{ session('error') }}
            </x-admin.alert>
        @endif

        <x-admin.card :padding="false">
            <div class="border-b border-slate-800 p-5 sm:p-6">
                <form
                    action="{{ route('admin.reservations.index') }}"
                    method="GET"
                    class="grid gap-3 lg:grid-cols-5"
                >
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cliente, correo o PC..."
                        class="rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none placeholder:text-slate-500 focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 lg:col-span-2"
                    >

                    <select
                        name="status"
                        class="rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10"
                    >
                        <option value="">Todos los estados</option>
                        <option value="pending" @selected(request('status') === 'pending')>
                            Pendiente
                        </option>
                        <option value="approved" @selected(request('status') === 'approved')>
                            Aprobada
                        </option>
                        <option value="rejected" @selected(request('status') === 'rejected')>
                            Rechazada
                        </option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>
                            Cancelada
                        </option>
                        <option value="completed" @selected(request('status') === 'completed')>
                            Finalizada
                        </option>
                    </select>

                    <input
                        type="date"
                        name="date"
                        value="{{ request('date') }}"
                        class="rounded-xl border border-slate-700 bg-[#0d1b31] px-4 py-3 text-sm text-white outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10"
                    >

                    <div class="flex gap-3">
                        <x-admin.button type="submit">
                            Filtrar
                        </x-admin.button>

                        @if (request()->hasAny(['search', 'status', 'date']))
                            <x-admin.button
                                variant="secondary"
                                :href="route('admin.reservations.index')"
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
                                Cliente
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Computadora
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Fecha y horario
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Total
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
                        @forelse ($reservations as $reservation)
                            @php
                                $statusVariant = match ($reservation->status) {
                                    'pending' => 'warning',
                                    'approved' => 'success',
                                    'active' => 'info',
                                    'rejected' => 'danger',
                                    'cancelled' => 'default',
                                    'completed' => 'default',
                                    default => 'default',
                                };

                                $statusLabel = match ($reservation->status) {
                                    'pending' => 'Pendiente',
                                    'approved' => 'Aprobada',
                                    'active' => 'En curso',
                                    'rejected' => 'Rechazada',
                                    'cancelled' => 'Cancelada',
                                    'completed' => 'Finalizada',
                                    default => $reservation->status,
                                };
                            @endphp
                            @php
                                $startTime = \Carbon\Carbon::parse($reservation->start_time);

                                $endTime = $startTime
                                    ->copy()
                                    ->addHours($reservation->duration_hours);
                            @endphp

                            <tr class="transition hover:bg-slate-800/30">
                                <td class="px-6 py-5">
                                    <p class="font-semibold text-white">
                                        {{ $reservation->user->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $reservation->user->email }}
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    <p class="font-semibold text-white">
                                        {{ $reservation->computer->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $reservation->computer->category->name }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-5 text-sm text-slate-300">
                                    <p>
                                        {{ $reservation->reservation_date->format('d/m/Y') }}
                                    </p>

                                    <p class="mt-1 text-slate-500">
                                        {{ $startTime->format('H:i') }}
                                        –
                                        {{ $endTime->format('H:i') }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-600">
                                        {{ $reservation->duration_hours }} hora(s)
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
                                    <p class="font-semibold text-white">
                                        S/ {{ number_format($reservation->total_price, 2) }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        S/ {{ number_format($reservation->hourly_price, 2) }}/hora
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
                                    <x-admin.badge :variant="$statusVariant">
                                        {{ $statusLabel }}
                                    </x-admin.badge>
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
                                    <div class="flex flex-wrap justify-end gap-2">
                                        @if ($reservation->status === 'pending')
                                            <form
                                                action="{{ route('admin.reservations.approve', $reservation) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <x-admin.button type="submit">
                                                    Aprobar
                                                </x-admin.button>
                                            </form>

                                            <form
                                                action="{{ route('admin.reservations.reject', $reservation) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Rechazar esta reserva?')"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <x-admin.button
                                                    type="submit"
                                                    variant="danger"
                                                >
                                                    Rechazar
                                                </x-admin.button>
                                            </form>
                                        @endif

                                        @if ($reservation->status === 'approved')
                                            <form
                                                action="{{ route('admin.reservations.start', $reservation) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <x-admin.button type="submit">
                                                    Iniciar
                                                </x-admin.button>
                                            </form>

                                            <form
                                                action="{{ route('admin.reservations.cancel', $reservation) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Cancelar esta reserva?')"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <x-admin.button
                                                    type="submit"
                                                    variant="secondary"
                                                >
                                                    Cancelar
                                                </x-admin.button>
                                            </form>
                                        @endif
                                        @if ($reservation->status === 'active')
                                            <form
                                                action="{{ route('admin.reservations.complete', $reservation) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <x-admin.button type="submit">
                                                    Finalizar
                                                </x-admin.button>
                                            </form>
                                        @endif

                                        @if (in_array($reservation->status, ['rejected', 'cancelled'], true))
                                            <form
                                                action="{{ route('admin.reservations.destroy', $reservation) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Eliminar esta reserva?')"
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
                                        @endif

                                        @if ($reservation->status === 'completed')
                                            <span class="text-xs text-slate-500">
                                                Sin acciones pendientes
                                            </span>
                                        @endif
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
                                        No hay reservas registradas
                                    </p>

                                    <p class="mt-2 text-sm text-slate-400">
                                        Registra una reserva o modifica los filtros.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($reservations->hasPages())
                <div class="border-t border-slate-800 px-6 py-4">
                    {{ $reservations->links() }}
                </div>
            @endif
        </x-admin.card>
    </div>
</x-layouts.admin>
