<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\Hash;

/**
 * Mutation GraphQL pour créer un utilisateur
 * Gère la validation, la création et le retour du nouvel utilisateur
 */
class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createUser',
        'description' => 'Créer un nouvel utilisateur',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nom complet',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Adresse email',
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Mot de passe',
            ],
            'phone' => [
                'type' => Type::string(),
                'description' => 'Numéro de téléphone',
            ],
            'role' => [
                'type' => Type::string(),
                'description' => 'Rôle utilisateur',
                'defaultValue' => 'client',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Statut du compte',
                'defaultValue' => 'active',
            ],
        ];
    }

    /**
     * Résolution de la mutation avec validation avancée
     */
    public function resolve($root, $args)
    {
        // Validation Laravel avancée
        // On utilise la façade Validator de Laravel pour valider les données d'entrée
        $validator = \Illuminate\Support\Facades\Validator::make($args, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
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

        // Création de l'utilisateur
        $user = User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => Hash::make($args['password']),
            'phone' => $args['phone'] ?? null,
            'role' => $args['role'] ?? 'client',
            'status' => $args['status'] ?? 'active',
        ]);
        // Journalisation de la création d'utilisateur dans Activity
        \App\Models\Activity::create([
            'user_id' => $user->id,
            'type' => 'utilisateur',
            'message' => 'Nouvel utilisateur créé',
            'data' => [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now()->toDateTimeString(),
            ],
        ]);
        return $user;
    }
}
