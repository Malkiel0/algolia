<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table des coupons de réduction (coupons).
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id(); // Identifiant unique du coupon
            $table->string('code')->unique(); // Code du coupon
            $table->string('discount_type'); // Type de remise (percentage, fixed)
            $table->decimal('discount_value', 12, 2); // Valeur de la remise
            $table->integer('max_usage')->nullable(); // Nombre maximal d'utilisations
            $table->integer('used_count')->default(0); // Nombre d'utilisations déjà faites
            $table->timestamp('expires_at')->nullable(); // Date d'expiration
            $table->boolean('is_active')->default(true); // Statut d'activation
            $table->timestamps(); // Dates de création et de modification
        });

        /**
         * Table de liaison entre commandes et coupons (order_coupons).
         */
        Schema::create('order_coupons', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Commande concernée
            $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade'); // Coupon utilisé
            $table->decimal('discount_applied', 12, 2); // Montant de la remise appliquée
            $table->timestamps(); // Dates de création et de modification
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_coupons');
        Schema::dropIfExists('coupons');
    }
};
