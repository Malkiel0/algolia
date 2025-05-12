<?php

namespace App\GraphQL\Mutations;

use App\Models\ShippingMethod;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\DB;

/**
 * Mutation GraphQL pour supprimer une méthode de livraison
 * Suppression impossible si la méthode est utilisée dans une expédition
 */
class DeleteShippingMethodMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteShippingMethod',
        'description' => 'Supprimer une méthode de livraison (si non utilisée)',
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
                'description' => 'ID de la méthode à supprimer',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec vérification d’utilisation
     */
    public function resolve($root, $args)
    {
        $method = ShippingMethod::findOrFail($args['id']);
        // Vérifie si la méthode est utilisée dans une expédition
        $isUsed = DB::table('order_shipments')->where('shipping_method_id', $method->id)->exists();
        if ($isUsed) {
            throw new \GraphQL\Error\Error('Impossible de supprimer une méthode utilisée dans une expédition.');
        }
        $method->delete();
        // Journalisation de la suppression méthode de livraison dans Activity
        \App\Models\Activity::create([
            'user_id' => auth()->id() ?? null,
            'type' => 'methode_livraison',
            'message' => 'Méthode de livraison supprimée',
            'data' => [
                'shipping_method_id' => $method->id,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'deleted_at' => now()->toDateTimeString(),
            ],
        ]);
        return true;
    }
}
