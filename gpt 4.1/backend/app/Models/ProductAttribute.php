<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour les attributs dynamiques de produit (taille, couleur, etc.).
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
