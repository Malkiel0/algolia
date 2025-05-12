<?php

namespace App\GraphQL\Queries;

use App\Models\ShippingAddress;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Query GraphQL pour lister les adresses de livraison avec pagination et filtres
 */
class ShippingAddressesQuery extends Query
{
    protected $attributes = [
        'name' => 'shippingAddresses',
        'description' => 'Liste paginée et filtrée des adresses de livraison',
    ];

    /**
     * Type de retour : pagination de ShippingAddressType
     */
    public function type(): Type
    {
        return GraphQL::paginate('ShippingAddress');
    }

    /**
     * Arguments acceptés pour la recherche et la pagination
     */
    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'description' => 'Nombre d’adresses par page',
                'defaultValue' => 10,
            ],
            'page' => [
                'type' => Type::int(),
                'description' => 'Page à afficher',
                'defaultValue' => 1,
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'Filtrer par utilisateur',
            ],
            'city' => [
                'type' => Type::string(),
                'description' => 'Filtrer par ville',
            ],
            'country' => [
                'type' => Type::string(),
                'description' => 'Filtrer par pays',
            ],
        ];
    }

    /**
     * Résolution de la query avec gestion des filtres et pagination
     */
    public function resolve($root, $args)
    {
        $query = ShippingAddress::query();
        if (!empty($args['user_id'])) {
            $query->where('user_id', $args['user_id']);
        }
        if (!empty($args['city'])) {
            $query->where('city', 'like', '%' . $args['city'] . '%');
        }
        if (!empty($args['country'])) {
            $query->where('country', 'like', '%' . $args['country'] . '%');
        }
        $limit = $args['limit'] ?? 10;
        $page = $args['page'] ?? 1;
        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
