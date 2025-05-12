<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la table des paniers (carts).
 * Un panier appartient à un utilisateur ou à une session anonyme.
 *
 * Relations :
 * - user : propriétaire du panier (si connecté)
 * - items : articles présents dans le panier
 */
class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'session_id'
    ];

    /**
     * Propriétaire du panier (utilisateur connecté).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Articles du panier.
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}

/**
 * Article du panier (cart_items).
 * Chaque ligne correspond à un produit (ou variante) dans un panier.
 */
class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id', 'product_id', 'variant_id', 'quantity', 'unit_price'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
