<?php

namespace App\GraphQL\Mutations;

use App\Models\Payment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\DB;

/**
 * Mutation GraphQL pour supprimer un paiement
 * Suppression autorisée uniquement si le paiement est en attente ou échoué
 */
class DeletePaymentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deletePayment',
        'description' => 'Supprimer un paiement (si non payé ou échoué)',
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
                'description' => 'ID du paiement à supprimer',
            ],
        ];
    }

    /**
     * Résolution de la mutation
     */
    public function resolve($root, $args)
    {
        $payment = Payment::findOrFail($args['id']);
        if (!in_array($payment->status, ['pending', 'failed'])) {
            throw new \GraphQL\Error\Error('Impossible de supprimer un paiement déjà payé ou remboursé.');
        }
        return DB::transaction(function () use ($payment) {
            $payment->delete();
            // Journalisation de la suppression paiement dans Activity
            \App\Models\Activity::create([
                'user_id' => auth()->id() ?? null,
                'type' => 'paiement',
                'message' => 'Paiement supprimé',
                'data' => [
                    'payment_id' => $payment->id,
                    'status' => $payment->status,
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'deleted_at' => now()->toDateTimeString(),
                ],
            ]);
            return true;
        });
    }
}
