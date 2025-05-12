<?php

namespace App\GraphQL\Mutations;

use App\Models\ShippingMethod;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Validator;

/**
 * Mutation GraphQL pour créer une méthode de livraison
 * Valide l’unicité du nom, le prix positif, et crée la méthode
 */
class CreateShippingMethodMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createShippingMethod',
        'description' => 'Créer une nouvelle méthode de livraison',
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
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nom de la méthode (ex : standard, express)',
            ],
            'price' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'Prix de la livraison',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation avancée
     */
    public function resolve($root, $args)
    {
        // Validation avancée
        $validator = Validator::make($args, [
            'name' => 'required|string|max:100|unique:shipping_methods,name',
            'price' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            throw new \GraphQL\Error\Error('Erreur de validation', null, null, null, null, null, [
                'validation' => $validator->errors()->toArray()
            ]);
        }
        // Création de la méthode
        $method = ShippingMethod::create($args);
        return $method;
    }
}
