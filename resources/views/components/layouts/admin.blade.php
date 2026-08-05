@props([
    'title' => 'Dashboard',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Danger Web') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#071426] text-slate-100 antialiased">
    <div
        class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(37,99,235,0.18),_transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(244,63,94,0.16),_transparent_35%)]"
    >
        <div class="flex min-h-screen">
            <aside class="hidden w-72 border-r border-slate-800/80 bg-[#09182c]/90 px-6 py-8 backdrop-blur-xl lg:block">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 text-xl font-bold"
                >
                    <span class="grid size-10 place-items-center rounded-xl bg-rose-500 text-white shadow-lg shadow-rose-500/20">
                        D
                    </span>

                    <span>
                        Danger<span class="text-rose-500">.</span>Web
                    </span>
                </a>

                <nav class="mt-10 space-y-2">
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('admin.dashboard')
                            ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/20'
                            : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('admin.categories.*')
                            ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/20'
                            : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}"
                    >
                        Categorías
                    </a>
                    <a
                        href="{{ route('admin.computers.index') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('admin.computers.*')
                            ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/20'
                            : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}"
                    >
                        Computadoras
                    </a>
                </nav>
            </aside>

            <div class="flex min-w-0 flex-1 flex-col">
                <header class="border-b border-slate-800/80 bg-[#09182c]/75 px-5 py-4 backdrop-blur-xl sm:px-8">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-[0.22em] text-rose-400">
                                Panel administrativo
                            </p>

                            <h1 class="mt-1 text-lg font-semibold text-white">
                                {{ $title ?? 'Dashboard' }}
                            </h1>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="hidden text-right sm:block">
                                <p class="text-sm font-semibold text-white">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="rounded-xl border border-slate-700 px-4 py-2 text-sm font-medium text-slate-200 transition hover:border-rose-500 hover:bg-rose-500 hover:text-white"
                                >
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <main class="flex-1 px-5 py-8 sm:px-8 lg:px-10">
                    <div class="mx-auto w-full max-w-7xl">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html>

