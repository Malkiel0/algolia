<?php

namespace App\GraphQL\Queries;

use App\Models\OrderShipment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Query GraphQL pour lister les expéditions de commande avec pagination et filtres
 */
class OrderShipmentsQuery extends Query
{
    protected $attributes = [
        'name' => 'orderShipments',
        'description' => 'Liste paginée et filtrée des expéditions de commande',
    ];

    /**
     * Type de retour : pagination de OrderShipmentType
     */
    public function type(): Type
    {
        return GraphQL::paginate('OrderShipment');
    }

    /**
     * Arguments acceptés pour la recherche et la pagination
     */
    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'description' => 'Nombre d’expéditions par page',
                'defaultValue' => 10,
            ],
            'page' => [
                'type' => Type::int(),
                'description' => 'Page à afficher',
                'defaultValue' => 1,
            ],
            'order_id' => [
                'type' => Type::int(),
                'description' => 'Filtrer par commande',
            ],
            'shipping_method_id' => [
                'type' => Type::int(),
                'description' => 'Filtrer par méthode de livraison',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Filtrer par statut',
            ],
        ];
    }

    /**
     * Résolution de la query avec gestion des filtres et pagination
     */
    public function resolve($root, $args)
    {
        $query = OrderShipment::query();
        if (!empty($args['order_id'])) {
            $query->where('order_id', $args['order_id']);
        }
        if (!empty($args['shipping_method_id'])) {
            $query->where('shipping_method_id', $args['shipping_method_id']);
        }
        if (!empty($args['status'])) {
            $query->where('status', $args['status']);
        }
        $limit = $args['limit'] ?? 10;
        $page = $args['page'] ?? 1;
        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
