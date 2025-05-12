<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL;

/**
 * Mutation GraphQL pour supprimer un produit
 * Gère la suppression sécurisée d'un produit par son ID
 */
class DeleteProductMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteProduct',
        'description' => 'Supprimer un produit',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => "ID du produit à supprimer",
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $product = Product::findOrFail($args['id']);
        $deleted = $product->delete();
        // Journalisation de la suppression produit dans Activity
        \App\Models\Activity::create([
            'user_id' => auth()->id() ?? null,
            'type' => 'produit',
            'message' => 'Produit supprimé',
            'data' => [
                'product_id' => $product->id,
                'name' => $product->name,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'deleted_at' => now()->toDateTimeString(),
            ],
        ]);
        return $deleted;
    }
}
