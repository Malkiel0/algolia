<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la table des produits.
 *
 * Chaque instance représente un produit du catalogue.
 *
 * Relations principales :
 * - variants : variantes du produit (ex : tailles, couleurs)
 * - attributes : attributs dynamiques (taille, couleur...)
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Les attributs pouvant être assignés en masse.
     */
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'discount_price', 'type', 'stock_quantity', 'sku', 'is_active'
    ];

    /**
     * Retourne les variantes de ce produit.
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Retourne les attributs dynamiques du produit via les variantes.
     */
    public function attributes()
    {
        return $this->belongsToMany(ProductAttribute::class, 'product_attribute_values', 'id', 'attribute_id');
    }

    /**
     * Articles de commande contenant ce produit.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Articles de panier contenant ce produit.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}

/**
 * Modèle Eloquent pour les variantes de produits.
 */
class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'name', 'price', 'stock_quantity', 'sku'
    ];

    /**
     * Produit parent de la variante.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

/**
 * Modèle pour les attributs dynamiques (ex : taille, couleur).
 */
class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Valeurs possibles pour cet attribut.
     */
    public function values()
    {
        return $this->hasMany(ProductAttributeValue::class, 'attribute_id');
    }
}

/**
 * Valeurs d'attributs (ex : XL, Bleu).
 */
class ProductAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value'];

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id');
    }
}
