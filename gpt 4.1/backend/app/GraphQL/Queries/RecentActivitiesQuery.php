<?php
// app/GraphQL/Queries/RecentActivitiesQuery.php
// Query GraphQL pour lister les activités récentes (admin : tout, client : filtré)
// Clean code, ultra commenté, pagination, respect des rôles

namespace App\GraphQL\Queries;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class RecentActivitiesQuery extends Query
{
    protected $attributes = [
        'name' => 'recentActivities',
        'description' => 'Liste paginée des activités récentes (journal d’activité Zénith)'
    ];

    /**
     * Type de retour : pagination d’ActivityType
     */
    public function type(): Type
    {
        return GraphQL::paginate('Activity');
    }

    /**
     * Arguments acceptés pour la pagination
     */
    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'description' => 'Nombre d’activités par page',
                'defaultValue' => 10,
            ],
            'page' => [
                'type' => Type::int(),
                'description' => 'Page à afficher',
                'defaultValue' => 1,
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'Filtrer par type d’activité',
            ],
        ];
    }

    /**
     * Résolution de la query avec gestion des rôles et filtres
     */
    public function resolve($root, $args)
    {
        $user = Auth::user();
        $query = Activity::query();
        // Filtrage par type d’activité si demandé
        if (!empty($args['type'])) {
            $query->where('type', $args['type']);
        }
        // Si client, ne voir que ses propres activités
        if ($user && $user->role === 'client') {
            $query->where('user_id', $user->id);
        }
        // Ordre décroissant (plus récent d’abord)
        $query->orderByDesc('created_at');
        $limit = $args['limit'] ?? 10;
        $page = $args['page'] ?? 1;
        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
