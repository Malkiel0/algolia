<?php
// database/migrations/2025_04_16_000010_create_activities_table.php
// Migration pour journal d’activité Zénith (commandes, clients, produits, etc.)
// Clean code, ultra commenté, relations respectées

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Crée la table activities pour journaliser l’activité récente
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 24); // commande, client, produit, autre
            $table->string('message');  // description lisible
            $table->json('data')->nullable(); // infos supplémentaires (optionnel)
            $table->timestamps();
        });
    }

    /**
     * Supprime la table activities
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
