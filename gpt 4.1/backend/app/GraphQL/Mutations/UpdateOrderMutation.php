<?php

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\ShippingAddress;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\Validator;

/**
 * Mutation GraphQL pour mettre à jour une commande (statut, adresse, etc.)
 * Valide la cohérence métier (statut, livraison, etc.)
 */
class UpdateOrderMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateOrder',
        'description' => 'Mettre à jour une commande existante',
    ];

    /**
     * Type de retour : OrderType
     */
    public function type(): Type
    {
        return GraphQL::type('Order');
    }

    /**
     * Arguments attendus
     * - id obligatoire
     * - statut, shipping_address_id optionnels
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de la commande à modifier',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Nouveau statut',
            ],
            'shipping_address_id' => [
                'type' => Type::int(),
                'description' => 'Nouvelle adresse de livraison',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation métier
     */
    public function resolve($root, $args)
    {
        $order = Order::findOrFail($args['id']);

        // Validation avancée du statut
        $allowedStatuses = ['en_cours', 'expediee', 'livree', 'annulee'];
        if (isset($args['status'])) {
            if (!in_array($args['status'], $allowedStatuses)) {
                throw new \GraphQL\Error\Error('Statut de commande invalide.');
            }
            // Interdit de modifier une commande livrée ou annulée
            if (in_array($order->status, ['livree', 'annulee'])) {
                throw new \GraphQL\Error\Error('Impossible de modifier une commande déjà livrée ou annulée.');
            }
            $order->status = $args['status'];
        }

        // Validation et mise à jour de l'adresse de livraison
        if (isset($args['shipping_address_id'])) {
            $address = ShippingAddress::find($args['shipping_address_id']);
            if (!$address) {
                throw new \GraphQL\Error\Error('Adresse de livraison invalide.');
            }
            $order->shipping_address_id = $address->id;
        }

        $order->save();
        // Journalisation de la modification de commande dans Activity
        \App\Models\Activity::create([
            'user_id' => auth()->id() ?? null,
            'type' => 'commande',
            'message' => 'Commande modifiée',
            'data' => [
                'order_id' => $order->id,
                'fields_updated' => array_keys($args),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'updated_at' => now()->toDateTimeString(),
            ],
        ]);
        return $order;
    }
}
