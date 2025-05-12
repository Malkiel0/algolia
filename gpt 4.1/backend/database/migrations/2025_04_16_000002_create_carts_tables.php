<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table des paniers (cart) pour stocker les paniers en cours des utilisateurs ou visiteurs anonymes.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // Identifiant unique du panier
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Lien éventuel avec un utilisateur connecté
            $table->string('session_id')->nullable(); // Pour les visiteurs anonymes
            $table->timestamps(); // Dates de création et de modification
        });

        /**
         * Table des articles du panier (cart_items).
         * Chaque entrée représente un produit (ou variante) dans un panier.
         */
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'article du panier
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade'); // Lien avec le panier
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Lien avec le produit
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('set null'); // Variante éventuelle
            $table->integer('quantity'); // Quantité commandée
            $table->decimal('unit_price', 12, 2); // Prix unitaire au moment de l'ajout
            $table->timestamps(); // Dates de création et de modification
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
