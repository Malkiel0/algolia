<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table des adresses de livraison (shipping_addresses).
     */
    public function up(): void
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'adresse
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Utilisateur concerné
            $table->string('full_name'); // Nom complet du destinataire
            $table->string('phone'); // Téléphone du destinataire
            $table->string('address'); // Adresse complète
            $table->string('city'); // Ville
            $table->string('country'); // Pays
            $table->string('postal_code')->nullable(); // Code postal
            $table->timestamps(); // Dates de création et de modification
        });

        /**
         * Table des méthodes de livraison (shipping_methods).
         */
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la méthode
            $table->string('name'); // Nom de la méthode (standard, express...)
            $table->decimal('price', 12, 2); // Prix de la livraison
            $table->timestamps(); // Dates de création et de modification
        });

        /**
         * Table des expéditions de commande (order_shipments).
         */
        Schema::create('order_shipments', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'expédition
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Commande concernée
            $table->foreignId('shipping_method_id')->constrained('shipping_methods')->onDelete('cascade'); // Méthode de livraison
            $table->string('tracking_number')->nullable(); // Numéro de suivi
            $table->string('status')->default('pending'); // Statut de l'expédition
            $table->timestamp('shipped_at')->nullable(); // Date d'envoi
            $table->timestamp('delivered_at')->nullable(); // Date de livraison
            $table->timestamps(); // Dates de création et de modification
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_shipments');
        Schema::dropIfExists('shipping_methods');
        Schema::dropIfExists('shipping_addresses');
    }
};
