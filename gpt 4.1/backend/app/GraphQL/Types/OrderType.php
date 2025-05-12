<?php

namespace App\GraphQL\Types;

use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Type GraphQL pour l'entité Commande (Order)
 * Expose tous les champs utiles et les relations (user, items, paiements, etc.)
 */
class OrderType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Order',
        'description' => 'Commande client',
        'model' => Order::class,
    ];

    /**
     * Définition des champs exposés dans l'API GraphQL
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifiant unique de la commande',
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'ID du client',
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'Données du client',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Statut de la commande',
            ],
            'total_amount' => [
                'type' => Type::float(),
                'description' => 'Montant total de la commande',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'Date de création',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'Date de modification',
            ],
            // Relations
            'items' => [
                'type' => Type::listOf(GraphQL::type('OrderItem')),
                'description' => 'Liste des articles de la commande',
            ],
            'payments' => [
                'type' => Type::listOf(GraphQL::type('Payment')),
                'description' => 'Paiements associés à la commande',
            ],
            'shipping_address' => [
                'type' => GraphQL::type('ShippingAddress'),
                'description' => 'Adresse de livraison',
            ],
        ];
    }
}
