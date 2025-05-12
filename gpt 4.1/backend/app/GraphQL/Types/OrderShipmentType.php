<?php

namespace App\GraphQL\Types;

use App\Models\OrderShipment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Type GraphQL pour une expédition de commande
 */
class OrderShipmentType extends GraphQLType
{
    protected $attributes = [
        'name' => 'OrderShipment',
        'description' => 'Expédition d’une commande',
        'model' => OrderShipment::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifiant unique de l’expédition',
            ],
            'order_id' => [
                'type' => Type::int(),
                'description' => 'ID de la commande',
            ],
            'order' => [
                'type' => GraphQL::type('Order'),
                'description' => 'Commande concernée',
            ],
            'shipping_method_id' => [
                'type' => Type::int(),
                'description' => 'ID de la méthode de livraison',
            ],
            'shipping_method' => [
                'type' => GraphQL::type('ShippingMethod'),
                'description' => 'Méthode de livraison utilisée',
            ],
            'tracking_number' => [
                'type' => Type::string(),
                'description' => 'Numéro de suivi',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Statut de l’expédition',
            ],
            'shipped_at' => [
                'type' => Type::string(),
                'description' => 'Date d’envoi',
            ],
            'delivered_at' => [
                'type' => Type::string(),
                'description' => 'Date de livraison',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'Date de création',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'Date de modification',
            ],
        ];
    }
}
