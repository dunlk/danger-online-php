<x-layouts.public title="Recuperar contraseña">
    <div class="mx-auto max-w-xl py-10 sm:py-16">
        <div class="mb-8 text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-rose-400">
                Danger Web
            </p>

            <h1 class="mt-4 text-4xl font-bold text-white">
                ¿Olvidaste tu contraseña?
            </h1>

            <p class="mt-3 text-slate-400">
                No hay problema. Ingresa tu correo electrónico y te enviaremos
                un enlace para restablecer tu contraseña.
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
                action="{{ route('password.email') }}"
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
                        autocomplete="email"
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

                <button
                    type="submit"
                    class="w-full rounded-xl bg-rose-500 px-5 py-3.5
                           font-semibold text-white
                           shadow-lg shadow-rose-500/20 transition
                           hover:bg-rose-400
                           focus:outline-none
                           focus:ring-4 focus:ring-rose-500/20"
                >
                    Enviar enlace de recuperación
                </button>
            </form>

            <div class="mt-6 border-t border-slate-800 pt-6 text-center">
                <p class="text-sm text-slate-400">
                    ¿Recordaste tu contraseña?

                    <a
                        href="{{ route('login') }}"
                        class="font-semibold text-rose-400 transition
                               hover:text-rose-300"
                    >
                        Volver a iniciar sesión
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.public>
