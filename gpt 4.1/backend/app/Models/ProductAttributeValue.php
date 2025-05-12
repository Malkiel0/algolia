<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour les valeurs d'attributs de produit (ex : XL, Bleu).
 */
class ProductAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value'];

    /**
     * Attribut parent.
     */
    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id');
    }
}
