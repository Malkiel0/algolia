<?php

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

/**
 * Type GraphQL pour l'entité Utilisateur (User)
 * Permet de typer les réponses et inputs pour l'API GraphQL
 */
class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'Un utilisateur du site (client, admin, etc.)',
        'model' => User::class,
    ];

    /**
     * Définition des champs exposés dans l'API GraphQL
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifiant unique de l’utilisateur',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Nom complet',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'Adresse email',
            ],
            'phone' => [
                'type' => Type::string(),
                'description' => 'Numéro de téléphone',
            ],
            'role' => [
                'type' => Type::string(),
                'description' => 'Rôle (client, admin, vendeur, livreur...)',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Statut du compte',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'Date de création',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'Date de modification',
            ],
        ];
    }
}
