<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table des transactions financières (financial_transactions).
     */
    public function up(): void
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la transaction
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Utilisateur concerné
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null'); // Commande liée (optionnel)
            $table->string('type'); // Type de transaction (payment, commission, refund, withdrawal)
            $table->decimal('amount', 12, 2); // Montant de la transaction
            $table->string('status')->default('pending'); // Statut de la transaction
            $table->timestamps(); // Dates de création et de modification
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
