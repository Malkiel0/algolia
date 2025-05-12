<?php

namespace App\GraphQL\Mutations;

use App\Models\ShippingAddress;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Validator;

/**
 * Mutation GraphQL pour mettre à jour une adresse de livraison
 * Valide les champs, empêche la modification de l’utilisateur
 */
class UpdateShippingAddressMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateShippingAddress',
        'description' => 'Mettre à jour une adresse de livraison existante',
    ];

    /**
     * Type de retour : ShippingAddressType
     */
    public function type(): Type
    {
        return \Rebing\GraphQL\Support\Facades\GraphQL::type('ShippingAddress');
    }

    /**
     * Arguments attendus
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de l’adresse à modifier',
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
        ];
    }

    /**
     * Résolution de la mutation avec validation avancée
     */
    public function resolve($root, $args)
    {
        $address = ShippingAddress::findOrFail($args['id']);
        // On ne permet pas de changer l’utilisateur lié
        unset($args['user_id']);
        // Validation des champs modifiables
        $validator = Validator::make($args, [
            'full_name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:50',
            'address' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:100',
            'country' => 'sometimes|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);
        if ($validator->fails()) {
            throw new \GraphQL\Error\Error('Erreur de validation', null, null, null, null, null, [
                'validation' => $validator->errors()->toArray()
            ]);
        }
        $address->update($args);
        // Journalisation de la modification adresse de livraison dans Activity
        \App\Models\Activity::create([
            'user_id' => auth()->id() ?? null,
            'type' => 'adresse_livraison',
            'message' => 'Adresse de livraison modifiée',
            'data' => [
                'shipping_address_id' => $address->id,
                'fields_updated' => array_keys($args),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'updated_at' => now()->toDateTimeString(),
            ],
        ]);
        return $address;
    }
}
