<?php

namespace App\GraphQL\Queries;

use App\Models\ShippingMethod;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

/**
 * Query GraphQL pour obtenir le détail d'une méthode de livraison par ID
 */
class ShippingMethodQuery extends Query
{
    protected $attributes = [
        'name' => 'shippingMethod',
        'description' => 'Détail d’une méthode de livraison par son ID',
    ];

    /**
     * Type de retour : ShippingMethodType
     */
    public function type(): Type
    {
        return \Rebing\GraphQL\Support\Facades\GraphQL::type('ShippingMethod');
    }

    /**
     * Arguments acceptés : id obligatoire
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de la méthode de livraison',
            ],
        ];
    }

    /**
     * Résolution de la query
     */
    public function resolve($root, $args)
    {
        return ShippingMethod::findOrFail($args['id']);
    }
}
