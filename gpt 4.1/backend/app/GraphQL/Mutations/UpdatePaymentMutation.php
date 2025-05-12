<?php

namespace App\GraphQL\Mutations;

use App\Models\Payment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Validator;

/**
 * Mutation GraphQL pour mettre à jour un paiement (statut, transaction_id, etc.)
 * Valide la cohérence métier (statut, montant, etc.)
 */
class UpdatePaymentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updatePayment',
        'description' => 'Mettre à jour un paiement existant',
    ];

    /**
     * Type de retour : PaymentType
     */
    public function type(): Type
    {
        return \Rebing\GraphQL\Support\Facades\GraphQL::type('Payment');
    }

    /**
     * Arguments attendus
     * - id obligatoire
     * - status, transaction_id optionnels
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID du paiement à modifier',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Nouveau statut (paid, failed, refunded, pending)',
            ],
            'transaction_id' => [
                'type' => Type::string(),
                'description' => 'ID transactionnel externe',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation métier
     */
    public function resolve($root, $args)
    {
        $payment = Payment::findOrFail($args['id']);
        $allowedStatuses = ['paid', 'failed', 'refunded', 'pending'];
        if (isset($args['status'])) {
            if (!in_array($args['status'], $allowedStatuses)) {
                throw new \GraphQL\Error\Error('Statut de paiement invalide.');
            }
            $payment->status = $args['status'];
        }
        if (isset($args['transaction_id'])) {
            $payment->transaction_id = $args['transaction_id'];
        }
        $payment->save();
        // Journalisation de la modification paiement dans Activity
        \App\Models\Activity::create([
            'user_id' => auth()->id() ?? null,
            'type' => 'paiement',
            'message' => 'Paiement modifié',
            'data' => [
                'payment_id' => $payment->id,
                'fields_updated' => array_keys($args),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'updated_at' => now()->toDateTimeString(),
            ],
        ]);
        return $payment;
    }
}
