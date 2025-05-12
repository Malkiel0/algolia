<?php

namespace App\GraphQL\Types;

use App\Models\Payment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

/**
 * Type GraphQL pour un paiement lié à une commande
 */
class PaymentType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Payment',
        'description' => 'Paiement d’une commande',
        'model' => Payment::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifiant du paiement',
            ],
            'order_id' => [
                'type' => Type::int(),
                'description' => 'ID de la commande liée',
            ],
            'amount' => [
                'type' => Type::float(),
                'description' => 'Montant payé',
            ],
            'method' => [
                'type' => Type::string(),
                'description' => 'Méthode de paiement',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Statut du paiement',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'Date du paiement',
            ],
        ];
    }
}
