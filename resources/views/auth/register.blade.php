<x-layouts.public title="Crear cuenta">
    <div class="mx-auto max-w-xl py-10 sm:py-12">
        <div class="mb-8 text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-rose-400">
                Danger Web
            </p>

            <h1 class="mt-4 text-4xl font-bold text-white">
                Crea tu cuenta
            </h1>

            <p class="mt-3 text-slate-400">
                Regístrate para reservar computadoras y consultar el estado de tus reservas.
            </p>
        </div>

        <div
            class="rounded-3xl border border-slate-800 bg-[#0b1930]/90 p-6
                   shadow-2xl shadow-black/20 backdrop-blur-xl sm:p-8"
        >
            <form
                method="POST"
                action="{{ route('register') }}"
                class="space-y-6"
            >
                @csrf

                <div>
                    <label
                        for="name"
                        class="mb-2 block text-sm font-medium text-slate-200"
                    >
                        Nombre
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Tu nombre"
                        class="w-full rounded-xl border border-slate-700
                               bg-[#0d1b31] px-4 py-3 text-sm text-white
                               outline-none transition
                               placeholder:text-slate-500
                               focus:border-rose-500
                               focus:ring-4 focus:ring-rose-500/10"
                    >

                    @error('name')
                        <p class="mt-2 text-sm text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="email"
                        class="mb-2 block text-sm font-medium text-slate-200"
                    >
                        Correo electrónico
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="username"
                        placeholder="correo@ejemplo.com"
                        class="w-full rounded-xl border border-slate-700
                               bg-[#0d1b31] px-4 py-3 text-sm text-white
                               outline-none transition
                               placeholder:text-slate-500
                               focus:border-rose-500
                               focus:ring-4 focus:ring-rose-500/10"
                    >

                    @error('email')
                        <p class="mt-2 text-sm text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="password"
                        class="mb-2 block text-sm font-medium text-slate-200"
                    >
                        Contraseña
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full rounded-xl border border-slate-700
                               bg-[#0d1b31] px-4 py-3 text-sm text-white
                               outline-none transition
                               placeholder:text-slate-500
                               focus:border-rose-500
                               focus:ring-4 focus:ring-rose-500/10"
                    >

                    @error('password')
                        <p class="mt-2 text-sm text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-medium text-slate-200"
                    >
                        Confirmar contraseña
                    </label>

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full rounded-xl border border-slate-700
                               bg-[#0d1b31] px-4 py-3 text-sm text-white
                               outline-none transition
                               placeholder:text-slate-500
                               focus:border-rose-500
                               focus:ring-4 focus:ring-rose-500/10"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-rose-500 px-5 py-3.5
                           font-semibold text-white
                           shadow-lg shadow-rose-500/20 transition
                           hover:bg-rose-400
                           focus:outline-none
                           focus:ring-4 focus:ring-rose-500/20"
                >
                    Crear cuenta
                </button>
            </form>

            <div class="mt-6 border-t border-slate-800 pt-6 text-center">
                <p class="text-sm text-slate-400">
                    ¿Ya tienes una cuenta?

                    <a
                        href="{{ route('login') }}"
                        class="font-semibold text-rose-400 transition hover:text-rose-300"
                    >
                        Inicia sesión
                    </a>
                </p>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a
                href="{{ route('computers.index') }}"
                class="text-sm text-slate-500 transition hover:text-white"
            >
                ← Volver a ver computadoras
            </a>
        </div>
    </div>
</x-layouts.public>
