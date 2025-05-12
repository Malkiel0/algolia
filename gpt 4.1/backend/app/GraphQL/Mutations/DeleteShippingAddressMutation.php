<?php

namespace App\GraphQL\Mutations;

use App\Models\ShippingAddress;
use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\DB;

/**
 * Mutation GraphQL pour supprimer une adresse de livraison
 * Suppression impossible si l’adresse est liée à une commande
 */
class DeleteShippingAddressMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteShippingAddress',
        'description' => 'Supprimer une adresse de livraison (si non liée à une commande)',
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
                'description' => 'ID de l’adresse à supprimer',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec vérification de liaison à une commande
     */
    public function resolve($root, $args)
    {
        $address = ShippingAddress::findOrFail($args['id']);
        // Vérifie si l’adresse est liée à une commande
        $isUsed = DB::table('orders')->where('shipping_address_id', $address->id)->exists();
        if ($isUsed) {
            throw new \GraphQL\Error\Error('Impossible de supprimer une adresse utilisée dans une commande.');
        }
        $address->delete();
        // Journalisation de la suppression adresse de livraison dans Activity
        \App\Models\Activity::create([
            'user_id' => auth()->id() ?? null,
            'type' => 'adresse_livraison',
            'message' => 'Adresse de livraison supprimée',
            'data' => [
                'shipping_address_id' => $address->id,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'deleted_at' => now()->toDateTimeString(),
            ],
        ]);
        return true;
    }
}
