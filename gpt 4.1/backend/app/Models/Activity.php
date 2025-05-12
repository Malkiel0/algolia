<?php
// app/Models/Activity.php
// Modèle Eloquent pour journaliser l’activité récente (commandes, clients, produits…)
// Clean code, ultra commenté, relations respectées

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'type',    // commande, client, produit, autre
        'message', // description lisible
        'data',    // infos supplémentaires (json)
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * L’utilisateur lié à l’activité (optionnel)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
