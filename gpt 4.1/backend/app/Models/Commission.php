<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la commission prélevée sur une commande.
 */
class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'amount', 'collected'
    ];

    /**
     * Commande concernée.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
