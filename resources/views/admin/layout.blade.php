<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre', 'Administration') — Licences</title>
    
    {{-- Inclusion de Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Configuration de la police Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
    </style>
</head>
<body class="min-h-full flex flex-col bg-gray-50 text-gray-800 antialiased">

    @auth
    {{-- BARRE DE NAVIGATION --}}
    <header class="bg-gray-900 text-white sticky top-0 z-50 border-b border-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                {{-- Logo / Marque --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center font-bold text-white shadow-sm">
                        L
                    </div>
                    <span class="font-bold text-base tracking-wide text-white">Admin Licences</span>
                </div>

                {{-- Navigation Desktop --}}
                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-300 hover:text-white transition">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.entreprises.create') }}" class="text-sm font-medium text-gray-300 hover:text-white transition">
                        + Nouvelle entreprise
                    </a>
                    
                    <div class="h-4 w-px bg-gray-700"></div>

                    <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="text-xs font-medium px-3 py-1.5 rounded-lg border border-gray-700 text-gray-300 hover:bg-gray-800 hover:text-white transition">
                            Déconnexion
                        </button>
                    </form>
                </nav>

                {{-- Bouton Menu Mobile (Burger) --}}
                <div class="flex md:hidden">
                    <button type="button" onclick="toggleMenuMobile()" class="text-gray-400 hover:text-white focus:outline-none p-2">
                        <svg id="icon-menu-open" class="h-6 w-6 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg id="icon-menu-close" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        {{-- Menu Deroulant Mobile --}}
        <div id="menu-mobile" class="hidden md:hidden border-t border-gray-800 bg-gray-900 px-4 pt-2 pb-4 space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800">
                Dashboard / Licences
            </a>
            <a href="{{ route('admin.entreprises.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800">
                + Nouvelle entreprise
            </a>
            <form method="POST" action="{{ route('admin.logout') }}" class="pt-2 border-t border-gray-800">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-rose-400 hover:bg-gray-800">
                    Se déconnecter
                </button>
            </form>
        </div>
    </header>
    @endauth

    {{-- CONTENU PRINCIPAL --}}
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- ALERTES ET NOTIFICATIONS --}}
        @if (session('succes') || session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-emerald-500 text-lg">✅</span>
                    <span>{{ session('succes') ?? session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold ml-4">✕</button>
            </div>
        @endif

        @if (session('erreur'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-rose-500 text-lg">⚠️</span>
                    <span>{{ session('erreur') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 font-bold ml-4">✕</button>
            </div>
        @endif

        {{-- Contenu injecté des vues enfants --}}
        @yield('contenu')

    </main>

    {{-- FOOTER DISCRET --}}
    <footer class="mt-auto border-t border-gray-200 bg-white py-4 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} Admin Licences — Tous droits réservés.
    </footer>

    {{-- SCRIPTS GENERALS --}}
    <script>
        function toggleMenuMobile() {
            const menu = document.getElementById('menu-mobile');
            const iconOpen = document.getElementById('icon-menu-open');
            const iconClose = document.getElementById('icon-menu-close');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }
        }
    </script>

    @stack('scripts')
</body>
</html>