<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la table des méthodes de livraison.
 */
class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price'
    ];

    /**
     * Expéditions utilisant cette méthode.
     */
    public function shipments()
    {
        return $this->hasMany(OrderShipment::class);
    }
}
