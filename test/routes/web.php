<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Route de test complète pour Algolia avec vérification détaillée
use Algolia\AlgoliaSearch\SearchClient;
use App\Models\Product;

Route::get('/test-algolia', function() {
    try {
        // Récupération des informations de configuration
        $appId = config('scout.algolia.id');
        $apiKey = config('scout.algolia.secret');
        $indexName = 'products_index';
        
        // Vérification des paramètres de configuration
        if (empty($appId) || empty($apiKey)) {
            return '<div style="color:red;font-weight:bold">Erreur de configuration: APP_ID ou API_KEY manquants dans .env</div>';
        }
        
        // Initialisation du client Algolia
        $client = SearchClient::create($appId, $apiKey);
        
        // Récupération des informations du compte
        $apiStatus = $client->listIndices();
        
        // Initialisation de l'index
        $index = $client->initIndex($indexName);
        
        // Récupération de quelques produits pour tester
        $products = Product::take(5)->get();
        
        // Retour d'informations détaillées
        return view('test-algolia', [
            'status' => 'success',
            'appId' => $appId,
            'indexName' => $indexName,
            'apiStatus' => $apiStatus,
            'products' => $products
        ]);
    } catch (\Exception $e) {
        return '<div style="color:red;font-weight:bold">Erreur Algolia: ' . $e->getMessage() . '</div>';
    }
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


require __DIR__.'/auth.php';
