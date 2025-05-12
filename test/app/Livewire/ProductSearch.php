<?php
/**
 * Composant de recherche de produits avec Algolia et Laravel Scout
 *
 * Ce composant gère toute la logique de recherche, filtrage et tri des produits
 * en utilisant Algolia comme moteur de recherche. Il utilise Livewire pour
 * offrir une expérience réactive sans rechargement de page.
 * 
 * @author Votre Nom
 * @version 1.0
 */

namespace App\Livewire;

// Import du modèle Product qui est indexé dans Algolia
use App\Models\Product;
// Classe de base pour les composants Livewire
use Livewire\Component;
// Trait pour gérer la pagination dans Livewire
use Livewire\WithPagination;
// Classe Collection pour manipuler les tableaux de données
use Illuminate\Support\Collection;

/**
 * Composant Livewire ProductSearch
 * 
 * Ce composant gère la recherche de produits avec Algolia et Livewire.
 * Il permet une recherche en temps réel, des filtres avancés et
 * un affichage personnalisable des résultats.
 */
class ProductSearch extends Component
{
    // Utilisation du trait de pagination pour gérer la pagination des résultats
    use WithPagination;
    
    /**
     * Propriétés publiques pour la recherche et le filtrage
     * Toutes ces propriétés sont accessibles depuis la vue Blade et peuvent être
     * modifiées par l'utilisateur via l'interface
     */
    public string $query = '';            // Texte de recherche saisi par l'utilisateur
    public array $results = [];           // Résultats de recherche (produits trouvés)
    public $priceMin = '';               // Filtre de prix minimum
    public $priceMax = '';               // Filtre de prix maximum
    public $sortBy = 'name';             // Champ utilisé pour le tri (nom, prix, etc.)
    public $sortDirection = 'asc';       // Direction du tri (ascendant ou descendant)
    public $perPage = 12;                // Nombre de résultats par page
    public $categories = [];             // Liste des catégories disponibles
    public $selectedCategories = [];     // Catégories sélectionnées pour le filtrage
    public $viewMode = 'grid';           // Mode d'affichage: 'grid' (grille) ou 'list' (liste)
    public $isLoading = false;           // Indicateur de chargement pour l'interface
    
    /**
     * Écouteurs d'événements Livewire
     * 
     * Ces écouteurs permettent la communication entre composants Livewire
     * ou de réagir à des événements déclenchés par JavaScript
     */
    protected $listeners = [
        'refreshProducts' => '$refresh',          // Rafraîchit le composant entièrement
        'productSelected' => 'showProductDetails', // Affiche les détails d'un produit sélectionné
        'filterChanged' => 'applyFilters'        // Réagit aux changements de filtres
    ];
    
    /**
     * Initialisation des catégories au montage du composant
     * 
     * Cette méthode est exécutée une seule fois lorsque le composant est monté
     * sur la page. Elle prépare les données initiales nécessaires au composant.
     * 
     * Dans une implémentation complète, on récupérerait les catégories depuis la base
     * de données ou depuis Algolia directement (facettes).
     */
    public function mount()
    {
        // Liste statique des catégories pour la démonstration
        // Dans un environnement de production, on les récupérerait depuis la base de données
        // Exemple: $this->categories = Product::distinct('category')->pluck('category')->toArray();
        $this->categories = [
            'Électronique', 'Vêtements', 'Maison', 'Alimentation', 
            'Sports', 'Beauté', 'Jouets', 'Livres'
        ];
    }
    
    /**
     * Méthode pour afficher les détails d'un produit
     * 
     * Cette méthode redirige l'utilisateur vers la page détaillée d'un produit
     * spécifique lorsqu'il clique sur un produit dans les résultats.
     * 
     * @param int $productId ID du produit sélectionné
     * @return \Illuminate\Http\RedirectResponse Redirection vers la page de détails
     */
    public function showProductDetails($productId)
    {
        // Redirection vers la route 'products.show' avec l'ID du produit
        return redirect()->route('products.show', $productId);
    }
    
    /**
     * Méthode exécutée automatiquement lorsque la propriété $query est mise à jour
     * 
     * Cette méthode est un hook Livewire qui se déclenche automatiquement à chaque
     * modification du champ de recherche par l'utilisateur. Elle gère le cycle de recherche
     * complet: indicateurs de chargement, réinitialisation de pagination et exécution de la recherche.
     * 
     * La recherche est déclenchée en temps réel pendant que l'utilisateur tape (debounce appliqué dans
     * la vue pour éviter trop de requêtes).
     */
    public function updatedQuery()
    {
        // Active l'indicateur de chargement pour l'interface
        $this->isLoading = true;
        
        // Réinitialise la pagination à la première page après chaque nouvelle recherche
        $this->resetPage();
        
        // Appelle la méthode qui exécute la recherche avec Algolia ou la base de données
        $this->executeSearch();
        
        // Désactive l'indicateur de chargement une fois la recherche terminée
        $this->isLoading = false;
    }
    
    /**
     * Méthode générique pour exécuter une recherche avec filtres
     * 
     * Cette méthode est le cœur du système de recherche. Elle utilise soit Algolia
     * (pour la recherche textuelle) soit Eloquent (pour le filtrage simple) selon
     * le contexte de la requête. Elle applique tous les filtres choisis par l'utilisateur.
     * 
     * Approche hybride:
     * - Utilisation d'Algolia pour la recherche textuelle (à partir de 2 caractères)
     * - Utilisation d'Eloquent pour le filtrage simple sans texte de recherche
     *
     * @return void Les résultats sont stockés dans la propriété $results du composant
     */
    private function executeSearch()
    {
        // PARTIE 1: RECHERCHE AVEC ALGOLIA
        // Si l'utilisateur a saisi au moins 2 caractères, on utilise Algolia pour la recherche textuelle
        if (strlen($this->query) > 1) {
            // La méthode static search() est fournie par le trait Searchable dans le modèle
            // Elle permet d'effectuer une recherche textuelle dans l'index Algolia
            $this->results = Product::search($this->query)
                // Méthode query() permet de raffiner la recherche avec des filtres 
                ->query(function ($query) {
                    // Application des filtres de prix (numériques)
                    if (!empty($this->priceMin)) {
                        $query->where('price', '>=', $this->priceMin); // Filtre prix minimum
                    }
                    
                    if (!empty($this->priceMax)) {
                        $query->where('price', '<=', $this->priceMax); // Filtre prix maximum
                    }
                    
                    // Filtrage par catégories (valeurs multiples possibles)
                    if (!empty($this->selectedCategories)) {
                        $query->whereIn('category', $this->selectedCategories); // Filtre par catégorie(s)
                    }
                    
                    // Application du tri des résultats sur un champ spécifique
                    $query->orderBy($this->sortBy, $this->sortDirection); // Tri personnalisé
                })
                ->take(50) // Limite le nombre de résultats à 50 (performance)
                ->get()   // Exécute la recherche et récupère les résultats
                ->toArray(); // Convertit les modèles en tableau pour l'affichage
        }
        // PARTIE 2: FILTRAGE SIMPLE SANS RECHERCHE TEXTUELLE
        else {
            // Si pas de recherche textuelle mais des filtres sont appliqués
            // On utilise Eloquent (ORM de Laravel) plutôt qu'Algolia pour de simples filtres
            if (!empty($this->priceMin) || !empty($this->priceMax) || !empty($this->selectedCategories)) {
                // Initialise une requête Eloquent sur le modèle Product
                $query = Product::query();
                
                // Construction de la requête avec les mêmes filtres que pour Algolia
                // Application des filtres de prix
                if (!empty($this->priceMin)) {
                    $query->where('price', '>=', $this->priceMin);
                }
                
                if (!empty($this->priceMax)) {
                    $query->where('price', '<=', $this->priceMax);
                }
                
                // Filtrage par catégories si sélectionnées
                if (!empty($this->selectedCategories)) {
                    $query->whereIn('category', $this->selectedCategories);
                }
                
                // Application du tri
                $query->orderBy($this->sortBy, $this->sortDirection);
                
                // Exécution de la requête et récupération des résultats
                $this->results = $query->take(50)->get()->toArray();
            } else {
                // Si aucun filtre n'est appliqué et pas de recherche, on ne montre rien
                // Les produits populaires seront affichés à la place (voir la méthode render)
                $this->results = [];
            }
        }
    }
    
    /**
     * Méthode pour appliquer les filtres lorsque l'utilisateur clique sur le bouton "Appliquer"
     * 
     * Cette méthode est déclenchée manuellement lorsque l'utilisateur applique des filtres.
     * Elle suit le même processus que updatedQuery() mais peut être appelée par
     * d'autres événements comme un clic sur un bouton de filtre ou un événement personnalisé.
     */
    public function applyFilters()
    {
        // Affiche l'indicateur de chargement
        $this->isLoading = true;
        
        // Réinitialise la pagination à la première page
        $this->resetPage();
        
        // Exécute la recherche avec les nouveaux filtres
        $this->executeSearch();
        
        // Masque l'indicateur de chargement
        $this->isLoading = false;
    }
    
    /**
     * Méthode pour changer le critère de tri des résultats
     * 
     * Cette méthode est appelée lorsque l'utilisateur clique sur un en-tête de colonne
     * pour trier les résultats. Elle gère la logique de basculement entre le tri
     * ascendant et descendant si on clique plusieurs fois sur la même colonne.
     *
     * @param string $column Nom de la colonne par laquelle trier (name, price, etc.)
     */
    public function sort($column)
    {
        // Si on clique sur la même colonne, on inverse la direction du tri
        if ($this->sortBy === $column) {
            // Basculement entre tri ascendant et descendant
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // Nouvelle colonne de tri, on commence par un tri ascendant
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        
        // On relance la recherche avec le nouveau tri
        $this->updatedQuery();
    }
    
    /**
     * Hook Livewire déclenché lors de la sélection/désélection de catégories
     * 
     * Cette méthode est appelée automatiquement par Livewire chaque fois que 
     * l'utilisateur sélectionne ou désélectionne une catégorie dans l'interface.
     * Elle déclenche immédiatement une recherche avec les nouveaux filtres.
     */
    public function updatedSelectedCategories()
    {
        // Application des filtres à jour
        $this->applyFilters();
    }
    
    /**
     * Sélectionne une catégorie spécifique pour le filtrage
     * 
     * Cette méthode est appelée lorsque l'utilisateur clique sur un bouton de catégorie
     * dans l'en-tête. Elle remplace toute sélection précédente par la nouvelle catégorie
     * et applique immédiatement le filtre.
     * 
     * @param string $category Nom de la catégorie à sélectionner
     */
    public function selectCategory($category)
    {
        // Réinitialise les catégories sélectionnées et ajoute uniquement la nouvelle
        $this->selectedCategories = [$category];
        
        // Applique le filtre immédiatement
        $this->applyFilters();
    }
    
    /**
     * Efface le filtre de catégorie actif
     * 
     * Cette méthode est appelée lorsque l'utilisateur clique sur "Tous les produits".
     * Elle supprime tout filtrage par catégorie et affiche tous les produits.
     */
    public function clearCategoryFilter()
    {
        // Réinitialise les catégories sélectionnées
        $this->selectedCategories = [];
        
        // Applique les filtres (sans filtre de catégorie)
        $this->applyFilters();
    }
    
    /**
     * Hook Livewire déclenché lors du changement de prix minimum
     * 
     * Cette méthode est appelée automatiquement par Livewire chaque fois que 
     * l'utilisateur modifie la valeur du prix minimum.
     * Une recherche avec les nouveaux filtres est immédiatement déclenchée.
     */
    public function updatedPriceMin()
    {
        // Application des filtres avec le nouveau prix minimum
        $this->applyFilters();
    }
    
    /**
     * Hook Livewire déclenché lors du changement de prix maximum
     * 
     * Cette méthode est appelée automatiquement par Livewire chaque fois que 
     * l'utilisateur modifie la valeur du prix maximum.
     * Une recherche avec les nouveaux filtres est immédiatement déclenchée.
     */
    public function updatedPriceMax()
    {
        // Application des filtres avec le nouveau prix maximum
        $this->applyFilters();
    }
    
    /**
     * Bascule entre les modes d'affichage grille et liste
     * 
     * Cette méthode permet à l'utilisateur de basculer entre deux modes
     * d'affichage des résultats: en grille (cards) ou en liste détaillée.
     */
    public function toggleViewMode()
    {
        // Basculement entre les modes 'grid' (grille) et 'list' (liste)
        $this->viewMode = $this->viewMode === 'grid' ? 'list' : 'grid';
    }
    
    /**
     * Réinitialise tous les filtres à leurs valeurs par défaut
     * 
     * Cette méthode est appelée lorsque l'utilisateur clique sur "Réinitialiser"
     * ou "Effacer les filtres". Elle remet tous les filtres à zéro et relance
     * la recherche pour montrer les résultats non filtrés.
     */
    public function clearFilters()
    {
        // Réinitialisation des filtres de prix
        $this->priceMin = '';
        $this->priceMax = '';
        
        // Réinitialisation des catégories sélectionnées
        $this->selectedCategories = [];
        
        // Retour à la première page
        $this->resetPage();
        
        // Relance la recherche sans filtres
        $this->updatedQuery();
    }
    
    /**
     * Charge plus de résultats (pagination infinie)
     * 
     * Cette méthode est utilisée pour implémenter un chargement progressif des résultats
     * lorsque l'utilisateur fait défiler la page (infinite scroll) ou clique sur
     * "Charger plus". Elle augmente le nombre de résultats affichés par page.
     */
    public function loadMore()
    {
        // Ajoute 12 résultats supplémentaires par chargement
        $this->perPage += 12;
        
        // Relance la recherche avec plus de résultats à afficher
        $this->updatedQuery();
    }
    
    /**
     * Méthode principale de rendu du composant Livewire
     * 
     * Cette méthode gère l'affichage du composant. Elle est appelée automatiquement
     * par Livewire à chaque mise à jour (recherche, filtrage, tri).
     * Elle prépare les données finales à envoyer à la vue Blade.
     *
     * À l'état initial, nous affichons tous les produits (jusqu'à 500) pour
     * donner une vue complète du catalogue dès le chargement de la page.
     *
     * @return \Illuminate\View\View Vue Blade avec les données nécessaires
     */
    /**
     * Vérifie si un élément est présent dans un tableau
     * 
     * Cette méthode utilitaire est utilisée dans la vue Blade pour vérifier
     * si un élément (couleur, catégorie, etc.) est actuellement sélectionné.
     * Elle facilite la gestion des classes CSS conditionnelles.
     * 
     * @param array $array Tableau dans lequel chercher l'élément
     * @param mixed $value Valeur à rechercher dans le tableau
     * @return bool True si l'élément est présent, False sinon
     */
    public function isSelected(array $array, $value): bool
    {
        return in_array($value, $array, true);
    }

    public function render()
    {
        // Détection de l'état initial: pas de recherche et aucun filtre actif
        $isInitialState = empty($this->query) && 
                        empty($this->priceMin) && 
                        empty($this->priceMax) && 
                        empty($this->selectedCategories);
                        
        if ($isInitialState) {
            // Si nous sommes à l'état initial (sans recherche ni filtres),
            // nous chargeons directement tous les produits dans les résultats
            // plutôt que d'utiliser une propriété séparée pour les "produits populaires"
            $this->results = Product::orderBy($this->sortBy, $this->sortDirection)
                ->take(500) // Limite à 500 produits pour des raisons de performance
                ->get()
                ->toArray();
                
            // Aucun besoin de produits populaires séparés
            $popularProducts = collect([]);
        } else {
            // Si des filtres ou une recherche sont actifs, nous utilisons 
            // les résultats déjà calculés par executeSearch()
            // $this->results contient déjà les produits filtrés/recherchés
            
            // Collection vide car nous n'utilisons plus les produits populaires
            $popularProducts = collect([]);
        }
            
        // Rendu de la vue avec les données
        return view('livewire.product-search', [
            'results' => $this->results,              // Résultats de recherche ou tous les produits
            'popularProducts' => $popularProducts,    // Conservé pour compatibilité, mais vide
        ]);
    }
}
