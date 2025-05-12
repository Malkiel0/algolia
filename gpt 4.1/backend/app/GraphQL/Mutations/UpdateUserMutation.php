<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\Hash;

/**
 * Mutation GraphQL pour mettre à jour un utilisateur existant
 * Gère la validation, la mise à jour et le retour de l'utilisateur modifié
 */
class UpdateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateUser',
        'description' => 'Mettre à jour un utilisateur',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => "ID de l'utilisateur à modifier",
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Nom complet',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'Adresse email',
            ],
            'password' => [
                'type' => Type::string(),
                'description' => 'Mot de passe',
            ],
            'phone' => [
                'type' => Type::string(),
                'description' => 'Numéro de téléphone',
            ],
            'role' => [
                'type' => Type::string(),
                'description' => 'Rôle utilisateur',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Statut du compte',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation avancée
     */
    public function resolve($root, $args)
    {
        $user = User::findOrFail($args['id']);
        // On utilise la façade Validator de Laravel pour valider les données d'entrée
        $validator = \Illuminate\Support\Facades\Validator::make($args, [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:6',
            'phone' => 'nullable|string|max:30',
            'role' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            // Retourne des erreurs structurées pour GraphQL
            throw new \GraphQL\Error\Error('Validation error', null, null, null, null, null, [
                'validation' => $validator->errors()->toArray()
            ]);
        }
        if (isset($args['name'])) $user->name = $args['name'];
        if (isset($args['email'])) $user->email = $args['email'];
        if (isset($args['password'])) $user->password = Hash::make($args['password']);
        if (isset($args['phone'])) $user->phone = $args['phone'];
        if (isset($args['role'])) $user->role = $args['role'];
        if (isset($args['status'])) $user->status = $args['status'];
        $user->save();
        // Journalisation de la modification utilisateur dans Activity
        \App\Models\Activity::create([
            'user_id' => $user->id,
            'type' => 'utilisateur',
            'message' => 'Utilisateur modifié',
            'data' => [
                'user_id' => $user->id,
                'fields_updated' => array_keys($args),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'updated_at' => now()->toDateTimeString(),
            ],
        ]);
        return $user;
    }
}
