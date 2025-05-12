<?php

namespace App\GraphQL\Types;

use App\Models\OrderItem;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Type GraphQL pour un article de commande (OrderItem)
 */
class OrderItemType extends GraphQLType
{
    protected $attributes = [
        'name' => 'OrderItem',
        'description' => 'Article d’une commande',
        'model' => OrderItem::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifiant unique de l’article',
            ],
            'order_id' => [
                'type' => Type::int(),
                'description' => 'ID de la commande',
            ],
            'product_id' => [
                'type' => Type::int(),
                'description' => 'ID du produit',
            ],
            'product' => [
                'type' => GraphQL::type('Product'),
                'description' => 'Produit commandé',
            ],
            'quantity' => [
                'type' => Type::int(),
                'description' => 'Quantité commandée',
            ],
            'unit_price' => [
                'type' => Type::float(),
                'description' => 'Prix unitaire',
            ],
            'total_price' => [
                'type' => Type::float(),
                'description' => 'Prix total pour cet article',
            ],
        ];
    }
}
