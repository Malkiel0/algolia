<?php

namespace App\GraphQL\Mutations;

use App\Models\OrderShipment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Validator;

/**
 * Mutation GraphQL pour mettre à jour une expédition de commande
 * Valide les champs, empêche la modification de la commande liée
 */
class UpdateOrderShipmentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateOrderShipment',
        'description' => 'Mettre à jour une expédition de commande existante',
    ];

    /**
     * Type de retour : OrderShipmentType
     */
    public function type(): Type
    {
        return \Rebing\GraphQL\Support\Facades\GraphQL::type('OrderShipment');
    }

    /**
     * Arguments attendus
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de l’expédition à modifier',
            ],
            'shipping_method_id' => [
                'type' => Type::int(),
                'description' => 'Nouvelle méthode de livraison',
            ],
            'tracking_number' => [
                'type' => Type::string(),
                'description' => 'Numéro de suivi',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Nouveau statut',
            ],
            'shipped_at' => [
                'type' => Type::string(),
                'description' => 'Date d’envoi (YYYY-MM-DD HH:MM:SS)',
            ],
            'delivered_at' => [
                'type' => Type::string(),
                'description' => 'Date de livraison (YYYY-MM-DD HH:MM:SS)',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation avancée
     */
    public function resolve($root, $args)
    {
        $shipment = OrderShipment::findOrFail($args['id']);
        // On ne permet pas de changer la commande liée
        unset($args['order_id']);
        // Validation des champs modifiables
        $validator = Validator::make($args, [
            'shipping_method_id' => 'sometimes|integer|exists:shipping_methods,id',
            'tracking_number' => 'sometimes|string|max:100',
            'status' => 'sometimes|string|max:50',
            'shipped_at' => 'sometimes|date',
            'delivered_at' => 'sometimes|date',
        ]);
        if ($validator->fails()) {
            throw new \GraphQL\Error\Error('Erreur de validation', null, null, null, null, null, [
                'validation' => $validator->errors()->toArray()
            ]);
        }
        $shipment->update($args);
        return $shipment;
    }
}
