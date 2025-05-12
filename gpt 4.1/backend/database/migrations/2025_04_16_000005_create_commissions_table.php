<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table des commissions pour enregistrer la part prélevée par l'application sur chaque commande.
     */
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la commission
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Lien avec la commande concernée
            $table->decimal('amount', 12, 2); // Montant de la commission (calculé)
            $table->boolean('collected')->default(false); // Indique si la commission a été encaissée
            $table->timestamps(); // Dates de création et de modification
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
