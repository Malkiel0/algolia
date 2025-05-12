<?php

namespace App\GraphQL\Queries;

use App\Models\OrderShipment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Query GraphQL pour obtenir le détail d’une expédition par ID
 */
class OrderShipmentQuery extends Query
{
    protected $attributes = [
        'name' => 'orderShipment',
        'description' => 'Détail d’une expédition de commande par son ID',
    ];

    /**
     * Type de retour : OrderShipmentType
     */
    public function type(): Type
    {
        return GraphQL::type('OrderShipment');
    }

    /**
     * Arguments acceptés : id obligatoire
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de l’expédition',
            ],
        ];
    }

    /**
     * Résolution de la query
     */
    public function resolve($root, $args)
    {
        return OrderShipment::findOrFail($args['id']);
    }
}
