<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la table des expéditions de commande.
 */
class OrderShipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'shipping_method_id', 'tracking_number', 'status', 'shipped_at', 'delivered_at'
    ];

    /**
     * Commande associée à l'expédition.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    /**
     * Méthode de livraison utilisée.
     */
    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }
}
