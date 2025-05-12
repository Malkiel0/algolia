# Guide Complet d'Algolia avec Laravel Scout

## 🌟 Introduction

Ce guide explique en détail comment fonctionne la recherche en temps réel dans notre application Laravel 12 avec Algolia et Laravel Scout. Conçu pour être compréhensible par tous, il couvre l'ensemble du processus d'intégration et d'utilisation.

## 📋 Table des Matières

1. [Qu'est-ce qu'Algolia et Laravel Scout?](#quest-ce-qualgolia-et-laravel-scout)
2. [Configuration de base](#configuration-de-base)
3. [Comment indexer vos données](#comment-indexer-vos-données)
4. [Comment effectuer des recherches](#comment-effectuer-des-recherches)
5. [Filtrage et tri avancés](#filtrage-et-tri-avancés)
6. [Intégration avec Livewire](#intégration-avec-livewire)
7. [Résolution de problèmes courants](#résolution-de-problèmes-courants)
8. [Ressources additionnelles](#ressources-additionnelles)

## 🤔 Qu'est-ce qu'Algolia et Laravel Scout?

### Algolia simplement expliqué
Algolia est comme un "super moteur de recherche" que vous pouvez ajouter à votre site web. Imaginez Google, mais uniquement pour votre site, et beaucoup plus rapide et personnalisable.

**En langage simple**: Algolia permet à vos utilisateurs de trouver exactement ce qu'ils cherchent sur votre site en tapant quelques lettres, comme la recherche sur Google ou Amazon.

### Laravel Scout, le traducteur
Laravel Scout est un "traducteur" entre votre application Laravel et Algolia. Il permet à Laravel de communiquer facilement avec Algolia sans que vous ayez à apprendre un nouveau langage.

**En langage simple**: Scout dit à Algolia quoi rechercher dans votre base de données et récupère les résultats pour vous.

### Pourquoi utiliser Algolia plutôt que la recherche SQL classique?

1. **Rapidité incroyable** - Résultats en quelques millisecondes, même avec des millions d'enregistrements
2. **Recherche intelligente** - Comprend les fautes de frappe, les synonymes et le contexte
3. **Filtres puissants** - Filtrage par n'importe quel critère (prix, catégorie, etc.)
4. **Pertinence personnalisable** - Vous décidez ce qui est important dans votre recherche
5. **Analyse détaillée** - Savoir ce que recherchent vos utilisateurs

## ⚙️ Configuration de base

### 1. Installation des packages

```bash
composer require algolia/algoliasearch-client-php laravel/scout
```

### 2. Publication de la configuration Scout

```bash
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
```

### 3. Configuration des clés Algolia

Créez un compte sur [Algolia.com](https://www.algolia.com/) et récupérez vos clés API.

Dans votre fichier `.env`, ajoutez:

```
ALGOLIA_APP_ID=votre_app_id
ALGOLIA_SECRET=votre_clé_admin
ALGOLIA_SEARCH=votre_clé_de_recherche
SCOUT_DRIVER=algolia
```

### 4. Configuration du modèle à indexer

Voici comment nous avons configuré le modèle Product:

```php
<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Searchable; // Ajoute les capacités de recherche Algolia

    /**
     * Définit le nom de l'index Algolia pour ce modèle
     */
    public function searchableAs()
    {
        return 'products_index';
    }

    /**
     * Champs à indexer dans Algolia
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,               // Identifiant unique
            'name' => $this->name,           // Nom du produit
            'price' => $this->price,         // Prix pour filtrage
            'category' => $this->category,   // Catégorie pour filtrage
            'description' => $this->description,  // Description pour recherche
            // Ajoutez d'autres champs selon vos besoins
        ];
    }
}
```

## 📤 Comment indexer vos données

### Indexation initiale

Pour envoyer toutes vos données existantes vers Algolia:

```bash
php artisan scout:import "App\Models\Product"
```

### Indexation automatique

Une fois la configuration en place, **vos données sont automatiquement synchronisées** avec Algolia à chaque:
- Création d'un nouveau produit (`Product::create()`)
- Mise à jour d'un produit (`$product->update()`)
- Suppression d'un produit (`$product->delete()`)

### Indexation manuelle

Si vous avez besoin de forcer la synchronisation:

```php
// Pour un seul modèle
$product->searchable();

// Pour une collection
$products->searchable();
```

### Désactiver l'indexation temporairement

```php
Product::withoutSyncingToSearch(function () {
    // Les opérations ici ne seront pas synchronisées avec Algolia
    Product::create([...]);
});
```

## 🔍 Comment effectuer des recherches

### Recherche simple

```php
// Récupère tous les produits correspondant à "téléphone"
$products = Product::search('téléphone')->get();
```

### Recherche avec filtres

```php
$products = Product::search('téléphone')
    ->where('price', '>', 500)
    ->where('category', 'Électronique')
    ->get();
```

### Recherche avec tri

```php
$products = Product::search('téléphone')
    ->orderBy('price', 'asc')
    ->get();
```

### Pagination des résultats

```php
$products = Product::search('téléphone')
    ->paginate(10);
```

## 🧩 Filtrage et tri avancés

### Filtres numériques

```php
// Recherche par plage de prix
$products = Product::search('téléphone')
    ->where('price', '>=', 100)
    ->where('price', '<=', 500)
    ->get();
```

### Filtres multiples avec OR

```php
// Recherche dans plusieurs catégories
$products = Product::search('téléphone')
    ->whereIn('category', ['Électronique', 'Accessoires'])
    ->get();
```

### Personnalisation complète de la requête

```php
$products = Product::search('téléphone')
    ->query(function ($query) {
        // Personnalisation complète de l'API Algolia
        $query->setFilters('category:Électronique AND price < 1000');
        $query->setHitsPerPage(15);
    })
    ->get();
```

## 💻 Intégration avec Livewire

Notre projet utilise Livewire 3 pour une recherche dynamique sans rechargement de page. Voici comment nous l'avons implémenté:

### 1. Composant Livewire ProductSearch

```php
<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductSearch extends Component
{
    public string $query = '';
    public array $results = [];
    public $priceMin = '';
    public $priceMax = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $selectedCategories = [];
    
    // Cette méthode est appelée à chaque modification du champ de recherche
    public function updatedQuery()
    {
        // Vérifie si la requête a au moins 2 caractères
        if (strlen($this->query) > 1) {
            // Recherche avec Algolia via Laravel Scout
            $this->results = Product::search($this->query)
                ->query(function ($query) {
                    // Application des filtres de prix
                    if (!empty($this->priceMin)) {
                        $query->where('price', '>=', $this->priceMin);
                    }
                    
                    if (!empty($this->priceMax)) {
                        $query->where('price', '<=', $this->priceMax);
                    }
                    
                    // Filtrage par catégories
                    if (!empty($this->selectedCategories)) {
                        $query->whereIn('category', $this->selectedCategories);
                    }
                    
                    // Application du tri
                    $query->orderBy($this->sortBy, $this->sortDirection);
                })
                ->get()
                ->toArray();
        } else {
            $this->results = [];
        }
    }
    
    public function render()
    {
        return view('livewire.product-search');
    }
}
```

### 2. Vue Livewire avec recherche en temps réel

```blade
<div>
    <!-- Champ de recherche avec mise à jour en temps réel -->
    <input 
        type="text" 
        wire:model.live.debounce.300ms="query" 
        placeholder="Rechercher un produit..." 
    />
    
    <!-- Filtres -->
    <div>
        <input type="number" wire:model.live="priceMin" placeholder="Prix min" />
        <input type="number" wire:model.live="priceMax" placeholder="Prix max" />
        
        <!-- Catégories -->
        @foreach($categories as $category)
            <label>
                <input type="checkbox" wire:model.live="selectedCategories" value="{{ $category }}" />
                {{ $category }}
            </label>
        @endforeach
    </div>
    
    <!-- Résultats -->
    <div>
        @foreach($results as $product)
            <div>
                <h3>{{ $product['name'] }}</h3>
                <p>{{ $product['price'] }} €</p>
                <p>{{ $product['category'] }}</p>
            </div>
        @endforeach
    </div>
</div>
```

## 🛠 Résolution de problèmes courants

### 1. "Undefined type 'Algolia\AlgoliaSearch\SearchClient'"

**Problème**: Laravel ne trouve pas la classe SearchClient.

**Solution**:
- Vérifier que les packages sont installés: `composer require algolia/algoliasearch-client-php laravel/scout`
- Vérifier les imports: `use Algolia\AlgoliaSearch\SearchClient;`

### 2. Aucun résultat n'est retourné

**Vérifications**:
- Vos modèles sont-ils bien indexés? Exécutez `php artisan scout:import "App\Models\Product"`
- Vérifiez vos clés API dans le fichier `.env`
- Vérifiez la console de votre navigateur pour les erreurs JavaScript
- Utilisez la page de test `/test-algolia` pour diagnostiquer

### 3. Index non trouvé

**Problème**: L'erreur indique que l'index 'products_index' n'existe pas.

**Solution**: Les index sont créés automatiquement lors de la première indexation. Exécutez:
```bash
php artisan scout:import "App\Models\Product"
```

### 4. Recherche trop lente

**Solutions**:
- Ajoutez un "debounce" pour éviter trop de requêtes: `wire:model.live.debounce.300ms="query"`
- Limitez les champs indexés dans `toSearchableArray()` pour réduire la taille de l'index
- Utilisez la mise en cache côté client ou serveur pour les requêtes fréquentes

## 📚 Ressources additionnelles

### Documentation officielle
- [Laravel Scout](https://laravel.com/docs/12.x/scout)
- [API Algolia](https://www.algolia.com/doc/api-client/php/getting-started/)
- [Livewire](https://livewire.laravel.com/docs/v3)

### Tutoriels recommandés
- [Tutoriel officiel d'Algolia](https://www.algolia.com/doc/guides/building-search-ui/getting-started/js/)
- [Laracasts: Laravel Scout](https://laracasts.com/series/whats-new-in-laravel-8/episodes/11)

### Outils utiles
- [Dashboard Algolia](https://www.algolia.com/dashboard) - Pour voir vos index, analyser les requêtes
- [InstantSearch.js](https://www.algolia.com/doc/guides/building-search-ui/what-is-instantsearch/js/) - Bibliothèque pour créer des interfaces de recherche avancées

---

## 🔄 Pour mettre à jour ce guide

Si vous trouvez des inexactitudes ou souhaitez améliorer ce guide, n'hésitez pas à contribuer! Ce document est destiné à être une ressource vivante pour toute l'équipe.

---

Créé avec ❤️ par [Votre Nom/Équipe] | Dernière mise à jour: Mai 2025
