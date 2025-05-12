<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la table des retours et remboursements.
 */
class Returns extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'user_id', 'reason', 'status', 'refund_amount'
    ];

    /**
     * Commande concernée par le retour.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    /**
     * Client ayant demandé le retour.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
