<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la table des transactions financières.
 */
class FinancialTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'type', 'amount', 'status'
    ];

    /**
     * Utilisateur concerné.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Commande liée (optionnelle).
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
