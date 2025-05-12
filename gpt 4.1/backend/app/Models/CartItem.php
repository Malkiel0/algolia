<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour les articles du panier (cart_items).
 * Chaque ligne correspond à un produit (ou variante) dans un panier.
 */
class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id', 'product_id', 'variant_id', 'quantity', 'unit_price'
    ];

    /**
     * Panier parent.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    /**
     * Produit concerné.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    /**
     * Variante concernée (optionnelle).
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
