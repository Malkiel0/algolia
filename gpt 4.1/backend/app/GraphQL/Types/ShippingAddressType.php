<?php

namespace App\GraphQL\Types;

use App\Models\ShippingAddress;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Type GraphQL pour une adresse de livraison
 */
class ShippingAddressType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ShippingAddress',
        'description' => 'Adresse de livraison d’un utilisateur',
        'model' => ShippingAddress::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifiant unique de l’adresse',
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'ID de l’utilisateur concerné',
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'Utilisateur concerné',
            ],
            'full_name' => [
                'type' => Type::string(),
                'description' => 'Nom complet du destinataire',
            ],
            'phone' => [
                'type' => Type::string(),
                'description' => 'Téléphone du destinataire',
            ],
            'address' => [
                'type' => Type::string(),
                'description' => 'Adresse complète',
            ],
            'city' => [
                'type' => Type::string(),
                'description' => 'Ville',
            ],
            'country' => [
                'type' => Type::string(),
                'description' => 'Pays',
            ],
            'postal_code' => [
                'type' => Type::string(),
                'description' => 'Code postal',
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
