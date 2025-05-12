<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table des paiements pour enregistrer chaque transaction de paiement.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Identifiant unique du paiement
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Lien avec la commande payée
            $table->decimal('amount', 12, 2); // Montant payé
            $table->string('method'); // Méthode de paiement (card, mobile_money)
            $table->string('status')->default('pending'); // Statut du paiement
            $table->string('transaction_id')->nullable(); // Identifiant transactionnel externe
            $table->timestamp('paid_at')->nullable(); // Date/heure du paiement
            $table->timestamps(); // Dates de création et de modification
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
