<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Routes API
|--------------------------------------------------------------------------
|
| Ces routes sont utilisées pour les appels API de l'application
| Toutes les routes sont préfixées par 'api/'
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Route pour réindexer tous les produits dans Algolia
 * Utilisée par la page de diagnostic Algolia
 */
Route::get('/reindex-all', function () {
    try {
        // Réindexation de tous les produits
        Product::all()->searchable();
        
        return response()->json([
            'success' => true,
            'message' => 'Tous les produits ont été réindexés avec succès!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la réindexation: ' . $e->getMessage()
        ], 500);
    }
});
