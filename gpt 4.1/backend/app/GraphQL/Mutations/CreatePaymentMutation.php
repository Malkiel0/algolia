<?php

namespace App\GraphQL\Mutations;

use App\Models\Payment;
use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * Mutation GraphQL pour enregistrer un paiement sur une commande
 * Valide la commande, le montant, le statut et enregistre la transaction
 */
class CreatePaymentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createPayment',
        'description' => 'Enregistrer un paiement pour une commande',
    ];

    /**
     * Type de retour : PaymentType
     */
    public function type(): Type
    {
        return GraphQL::type('Payment');
    }

    /**
     * Arguments attendus
     * - order_id obligatoire
     * - amount obligatoire
     * - method obligatoire
     * - transaction_id optionnel
     */
    public function args(): array
    {
        return [
            'order_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID de la commande à payer',
            ],
            'amount' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'Montant payé',
            ],
            'method' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Méthode de paiement (carte, mobile_money, etc.)',
            ],
            'transaction_id' => [
                'type' => Type::string(),
                'description' => 'ID transactionnel externe (optionnel)',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation avancée et transaction
     */
    public function resolve($root, $args)
    {
        // Validation de la commande
        $order = Order::find($args['order_id']);
        if (!$order) {
            throw new \GraphQL\Error\Error('Commande introuvable.');
        }
        if (!in_array($order->status, ['en_cours', 'expediee'])) {
            throw new \GraphQL\Error\Error('Paiement possible uniquement pour une commande en cours ou expédiée.');
        }
        // Validation du montant
        if ($args['amount'] <= 0 || $args['amount'] > $order->total_amount) {
            throw new \GraphQL\Error\Error('Montant de paiement invalide.');
        }
        // Validation méthode
        $allowedMethods = ['carte', 'mobile_money', 'paypal', 'espèces'];
        if (!in_array($args['method'], $allowedMethods)) {
            throw new \GraphQL\Error\Error('Méthode de paiement invalide.');
        }
        // Création transactionnelle du paiement
        return DB::transaction(function () use ($order, $args) {
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $args['amount'],
                'method' => $args['method'],
                'status' => 'paid',
                'transaction_id' => $args['transaction_id'] ?? null,
                'paid_at' => now(),
            ]);
            // Mise à jour du statut de la commande si paiement total
            $totalPaid = Payment::where('order_id', $order->id)->sum('amount');
            if ($totalPaid >= $order->total_amount) {
                $order->status = 'payee';
                $order->save();
            }
            return $payment;
        });
    }
}
