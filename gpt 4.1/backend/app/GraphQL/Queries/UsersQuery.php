<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL; // Pour accéder aux types GraphQL de manière compatible avec rebing/graphql-laravel

/**
 * Query GraphQL pour lister tous les utilisateurs
 */
class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
        'description' => 'Liste tous les utilisateurs',
    ];

    /**
     * Définition du type de retour : une pagination d'utilisateurs
     */
    public function type(): Type
    {
        // Utilise la pagination standard Laravel/GraphQL
        return GraphQL::paginate('User');
    }

    /**
     * Définition des arguments acceptés pour la recherche et la pagination
     * Exemple d'utilisation :
     * {
     *   users(limit: 10, page: 2, name: "alice", email: "alice@test.com", status: "active", role: "client") {
     *     data { id name email }
     *     paginatorInfo { count currentPage lastPage total }
     *   }
     * }
     */
    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'description' => 'Nombre d’utilisateurs par page (pagination)',
                'defaultValue' => 10,
            ],
            'page' => [
                'type' => Type::int(),
                'description' => 'Page à afficher (pagination)',
                'defaultValue' => 1,
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Filtrer par nom (recherche partielle)',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'Filtrer par email',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Filtrer par statut',
            ],
            'role' => [
                'type' => Type::string(),
                'description' => 'Filtrer par rôle',
            ],
        ];
    }

    /**
     * Résolution de la query avec gestion des filtres et de la pagination
     */
    public function resolve($root, $args)
    {
        $query = User::query();

        // Filtre par nom (recherche partielle)
        if (!empty($args['name'])) {
            $query->where('name', 'like', '%' . $args['name'] . '%');
        }
        // Filtre par email
        if (!empty($args['email'])) {
            $query->where('email', $args['email']);
        }
        // Filtre par statut
        if (!empty($args['status'])) {
            $query->where('status', $args['status']);
        }
        // Filtre par rôle
        if (!empty($args['role'])) {
            $query->where('role', $args['role']);
        }

        // Pagination
        $limit = $args['limit'] ?? 10;
        $page = $args['page'] ?? 1;
        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
