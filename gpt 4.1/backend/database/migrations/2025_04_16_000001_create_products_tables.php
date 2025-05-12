<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crée la table des produits.
     * Cette table stocke les informations de base sur chaque produit du catalogue.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Identifiant unique du produit
            $table->string('name'); // Nom du produit
            $table->string('slug')->unique(); // Slug SEO unique
            $table->text('description')->nullable(); // Description détaillée
            $table->decimal('price', 12, 2); // Prix de base
            $table->decimal('discount_price', 12, 2)->nullable(); // Prix remisé (optionnel)
            $table->string('type')->default('simple'); // Type de produit (simple, variable, bundle)
            $table->integer('stock_quantity')->default(0); // Stock disponible
            $table->string('sku')->unique(); // Référence interne unique
            $table->boolean('is_active')->default(true); // Statut d'activation
            $table->timestamps(); // Dates de création et de modification
        });

        /**
         * Table des variantes de produits (pour les produits variables).
         * Permet de gérer différentes versions d'un même produit (ex : taille, couleur).
         */
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Référence au produit parent
            $table->string('name'); // Nom de la variante (ex : "Rouge - L")
            $table->decimal('price', 12, 2); // Prix de la variante
            $table->integer('stock_quantity')->default(0); // Stock spécifique à la variante
            $table->string('sku')->unique(); // Référence unique de la variante
            $table->timestamps();
        });

        /**
         * Table des attributs de produits (ex : taille, couleur).
         * Permet de définir des caractéristiques dynamiques.
         */
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom de l'attribut (ex : taille)
            $table->timestamps();
        });

        /**
         * Table des valeurs d'attributs de produits (ex : "XL", "Bleu").
         * Chaque valeur est liée à un attribut.
         */
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained('product_attributes')->onDelete('cascade'); // Référence à l'attribut
            $table->string('value'); // Valeur de l'attribut (ex : "XL")
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attribute_values');
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('products');
    }
};
