<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table des retours et remboursements (returns).
     */
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id(); // Identifiant unique du retour
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Commande concernée
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Client concerné
            $table->string('reason')->nullable(); // Raison du retour
            $table->string('status')->default('pending'); // Statut du retour (pending, accepted, rejected, refunded)
            $table->decimal('refund_amount', 12, 2)->nullable(); // Montant remboursé
            $table->timestamps(); // Dates de création et de modification
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
