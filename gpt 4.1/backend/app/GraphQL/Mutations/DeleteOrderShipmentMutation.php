<?php

namespace App\GraphQL\Mutations;

use App\Models\OrderShipment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

/**
 * Mutation GraphQL pour supprimer une expédition de commande
 * Suppression impossible si l’expédition est livrée
 */
class DeleteOrderShipmentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteOrderShipment',
        'description' => 'Supprimer une expédition de commande (si non livrée)',
    ];

    /**
     * Type de retour : booléen (succès)
     */
    public function type(): Type
    {
        return Type::boolean();
    }

    /**
     * Arguments attendus : id obligatoire
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de l’expédition à supprimer',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec vérification du statut livré
     */
    public function resolve($root, $args)
    {
        $shipment = OrderShipment::findOrFail($args['id']);
        if ($shipment->status === 'livré' || $shipment->delivered_at !== null) {
            throw new \GraphQL\Error\Error('Impossible de supprimer une expédition déjà livrée.');
        }
        $shipment->delete();
        return true;
    }
}
