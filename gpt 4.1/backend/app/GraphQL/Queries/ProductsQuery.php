<?php

namespace App\GraphQL\Queries;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Query GraphQL pour lister tous les produits
 */
class ProductsQuery extends Query
{
    protected $attributes = [
        'name' => 'products',
        'description' => 'Liste tous les produits',
    ];

    /**
     * Définition du type de retour : une pagination de produits
     */
    public function type(): Type
    {
        // Utilise la pagination standard Laravel/GraphQL
        return GraphQL::paginate('Product');
    }

    /**
     * Définition des arguments acceptés pour la recherche et la pagination
     * Exemple d'utilisation :
     * {
     *   products(limit: 10, page: 2, name: "t-shirt", is_active: true, type: "simple") {
     *     data { id name price }
     *     paginatorInfo { count currentPage lastPage total }
     *   }
     * }
     */
    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'description' => 'Nombre de produits par page (pagination)',
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
            'is_active' => [
                'type' => Type::boolean(),
                'description' => 'Filtrer par statut d’activation',
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'Filtrer par type de produit',
            ],
        ];
    }

    /**
     * Résolution de la query avec gestion des filtres et de la pagination
     */
    public function resolve($root, $args)
    {
        $query = Product::query();

        // Filtre par nom (recherche partielle)
        if (!empty($args['name'])) {
            $query->where('name', 'like', '%' . $args['name'] . '%');
        }
        // Filtre par statut
        if (isset($args['is_active'])) {
            $query->where('is_active', $args['is_active']);
        }
        // Filtre par type
        if (!empty($args['type'])) {
            $query->where('type', $args['type']);
        }

        // Pagination
        $limit = $args['limit'] ?? 10;
        $page = $args['page'] ?? 1;
        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
