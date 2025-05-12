<?php
// app/GraphQL/Types/ActivityType.php
// Type GraphQL pour l’entité Activity (journal d’activité Zénith)
// Clean code, ultra commenté, relations respectées

namespace App\GraphQL\Types;

use App\Models\Activity;
use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ActivityType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Activity',
        'description' => 'Une activité du journal Zénith',
        'model' => Activity::class,
    ];

    /**
     * Définition des champs exposés dans l’API GraphQL
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifiant unique de l’activité',
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'ID de l’utilisateur lié à l’activité',
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'Utilisateur lié à l’activité',
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'Type d’activité (commande, client, produit, etc.)',
            ],
            'message' => [
                'type' => Type::string(),
                'description' => 'Message lisible de l’activité',
            ],
            'data' => [
                'type' => Type::string(),
                'description' => 'Données additionnelles (JSON)',
                'resolve' => function($root) {
                    return $root->data ? json_encode($root->data) : null;
                }
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
