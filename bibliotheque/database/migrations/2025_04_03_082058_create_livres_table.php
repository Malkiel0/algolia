<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('livres', function (Blueprint $table) {
            $table->id(); // Crée une colonne 'id' qui s'incrémente automatiquement
            $table->string('titre'); // Crée une colonne 'titre' qui contient du texte
            $table->string('auteur'); // Crée une colonne 'auteur' qui contient du texte
            $table->integer('annee_publication'); // Crée une colonne pour l'année (un nombre)
            $table->text('description')->nullable(); // Crée une colonne pour la description (peut être vide)
            $table->timestamps(); // Crée les colonnes 'created_at' et 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livres');
    }
};
