<?php

namespace App\GraphQL\Mutations;

use App\Models\ShippingMethod;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Validator;

/**
 * Mutation GraphQL pour mettre à jour une méthode de livraison
 * Valide l’unicité du nom, le prix positif, et met à jour la méthode
 */
class UpdateShippingMethodMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateShippingMethod',
        'description' => 'Mettre à jour une méthode de livraison existante',
    ];

    /**
     * Type de retour : ShippingMethodType
     */
    public function type(): Type
    {
        return \Rebing\GraphQL\Support\Facades\GraphQL::type('ShippingMethod');
    }

    /**
     * Arguments attendus
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de la méthode à modifier',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Nom de la méthode',
            ],
            'price' => [
                'type' => Type::float(),
                'description' => 'Prix de la livraison',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation avancée
     */
    public function resolve($root, $args)
    {
        $method = ShippingMethod::findOrFail($args['id']);
        // Validation avancée
        $validator = Validator::make($args, [
            'name' => 'sometimes|string|max:100|unique:shipping_methods,name,' . $method->id,
            'price' => 'sometimes|numeric|min:0',
        ]);
        if ($validator->fails()) {
            throw new \GraphQL\Error\Error('Erreur de validation', null, null, null, null, null, [
                'validation' => $validator->errors()->toArray()
            ]);
        }
        $method->update($args);
        // Journalisation de la modification méthode de livraison dans Activity
        \App\Models\Activity::create([
            'user_id' => auth()->id() ?? null,
            'type' => 'methode_livraison',
            'message' => 'Méthode de livraison modifiée',
            'data' => [
                'shipping_method_id' => $method->id,
                'fields_updated' => array_keys($args),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'updated_at' => now()->toDateTimeString(),
            ],
        ]);
        return $method;
    }
}
