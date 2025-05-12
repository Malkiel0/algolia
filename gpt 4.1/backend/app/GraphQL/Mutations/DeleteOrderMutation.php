<?php

namespace App\GraphQL\Mutations;

use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\DB;

/**
 * Mutation GraphQL pour supprimer une commande
 * Suppression autorisée uniquement si la commande n'est pas livrée ni annulée
 * Annule la réservation de stock si besoin
 */
class DeleteOrderMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteOrder',
        'description' => 'Supprimer une commande (si non livrée/annulée)',
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
                'description' => 'ID de la commande à supprimer',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec annulation du stock
     */
    public function resolve($root, $args)
    {
        $order = Order::with('items')->findOrFail($args['id']);
        if (in_array($order->status, ['livree', 'annulee'])) {
            throw new \GraphQL\Error\Error('Impossible de supprimer une commande livrée ou annulée.');
        }
        // Transaction : suppression + remise du stock
        return DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->stock_quantity += $item->quantity;
                    $product->save();
                }
            }
            $order->items()->delete();
            $order->delete();
            // Journalisation de la suppression commande dans Activity
            \App\Models\Activity::create([
                'user_id' => auth()->id() ?? null,
                'type' => 'commande',
                'message' => 'Commande supprimée',
                'data' => [
                    'order_id' => $order->id,
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'deleted_at' => now()->toDateTimeString(),
                ],
            ]);
            return true;
        });
    }
}
