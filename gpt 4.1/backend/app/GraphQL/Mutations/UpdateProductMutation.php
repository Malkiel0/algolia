<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Mutation GraphQL pour mettre à jour un produit existant
 * Gère la validation, la mise à jour et le retour du produit modifié
 */
class UpdateProductMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateProduct',
        'description' => 'Mettre à jour un produit',
    ];

    public function type(): Type
    {
        return GraphQL::type('Product');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => "ID du produit à modifier",
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Nom du produit',
            ],
            'slug' => [
                'type' => Type::string(),
                'description' => 'Slug SEO',
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'Description détaillée',
            ],
            'price' => [
                'type' => Type::float(),
                'description' => 'Prix de base',
            ],
            'discount_price' => [
                'type' => Type::float(),
                'description' => 'Prix remisé',
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'Type de produit',
            ],
            'stock_quantity' => [
                'type' => Type::int(),
                'description' => 'Stock disponible',
            ],
            'sku' => [
                'type' => Type::string(),
                'description' => 'Référence interne',
            ],
            'is_active' => [
                'type' => Type::boolean(),
                'description' => 'Statut d’activation',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation avancée
     */
    public function resolve($root, $args)
    {
        $product = Product::findOrFail($args['id']);
        // On utilise la façade Validator de Laravel pour valider les données d'entrée
        $validator = \Illuminate\Support\Facades\Validator::make($args, [
            'name' => 'sometimes|required|string|max:255|unique:products,name,' . $product->id,
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'type' => 'nullable|in:simple,variable,bundle',
            'stock_quantity' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'is_active' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            // Retourne des erreurs structurées pour GraphQL
            throw new \GraphQL\Error\Error('Validation error', null, null, null, null, null, [
                'validation' => $validator->errors()->toArray()
            ]);
        }
        if (isset($args['name'])) $product->name = $args['name'];
        if (isset($args['slug'])) $product->slug = $args['slug'];
        if (isset($args['description'])) $product->description = $args['description'];
        if (isset($args['price'])) $product->price = $args['price'];
        if (isset($args['discount_price'])) $product->discount_price = $args['discount_price'];
        if (isset($args['type'])) $product->type = $args['type'];
        if (isset($args['stock_quantity'])) $product->stock_quantity = $args['stock_quantity'];
        if (isset($args['sku'])) $product->sku = $args['sku'];
        if (isset($args['is_active'])) $product->is_active = $args['is_active'];
        $product->save();
        // Journalisation de la modification de produit dans Activity
        \App\Models\Activity::create([
            'user_id' => auth()->id() ?? null,
            'type' => 'produit',
            'message' => 'Produit modifié',
            'data' => [
                'product_id' => $product->id,
                'fields_updated' => array_keys($args),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'updated_at' => now()->toDateTimeString(),
            ],
        ]);
        return $product;
    }
}
