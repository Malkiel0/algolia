<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de connexion Algolia</title>
    <!-- Inclusion de Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js pour les interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Entête de la page -->
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-blue-600 mb-2">Diagnostic de connexion Algolia</h1>
            <p class="text-gray-600">Vérification détaillée de la communication avec Algolia</p>
        </header>

        <!-- Statut global -->
        <div class="mb-8 p-4 rounded-lg {{ $status === 'success' ? 'bg-green-100 border border-green-300' : 'bg-red-100 border border-red-300' }}">
            <h2 class="text-xl font-semibold {{ $status === 'success' ? 'text-green-700' : 'text-red-700' }} mb-2">
                Statut: {{ $status === 'success' ? 'Connexion réussie ✅' : 'Erreur de connexion ❌' }}
            </h2>
            <p class="{{ $status === 'success' ? 'text-green-600' : 'text-red-600' }}">
                {{ $status === 'success' ? 'Votre application communique correctement avec Algolia' : 'Problème de communication avec Algolia' }}
            </p>
        </div>

        <!-- Configuration -->
        <div class="mb-6 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Configuration Algolia</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 rounded border border-gray-200">
                    <h3 class="font-medium text-gray-700 mb-2">Application ID</h3>
                    <p class="text-blue-600 font-mono">{{ $appId ?: 'Non configuré' }}</p>
                </div>
                
                <div class="p-4 bg-gray-50 rounded border border-gray-200">
                    <h3 class="font-medium text-gray-700 mb-2">Nom de l'index</h3>
                    <p class="text-blue-600 font-mono">{{ $indexName }}</p>
                </div>
            </div>
        </div>

        <!-- Indices Algolia -->
        <div class="mb-6 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Indices Algolia</h2>
            
            @if(isset($apiStatus['items']) && count($apiStatus['items']) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-700">Nom de l'index</th>
                                <th class="px-4 py-2 text-left text-gray-700">Entrées</th>
                                <th class="px-4 py-2 text-left text-gray-700">Taille</th>
                                <th class="px-4 py-2 text-left text-gray-700">Mise à jour</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($apiStatus['items'] as $index)
                                <tr class="border-t border-gray-200">
                                    <td class="px-4 py-2 font-medium">{{ $index['name'] }}</td>
                                    <td class="px-4 py-2">{{ $index['entries'] ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ isset($index['fileSize']) ? number_format($index['fileSize'] / 1024, 2) . ' KB' : 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ isset($index['updatedAt']) ? date('Y-m-d H:i:s', $index['updatedAt']) : 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded text-yellow-700">
                    Aucun index trouvé ou accessible avec vos identifiants.
                </div>
            @endif
        </div>
        
        <!-- Produits disponibles -->
        <div class="mb-6 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Produits à indexer</h2>
            
            @if(count($products) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-700">ID</th>
                                <th class="px-4 py-2 text-left text-gray-700">Nom</th>
                                <th class="px-4 py-2 text-left text-gray-700">Prix</th>
                                <th class="px-4 py-2 text-left text-gray-700">Catégorie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr class="border-t border-gray-200">
                                    <td class="px-4 py-2 font-medium">{{ $product->id }}</td>
                                    <td class="px-4 py-2">{{ $product->name }}</td>
                                    <td class="px-4 py-2">{{ number_format($product->price, 2) }} €</td>
                                    <td class="px-4 py-2">{{ $product->category ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded text-yellow-700">
                    Aucun produit disponible. Créez des produits pour les indexer dans Algolia.
                </div>
            @endif
        </div>
        
        <!-- Actions -->
        <div class="mb-6 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Actions de test</h2>
            
            <div class="flex flex-wrap gap-4" x-data="{ message: '' }">
                <form action="{{ route('dashboard') }}" method="GET" class="inline-block">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                        Retour au tableau de bord
                    </button>
                </form>
                
                <button 
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors"
                    x-on:click="fetch('/api/reindex-all').then(r => r.json()).then(data => { message = data.message })"
                >
                    Réindexer tous les produits
                </button>
                
                <div x-show="message" x-transition class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded text-blue-700 w-full">
                    <p x-text="message"></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
