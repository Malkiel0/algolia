<?php

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\ShippingAddress;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;

/**
 * Mutation GraphQL pour créer une commande complète
 * Valide le panier, les stocks, l'utilisateur, les produits et crée la commande + items
 */
class CreateOrderMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createOrder',
        'description' => 'Créer une nouvelle commande client',
    ];

    /**
     * Type de retour : OrderType
     */
    public function type(): Type
    {
        return GraphQL::type('Order');
    }

    /**
     * Arguments attendus pour la création d'une commande
     * - user_id obligatoire
     * - items (array de {product_id, quantity}) obligatoire
     * - shipping_address_id optionnel
     */
    public function args(): array
    {
        return [
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID du client',
            ],
            'items' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('CreateOrderItemInput'))),
                'description' => 'Liste des articles (produit + quantité)',
            ],
            'shipping_address_id' => [
                'type' => Type::int(),
                'description' => 'Adresse de livraison (optionnelle)',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation avancée et gestion transactionnelle
     */
    public function resolve($root, $args)
    {
        // Validation de l'utilisateur
        $user = User::find($args['user_id']);
        if (!$user) {
            throw new \GraphQL\Error\Error('Utilisateur introuvable.');
        }
        // Validation des items
        if (empty($args['items']) || !is_array($args['items'])) {
            throw new \GraphQL\Error\Error('Le panier ne peut pas être vide.');
        }
        // Validation de l'adresse de livraison si fournie
        $shippingAddress = null;
        if (!empty($args['shipping_address_id'])) {
            $shippingAddress = ShippingAddress::find($args['shipping_address_id']);
            if (!$shippingAddress) {
                throw new \GraphQL\Error\Error('Adresse de livraison invalide.');
            }
        }
        // Validation et calcul du total
        $total = 0;
        $orderItems = [];
        foreach ($args['items'] as $item) {
            $product = Product::find($item['product_id'] ?? null);
            $quantity = $item['quantity'] ?? 0;
            if (!$product || $quantity < 1) {
                throw new \GraphQL\Error\Error('Produit invalide ou quantité incorrecte.');
            }
            if ($product->stock_quantity < $quantity) {
                throw new \GraphQL\Error\Error('Stock insuffisant pour le produit: ' . $product->name);
            }
            $total += $product->price * $quantity;
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->price,
                'total_price' => $product->price * $quantity,
            ];
        }

        // Création transactionnelle de la commande + items + MAJ stocks
        return DB::transaction(function () use ($user, $orderItems, $total, $shippingAddress) {
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'en_cours',
                'total_amount' => $total,
                'shipping_address_id' => $shippingAddress ? $shippingAddress->id : null,
            ]);
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['total_price'],
                ]);
                // Décrémente le stock produit
                $product = Product::find($item['product_id']);
                $product->stock_quantity -= $item['quantity'];
                $product->save();
            }
            // Enregistrement de l’activité dans le journal (Activity)
            \App\Models\Activity::create([
                'user_id' => $user->id,
                'type' => 'commande',
                'message' => 'Nouvelle commande créée',
                'data' => [
                    'order_id' => $order->id,
                    'total_amount' => $order->total_amount,
                    'items_count' => count($orderItems),
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'created_at' => now()->toDateTimeString(),
                ],
            ]);
            return $order;
        });
    }
}
