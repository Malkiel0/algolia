<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la table des adresses de livraison.
 */
class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'full_name', 'phone', 'address', 'city', 'country', 'postal_code'
    ];

    /**
     * Utilisateur concerné.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
