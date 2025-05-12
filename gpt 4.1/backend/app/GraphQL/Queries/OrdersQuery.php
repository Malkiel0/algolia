<?php

namespace App\GraphQL\Queries;

use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Query GraphQL pour lister les commandes avec pagination et filtres
 * Permet de filtrer par utilisateur, statut, date de création, etc.
 */
class OrdersQuery extends Query
{
    protected $attributes = [
        'name' => 'orders',
        'description' => 'Liste paginée et filtrée des commandes',
    ];

    /**
     * Type de retour : pagination d'OrderType
     */
    public function type(): Type
    {
        return GraphQL::paginate('Order');
    }

    /**
     * Arguments acceptés pour la recherche et la pagination
     * Exemple d'utilisation :
     * {
     *   orders(limit: 10, page: 1, user_id: 2, status: "en_cours") {
     *     data { id status total_amount user { id name } }
     *     paginatorInfo { count currentPage lastPage total }
     *   }
     * }
     */
    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'description' => 'Nombre de commandes par page',
                'defaultValue' => 10,
            ],
            'page' => [
                'type' => Type::int(),
                'description' => 'Page à afficher',
                'defaultValue' => 1,
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'Filtrer par ID utilisateur',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Filtrer par statut de commande',
            ],
            'created_from' => [
                'type' => Type::string(),
                'description' => 'Date de début (YYYY-MM-DD)',
            ],
            'created_to' => [
                'type' => Type::string(),
                'description' => 'Date de fin (YYYY-MM-DD)',
            ],
        ];
    }

    /**
     * Résolution de la query avec gestion des filtres et pagination
     */
    public function resolve($root, $args)
    {
        $query = Order::query();
        if (!empty($args['user_id'])) {
            $query->where('user_id', $args['user_id']);
        }
        if (!empty($args['status'])) {
            $query->where('status', $args['status']);
        }
        if (!empty($args['created_from'])) {
            $query->whereDate('created_at', '>=', $args['created_from']);
        }
        if (!empty($args['created_to'])) {
            $query->whereDate('created_at', '<=', $args['created_to']);
        }
        $limit = $args['limit'] ?? 10;
        $page = $args['page'] ?? 1;
        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
