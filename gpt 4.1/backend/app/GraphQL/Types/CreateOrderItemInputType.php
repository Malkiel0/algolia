<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

/**
 * InputType GraphQL pour la création d'un article de commande
 * Utilisé dans la mutation createOrder
 */
class CreateOrderItemInputType extends InputType
{
    protected $attributes = [
        'name' => 'CreateOrderItemInput',
        'description' => 'Input pour un article lors de la création de commande',
    ];

    public function fields(): array
    {
        return [
            'product_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID du produit',
            ],
            'quantity' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Quantité commandée',
            ],
        ];
    }
}
