<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche Algolia</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Recherche instantanée avec Algolia</h1>
        @livewire('product-search')
    </div>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
</body>
</html>