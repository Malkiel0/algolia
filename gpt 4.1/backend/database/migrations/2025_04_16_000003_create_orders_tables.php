<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table des commandes (orders) pour enregistrer chaque achat.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la commande
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Acheteur
            $table->string('status')->default('pending'); // Statut de la commande (pending, paid, shipped, delivered, canceled, refunded)
            $table->decimal('total_amount', 12, 2); // Montant total payé (hors livraison)
            $table->decimal('commission_amount', 12, 2)->default(0); // Montant de la commission prélevée
            $table->string('payment_method')->nullable(); // Méthode de paiement (card, mobile_money)
            $table->string('payment_status')->default('pending'); // Statut du paiement
            $table->timestamps(); // Dates de création et de modification
        });

        /**
         * Table des articles de commande (order_items).
         */
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'article de commande
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Lien avec la commande
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Produit commandé
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('set null'); // Variante éventuelle
            $table->integer('quantity'); // Quantité commandée
            $table->decimal('unit_price', 12, 2); // Prix unitaire au moment de l'achat
            $table->decimal('subtotal', 12, 2); // Sous-total pour cet article
            $table->timestamps(); // Dates de création et de modification
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
