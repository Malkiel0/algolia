<?php

namespace App\GraphQL\Queries;

use App\Models\ShippingAddress;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Query GraphQL pour obtenir le détail d’une adresse de livraison par ID
 */
class ShippingAddressQuery extends Query
{
    protected $attributes = [
        'name' => 'shippingAddress',
        'description' => 'Détail d’une adresse de livraison par son ID',
    ];

    /**
     * Type de retour : ShippingAddressType
     */
    public function type(): Type
    {
        return GraphQL::type('ShippingAddress');
    }

    /**
     * Arguments acceptés : id obligatoire
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de l’adresse de livraison',
            ],
        ];
    }

    /**
     * Résolution de la query
     */
    public function resolve($root, $args)
    {
        return ShippingAddress::findOrFail($args['id']);
    }
}
