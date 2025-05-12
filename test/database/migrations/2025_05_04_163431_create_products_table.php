<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration pour créer la table des produits avec tous les champs nécessaires.
     * Cette table stocke tous les produits de la boutique avec leurs caractéristiques.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->text('description')->nullable();
            $table->json('attributes')->nullable();
            $table->string('color')->nullable();
            $table->string('material')->nullable();
            $table->integer('stock')->default(0);
            $table->string('sku')->unique();
            $table->timestamps();
            
            // Index pour améliorer les performances de recherche
            $table->index('name');
            $table->index('category');
            $table->index('subcategory');
            $table->index('price');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
