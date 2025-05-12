<?php

namespace App\GraphQL\Types;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

/**
 * Type GraphQL pour l'entité Produit (Product)
 * Permet de typer les réponses et inputs pour l'API GraphQL
 */
class ProductType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Product',
        'description' => 'Un produit du catalogue',
        'model' => Product::class,
    ];

    /**
     * Définition des champs exposés dans l'API GraphQL
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifiant unique du produit',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Nom du produit',
            ],
            'slug' => [
                'type' => Type::string(),
                'description' => 'Slug SEO',
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'Description détaillée',
            ],
            'price' => [
                'type' => Type::float(),
                'description' => 'Prix de base',
            ],
            'discount_price' => [
                'type' => Type::float(),
                'description' => 'Prix remisé',
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'Type de produit (simple, variable, bundle)',
            ],
            'stock_quantity' => [
                'type' => Type::int(),
                'description' => 'Stock disponible',
            ],
            'sku' => [
                'type' => Type::string(),
                'description' => 'Référence interne',
            ],
            'is_active' => [
                'type' => Type::boolean(),
                'description' => 'Statut d’activation',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'Date de création',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'Date de modification',
            ],
        ];
    }
}
