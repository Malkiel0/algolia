<?php

namespace App\GraphQL\Types;

use App\Models\ShippingMethod;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

/**
 * Type GraphQL pour une méthode de livraison
 */
class ShippingMethodType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ShippingMethod',
        'description' => 'Méthode de livraison (standard, express, etc.)',
        'model' => ShippingMethod::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifiant unique de la méthode',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Nom de la méthode (ex : standard, express)',
            ],
            'price' => [
                'type' => Type::float(),
                'description' => 'Prix de la livraison',
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
