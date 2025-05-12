<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;

/**
 * Classe principale pour l'initialisation des données de l'application
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Génère les données initiales pour l'application.
     * 
     * Exécute tous les seeders dans l'ordre approprié pour éviter les problèmes de dépendances.
     */
    public function run(): void
    {
        // Générer des utilisateurs de test
        User::factory(10)->create();
        
        // Créer un utilisateur administrateur de test
        User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'admin@example.com',
        ]);
        
        // Générer 500 produits avec des données réalistes et variées
        $this->call([
            ProductSeeder::class,
        ]);
        
        // Espace pour ajouter d'autres seeders dans le futur
        // Categories, commandes, paiements, etc.
    }
}
