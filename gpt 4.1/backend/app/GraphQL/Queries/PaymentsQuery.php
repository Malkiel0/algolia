<?php

namespace App\GraphQL\Queries;

use App\Models\Payment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Query GraphQL pour lister les paiements avec pagination et filtres
 */
class PaymentsQuery extends Query
{
    protected $attributes = [
        'name' => 'payments',
        'description' => 'Liste paginée et filtrée des paiements',
    ];

    /**
     * Type de retour : pagination de PaymentType
     */
    public function type(): Type
    {
        return GraphQL::paginate('Payment');
    }

    /**
     * Arguments acceptés pour la recherche et la pagination
     */
    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'description' => 'Nombre de paiements par page',
                'defaultValue' => 10,
            ],
            'page' => [
                'type' => Type::int(),
                'description' => 'Page à afficher',
                'defaultValue' => 1,
            ],
            'order_id' => [
                'type' => Type::int(),
                'description' => 'Filtrer par ID de commande',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Filtrer par statut du paiement',
            ],
            'method' => [
                'type' => Type::string(),
                'description' => 'Filtrer par méthode de paiement',
            ],
        ];
    }

    /**
     * Résolution de la query avec gestion des filtres et pagination
     */
    public function resolve($root, $args)
    {
        $query = Payment::query();
        if (!empty($args['order_id'])) {
            $query->where('order_id', $args['order_id']);
        }
        if (!empty($args['status'])) {
            $query->where('status', $args['status']);
        }
        if (!empty($args['method'])) {
            $query->where('method', $args['method']);
        }
        $limit = $args['limit'] ?? 10;
        $page = $args['page'] ?? 1;
        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
