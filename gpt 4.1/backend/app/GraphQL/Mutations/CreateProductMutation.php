<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Mutation GraphQL pour créer un produit
 * Gère la validation, la création et le retour du nouveau produit
 */
class CreateProductMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createProduct',
        'description' => 'Créer un nouveau produit',
    ];

    public function type(): Type
    {
        return GraphQL::type('Product');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
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
                'type' => Type::nonNull(Type::float()),
                'description' => 'Prix de base',
            ],
            'discount_price' => [
                'type' => Type::float(),
                'description' => 'Prix remisé',
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'Type de produit',
                'defaultValue' => 'simple',
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
                'defaultValue' => true,
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation avancée
     */
    public function resolve($root, $args)
    {
        // On utilise la façade Validator de Laravel pour valider les données d'entrée
        $validator = \Illuminate\Support\Facades\Validator::make($args, [
            'name' => 'required|string|max:255|unique:products,name',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'type' => 'nullable|in:simple,variable,bundle',
            'stock_quantity' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'is_active' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            // Retourne des erreurs structurées pour GraphQL
            throw new \GraphQL\Error\Error('Validation error', null, null, null, null, null, [
                'validation' => $validator->errors()->toArray()
            ]);
        }
        // Création du produit
        $product = Product::create([
            'name' => $args['name'],
            'slug' => $args['slug'] ?? null,
            'description' => $args['description'] ?? null,
            'price' => $args['price'],
            'discount_price' => $args['discount_price'] ?? null,
            'type' => $args['type'] ?? 'simple',
            'stock_quantity' => $args['stock_quantity'] ?? 0,
            'sku' => $args['sku'] ?? null,
            'is_active' => $args['is_active'] ?? true,
        ]);
        // Journalisation de la création de produit dans Activity
        \App\Models\Activity::create([
            'user_id' => auth()->id() ?? null,
            'type' => 'produit',
            'message' => 'Nouveau produit créé',
            'data' => [
                'product_id' => $product->id,
                'name' => $product->name,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now()->toDateTimeString(),
            ],
        ]);
        return $product;
    }
}
