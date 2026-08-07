<x-layouts.public title="Iniciar sesión">
    <div class="mx-auto max-w-xl py-10 sm:py-16">
        <div class="mb-8 text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-rose-400">
                Danger Web
            </p>

            <h1 class="mt-4 text-4xl font-bold text-white">
                Bienvenido de nuevo
            </h1>

            <p class="mt-3 text-slate-400">
                Inicia sesión para reservar computadoras y administrar tus reservas.
            </p>
        </div>

        @if (session('status'))
            <div
                class="mb-6 rounded-2xl border border-emerald-500/30
                       bg-emerald-500/10 px-5 py-4 text-sm text-emerald-300"
            >
                {{ session('status') }}
            </div>
        @endif

        <div
            class="rounded-3xl border border-slate-800 bg-[#0b1930]/90
                   p-6 shadow-2xl shadow-black/20 backdrop-blur-xl sm:p-8"
        >
            <form
                method="POST"
                action="{{ route('login') }}"
                class="space-y-6"
            >
                @csrf

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
                        autofocus
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
                    <div class="mb-2 flex items-center justify-between gap-4">
                        <label
                            for="password"
                            class="block text-sm font-medium text-slate-200"
                        >
                            Contraseña
                        </label>

                        @if (Route::has('password.request'))
                            <a
                                href="{{ route('password.request') }}"
                                class="text-sm font-medium text-rose-400 transition
                                       hover:text-rose-300"
                            >
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
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

                <label
                    for="remember_me"
                    class="flex cursor-pointer items-center gap-3 text-sm text-slate-400"
                >
                    <input
                        id="remember_me"
                        name="remember"
                        type="checkbox"
                        class="size-4 rounded border-slate-700 bg-[#0d1b31]
                               text-rose-500 focus:ring-rose-500/30"
                    >

                    Mantener sesión iniciada
                </label>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-rose-500 px-5 py-3.5
                           font-semibold text-white
                           shadow-lg shadow-rose-500/20 transition
                           hover:bg-rose-400
                           focus:outline-none
                           focus:ring-4 focus:ring-rose-500/20"
                >
                    Iniciar sesión
                </button>
            </form>

            <div class="mt-6 border-t border-slate-800 pt-6 text-center">
                <p class="text-sm text-slate-400">
                    ¿Todavía no tienes una cuenta?

                    <a
                        href="{{ route('register') }}"
                        class="font-semibold text-rose-400 transition
                               hover:text-rose-300"
                    >
                        Regístrate
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
