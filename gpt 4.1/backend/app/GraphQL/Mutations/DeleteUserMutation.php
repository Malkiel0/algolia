<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL;

/**
 * Mutation GraphQL pour supprimer un utilisateur
 * Gère la suppression sécurisée d'un utilisateur par son ID
 */
class DeleteUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteUser',
        'description' => 'Supprimer un utilisateur',
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
                'description' => "ID de l'utilisateur à supprimer",
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::findOrFail($args['id']);
        $deleted = $user->delete();
        // Journalisation de la suppression utilisateur dans Activity
        \App\Models\Activity::create([
            'user_id' => $user->id,
            'type' => 'utilisateur',
            'message' => 'Utilisateur supprimé',
            'data' => [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'deleted_at' => now()->toDateTimeString(),
            ],
        ]);
        return $deleted;
    }
}
