<?php

namespace App\GraphQL\Queries;

use App\Models\ShippingMethod;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

/**
 * Query GraphQL pour lister les méthodes de livraison avec pagination et filtres
 */
class ShippingMethodsQuery extends Query
{
    protected $attributes = [
        'name' => 'shippingMethods',
        'description' => 'Liste paginée et filtrée des méthodes de livraison',
    ];

    /**
     * Type de retour : pagination de ShippingMethodType
     */
    public function type(): Type
    {
        return \Rebing\GraphQL\Support\Facades\GraphQL::paginate('ShippingMethod');
    }

    /**
     * Arguments acceptés pour la recherche et la pagination
     */
    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'description' => 'Nombre de méthodes par page',
                'defaultValue' => 10,
            ],
            'page' => [
                'type' => Type::int(),
                'description' => 'Page à afficher',
                'defaultValue' => 1,
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Filtrer par nom',
            ],
        ];
    }

    /**
     * Résolution de la query avec gestion des filtres et pagination
     */
    public function resolve($root, $args)
    {
        $query = ShippingMethod::query();
        if (!empty($args['name'])) {
            $query->where('name', 'like', '%' . $args['name'] . '%');
        }
        $limit = $args['limit'] ?? 10;
        $page = $args['page'] ?? 1;
        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
