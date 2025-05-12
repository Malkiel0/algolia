<?php

namespace App\GraphQL\Mutations;

use App\Models\ShippingAddress;
use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\Validator;

/**
 * Mutation GraphQL pour créer une adresse de livraison
 * Valide l’utilisateur, les champs obligatoires, et crée l’adresse
 */
class CreateShippingAddressMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createShippingAddress',
        'description' => 'Créer une nouvelle adresse de livraison pour un utilisateur',
    ];

    /**
     * Type de retour : ShippingAddressType
     */
    public function type(): Type
    {
        return GraphQL::type('ShippingAddress');
    }

    /**
     * Arguments attendus
     */
    public function args(): array
    {
        return [
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de l’utilisateur concerné',
            ],
            'full_name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nom complet du destinataire',
            ],
            'phone' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Téléphone du destinataire',
            ],
            'address' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Adresse complète',
            ],
            'city' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Ville',
            ],
            'country' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Pays',
            ],
            'postal_code' => [
                'type' => Type::string(),
                'description' => 'Code postal',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation avancée
     */
    public function resolve($root, $args)
    {
        // Validation de l’utilisateur
        $user = User::find($args['user_id']);
        if (!$user) {
            throw new \GraphQL\Error\Error('Utilisateur introuvable.');
        }
        // Validation des champs obligatoires
        $validator = Validator::make($args, [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);
        if ($validator->fails()) {
            throw new \GraphQL\Error\Error('Erreur de validation', null, null, null, null, null, [
                'validation' => $validator->errors()->toArray()
            ]);
        }
        // Création de l’adresse
        $address = ShippingAddress::create($args);
        return $address;
    }
}
