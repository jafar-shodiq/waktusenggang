
<!DOCTYPE html>
<html lang="en" data-theme="lofi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - Chirper' : 'Chirper' }}</title>
    <link rel="preconnect" href="<https://fonts.bunny.net>">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 font-sans">

    <div class="drawer">
        <input id="project-drawer" type="checkbox" class="drawer-toggle" />

        <!-- Page content -->
        <div class="drawer-content flex flex-col">

            <!-- Navbar -->
            <nav class="navbar bg-base-100">
                <div class="navbar-start gap-2">

                    <!-- Hamburger -->
                    <label for="project-drawer" class="btn btn-ghost btn-sm">
                        ☰
                    </label>

                    <a href="/" class="btn btn-ghost text-xl">JShodiq</a>
                </div>

                <div class="navbar-end gap-2">
                    @auth
                        <span class="text-sm">{{ auth()->user()->name }}</span>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="/login" class="btn btn-ghost btn-sm">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </nav>

            <!-- Success Toast -->
            @if (session('success'))
                <div class="toast toast-top toast-center">
                    <div class="alert alert-success animate-fade-out">
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Main -->
            <main class="flex-1 container mx-auto px-4 py-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="footer footer-center p-5 bg-base-300 text-base-content text-xs">
                <p>© {{ date('Y') }} Chirper - Built with Laravel and ❤️</p>
            </footer>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side">
            <label for="project-drawer" class="drawer-overlay"></label>

            <aside class="w-64 bg-base-100 min-h-full">
                <div class="p-4 font-semibold text-lg">
                    Projects
                </div>

                <ul class="menu px-3">
                    <li>
                        <a href="{{ route('route_chirper.route_home') }}" class="active">
                            🐦 Chirper
                        </a>
                    </li>

                    <li class="disabled">
                        <span>📋 Tasks (soon)</span>
                    </li>

                    <li class="disabled">
                        <span>📝 Blog (soon)</span>
                    </li>
                </ul>
            </aside>
        </div>
    </div>

</body>

</html>