<?php

namespace App\GraphQL\Mutations;

use App\Models\OrderShipment;
use App\Models\Order;
use App\Models\ShippingMethod;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * Mutation GraphQL pour créer une expédition de commande
 * Valide la commande, la méthode de livraison, le statut et les champs
 */
class CreateOrderShipmentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createOrderShipment',
        'description' => 'Créer une nouvelle expédition pour une commande',
    ];

    /**
     * Type de retour : OrderShipmentType
     */
    public function type(): Type
    {
        return \Rebing\GraphQL\Support\Facades\GraphQL::type('OrderShipment');
    }

    /**
     * Arguments attendus
     */
    public function args(): array
    {
        return [
            'order_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de la commande concernée',
            ],
            'shipping_method_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de la méthode de livraison',
            ],
            'tracking_number' => [
                'type' => Type::string(),
                'description' => 'Numéro de suivi',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Statut de l’expédition (en_attente, en_cours, livré...)',
                'defaultValue' => 'en_attente',
            ],
            'shipped_at' => [
                'type' => Type::string(),
                'description' => 'Date d’envoi (YYYY-MM-DD HH:MM:SS)',
            ],
            'delivered_at' => [
                'type' => Type::string(),
                'description' => 'Date de livraison (YYYY-MM-DD HH:MM:SS)',
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
            'order_id' => 'required|integer|exists:orders,id',
            'shipping_method_id' => 'required|integer|exists:shipping_methods,id',
            'tracking_number' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'shipped_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            throw new \GraphQL\Error\Error('Erreur de validation', null, null, null, null, null, [
                'validation' => $validator->errors()->toArray()
            ]);
        }
        // Vérification métier : une commande ne peut avoir qu'une seule expédition
        if (OrderShipment::where('order_id', $args['order_id'])->exists()) {
            throw new \GraphQL\Error\Error('Cette commande possède déjà une expédition.');
        }
        // Création de l’expédition
        $shipment = OrderShipment::create($args);
        return $shipment;
    }
}
