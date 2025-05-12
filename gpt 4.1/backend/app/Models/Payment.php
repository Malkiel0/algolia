<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la table des paiements.
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'amount', 'method', 'status', 'transaction_id', 'paid_at'
    ];

    /**
     * Commande associée au paiement.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
