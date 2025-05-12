<?php

namespace App\GraphQL\Queries;

use App\Models\Payment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Query GraphQL pour obtenir le détail d'un paiement par ID
 */
class PaymentQuery extends Query
{
    protected $attributes = [
        'name' => 'payment',
        'description' => 'Détail d’un paiement par son ID',
    ];

    /**
     * Type de retour : PaymentType
     */
    public function type(): Type
    {
        return GraphQL::type('Payment');
    }

    /**
     * Arguments acceptés : id obligatoire
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID du paiement',
            ],
        ];
    }

    /**
     * Résolution de la query
     */
    public function resolve($root, $args)
    {
        return Payment::findOrFail($args['id']);
    }
}
