<?php

namespace App\GraphQL\Queries;

use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Query GraphQL pour obtenir le détail d'une commande par ID
 */
class OrderQuery extends Query
{
    protected $attributes = [
        'name' => 'order',
        'description' => 'Détail d’une commande par son ID',
    ];

    /**
     * Type de retour : OrderType
     */
    public function type(): Type
    {
        return GraphQL::type('Order');
    }

    /**
     * Arguments acceptés : id obligatoire
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de la commande',
            ],
        ];
    }

    /**
     * Résolution de la query
     */
    public function resolve($root, $args)
    {
        return Order::findOrFail($args['id']);
    }
}
