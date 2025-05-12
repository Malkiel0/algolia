{{-- 
    Layout principal du dashboard Digit All
    Utilise Tailwind CSS v3, Livewire 3, Alpine.js
    Palette : Orange (#FFA726), Bleu nuit (#1A1333), Blanc
    Sidebar, Header, Slot pour le contenu
    Code très commenté et structuré pour faciliter la reprise
--}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digit All Dashboard</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-white min-h-screen font-sans text-[#1A1333] flex">
    {{-- Sidebar --}}
    <aside class="w-64 bg-[#1A1333] text-white flex flex-col min-h-screen shadow-lg">
        @livewire('sidebar')
    </aside>
    {{-- Contenu principal --}}
    <div class="flex-1 flex flex-col min-h-screen">
        {{-- Header --}}
        <header class="bg-white shadow flex items-center justify-between px-8 py-4 sticky top-0 z-10">
            @livewire('header')
        </header>
        {{-- Slot pour le contenu des pages --}}
        <main class="flex-1 bg-[#F8F9FB] p-8 overflow-y-auto">
            @yield('content')
        </main>
        {{-- Fin du slot de contenu principal --}}
    </div>
    {{-- Fin du contenu principal --}}
    @livewireScripts
    {{-- Alpine.js pour l'interactivité --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>

    </div>
    @livewireScripts
    <script src="/node_modules/alpinejs/dist/cdn.min.js" defer></script>
</body>
</html>
