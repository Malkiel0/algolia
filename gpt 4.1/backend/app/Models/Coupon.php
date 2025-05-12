<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la table des coupons de réduction.
 */
class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount_type', 'discount_value', 'max_usage', 'used_count', 'expires_at', 'is_active'
    ];

    /**
     * Commandes ayant utilisé ce coupon.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_coupons');
    }
}
