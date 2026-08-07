<x-layouts.public title="Mis reservas">
    <div class="space-y-8 pt-[55px]">
        <div>
            <p class="text-sm font-medium text-rose-400">
                Mi cuenta
            </p>

            <h1 class="mt-2 text-4xl font-bold text-white">
                Mis reservas
            </h1>

            <p class="mt-3 text-slate-400">
                Consulta el estado de tus reservas y administra las que aún estén pendientes.
            </p>
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

        <div class="grid gap-6">
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

                <article
                    class="rounded-2xl border border-slate-800 bg-[#0b1930]/90 p-6 shadow-xl shadow-black/10"
                >
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex min-w-0 items-center gap-5">
                            @if ($reservation->computer->image)
                                <img
                                    src="{{ asset('storage/' . $reservation->computer->image) }}"
                                    alt="{{ $reservation->computer->name }}"
                                    class="size-24 rounded-2xl border border-slate-700 object-cover"
                                >
                            @else
                                <div
                                    class="grid size-24 shrink-0 place-items-center rounded-2xl bg-rose-500/10 font-bold text-rose-400"
                                >
                                    PC
                                </div>
                            @endif

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h2 class="text-xl font-bold text-white">
                                        {{ $reservation->computer->name }}
                                    </h2>

                                    <x-admin.badge :variant="$statusVariant">
                                        {{ $statusLabel }}
                                    </x-admin.badge>
                                </div>

                                <p class="mt-1 text-sm text-slate-400">
                                    {{ $reservation->computer->category->name }}
                                </p>

                                <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm text-slate-300">
                                    <span>
                                        {{ $reservation->reservation_date->format('d/m/Y') }}
                                    </span>

                                    <span>
                                        {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}
                                    </span>

                                    <span>
                                        {{ $reservation->duration_hours }} hora(s)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 lg:items-end">
                            <div class="lg:text-right">
                                <p class="text-sm text-slate-500">
                                    Total
                                </p>

                                <p class="mt-1 text-2xl font-bold text-white">
                                    S/ {{ number_format($reservation->total_price, 2) }}
                                </p>
                            </div>

                            @if ($reservation->status === 'pending')
                                <form
                                    action="{{ route('reservations.cancel', $reservation) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Cancelar esta reserva?')"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <x-admin.button
                                        type="submit"
                                        variant="danger"
                                    >
                                        Cancelar reserva
                                    </x-admin.button>
                                </form>
                            @endif
                        </div>
                    </div>

                    @if ($reservation->notes)
                        <div class="mt-6 border-t border-slate-800 pt-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Observaciones
                            </p>

                            <p class="mt-2 text-sm text-slate-300">
                                {{ $reservation->notes }}
                            </p>
                        </div>
                    @endif
                </article>
            @empty
                <x-admin.card>
                    <div class="py-10 text-center">
                        <p class="text-lg font-semibold text-white">
                            Aún no tienes reservas
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            Explora las computadoras disponibles y crea tu primera reserva.
                        </p>

                        <div class="mt-6">
                            <x-admin.button :href="route('computers.index')">
                                Ver computadoras
                            </x-admin.button>
                        </div>
                    </div>
                </x-admin.card>
            @endforelse
        </div>

        @if ($reservations->hasPages())
            {{ $reservations->links() }}
        @endif
    </div>
</x-layouts.public>
