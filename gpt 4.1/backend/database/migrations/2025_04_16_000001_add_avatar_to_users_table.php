<?php
// Migration clean pour ajouter le champ avatar à la table users
// Respecte la structure, pas de duplication, rollback propre
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute le champ avatar à la table users
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('status'); // Champ avatar après status
        });
    }

    /**
     * Supprime le champ avatar si rollback
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }
};
