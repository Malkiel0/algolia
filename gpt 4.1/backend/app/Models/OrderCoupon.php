<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la liaison coupon/commande.
 */
class OrderCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'coupon_id', 'discount_applied'
    ];
}
