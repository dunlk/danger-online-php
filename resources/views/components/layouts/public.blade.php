@props([
    'title' => 'Danger Web',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-7">
    <meta name="viewport" content="width=device-width, initial-scale=2">

    <title>{{ $title }} | {{ config('app.name', 'Danger Web') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#071427] text-slate-100 antialiased">
    <div
        class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(38,99,235,0.18),_transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(244,63,94,0.16),_transparent_35%)]"
    >
        <header class="fixed z-50 w-full border-b border-slate-800/80 bg-[#09182c]/60 backdrop-blur-xl">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-4 sm:px-8">
                <a
                    href="{{ route('computers.index') }}"
                    class="flex items-center gap-2 text-xl font-bold"
                >
                    <span class="grid size-9 place-items-center rounded-xl bg-rose-500 text-white">
                        D
                    </span>

                    <span>
                        Danger<span class="text-rose-500">.</span>Web
                    </span>
                </a>

                <nav class="flex items-center gap-2">
                    <a
                        href="{{ route('computers.index') }}"
                        class="rounded-xl px-3 py-2 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white"
                    >
                        Computadoras
                    </a>

                    @auth
                        <a
                            href="{{ route('reservations.index') }}"
                            class="rounded-xl px-3 py-2 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white"
                        >
                            Mis reservas
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button
                                type="submit"
                                class="rounded-xl border border-slate-700 px-4 py-2 text-sm font-medium text-slate-200 transition hover:border-rose-500 hover:bg-rose-500 hover:text-white"
                            >
                                Cerrar sesión
                            </button>
                        </form>

                        @if (auth()->user()->isAdmin())
                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="rounded-xl bg-rose-500 px-4 py-2 text-sm font-semibold text-white"
                            >
                                Panel admin
                            </a>
                        @endif
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="rounded-xl px-3 py-2 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white"
                        >
                            Iniciar sesión
                        </a>

                        <a
                            href="{{ route('register') }}"
                            class="rounded-xl bg-rose-500 hover:bg-rose-600 transition-colors px-4 py-2 text-sm font-semibold text-white"
                        >
                            Registrarse
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto w-full max-w-7xl px-5 py-10 sm:px-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
