<x-layouts.public title="Inicio">
    <section class="relative mt-32 overflow-hidden py-16 sm:py-24 lg:py-32">

        <div class="mx-auto max-w-4xl text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-rose-400">
                Danger Web
            </p>

            <h1
                class="mt-6 text-4xl font-bold tracking-tight text-white
                       sm:text-5xl lg:text-7xl"
            >
                Tu espacio para jugar,
                <span class="text-rose-400">
                    estudiar y navegar
                </span>
            </h1>

            <p
                class="mx-auto mt-6 max-w-2xl text-base leading-8 text-slate-400
                       sm:text-lg"
            >
                Encuentra la computadora ideal para ti, revisa sus
                características y reserva tu horario de forma rápida y sencilla.
            </p>

            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <a
                    href="{{ route('computers.index') }}"
                    class="rounded-xl bg-rose-500 px-7 py-3.5
                           font-semibold text-white shadow-lg shadow-rose-500/20
                           transition hover:bg-rose-400"
                >
                    Ver computadoras
                </a>

                @guest
                    <a
                        href="{{ route('register') }}"
                        class="rounded-xl border border-slate-700
                               bg-slate-900/50 px-7 py-3.5 font-semibold
                               text-slate-200 transition
                               hover:border-slate-600 hover:bg-slate-800"
                    >
                        Crear una cuenta
                    </a>
                @else
                    <a
                        href="{{ route('reservations.index') }}"
                        class="rounded-xl border border-slate-700
                               bg-slate-900/50 px-7 py-3.5 font-semibold
                               text-slate-200 transition
                               hover:border-slate-600 hover:bg-slate-800"
                    >
                        Mis reservas
                    </a>
                @endguest
            </div>
        </div>
    </section>

</x-layouts.public>
