<?php

namespace App\Models;

// Import du trait Searchable de Laravel Scout pour l'indexation dans Algolia
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modèle Product - Représente un produit dans la boutique
 * 
 * Ce modèle gère les produits avec leur catégorisation, prix, et métadonnées.
 * Il est indexé par Algolia pour la recherche rapide grâce au trait Searchable.
 * 
 * Chaque fois qu'un produit est créé, modifié ou supprimé, les données sont
 * automatiquement synchronisées avec Algolia pour maintenir l'index à jour.
 */
class Product extends Model
{
    // HasFactory pour la création de données de test
    // Searchable pour l'indexation et la recherche via Algolia
    use HasFactory, Searchable;

    /**
     * Attributs pouvant être assignés en masse
     * 
     * Ces champs sont sécurisés pour la création et la mise à jour
     * de produits via l'assignation en masse (ex: Product::create($data))
     */
    protected $fillable = [
        'name',          // Nom du produit
        'price',         // Prix du produit
        'category',      // Catégorie principale (Ex: Électronique, Vêtements)
        'subcategory',   // Sous-catégorie (Ex: Téléphones, Chemises)
        'description',   // Description détaillée du produit
        'attributes',    // Attributs au format JSON (caractéristiques techniques)
        'color',         // Couleur du produit
        'material',      // Matériau principal
        'stock',         // Quantité en stock
        'sku',           // Code unique d'identification (Stock Keeping Unit)
    ];
    
    /**
     * Attributs à caster vers des types natifs
     * 
     * Définit comment certains champs doivent être convertis lorsqu'ils sont
     * récupérés de la base de données ou stockés
     */
    protected $casts = [
        'price' => 'float',        // Assure que le prix est toujours traité comme un nombre décimal
        'stock' => 'integer',      // Stock toujours en nombre entier
        'attributes' => 'json',    // Stocke/récupère les attributs comme JSON
        'created_at' => 'datetime', // Dates formatées comme DateTime
        'updated_at' => 'datetime', // Dates formatées comme DateTime
    ];
    
    /**
     * Configuration de l'index Algolia
     * 
     * Cette méthode définit le nom de l'index dans lequel les produits
     * seront stockés sur Algolia. Vous pouvez le visualiser dans votre
     * dashboard Algolia sous ce nom.
     *
     * @return string Nom de l'index Algolia pour ce modèle
     */
    public function searchableAs()
    {
        return 'products_index';
    }
    
    /**
     * Les attributs à indexer pour la recherche Algolia
     * 
     * Cette méthode définit quels champs du modèle seront envoyés à Algolia
     * pour l'indexation et la recherche. Seuls les champs listés ici seront
     * recherchables et filtrables dans Algolia.
     *
     * Vous pouvez personnaliser les données envoyées à Algolia, y compris
     * ajouter des champs calculés ou des relations.
     *
     * @return array Tableau des attributs à indexer
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,               // Identifiant unique
            'name' => $this->name,           // Nom du produit (fortement recherchable)
            'price' => $this->price,         // Prix (pour filtrage et tri)
            'category' => $this->category,    // Catégorie (pour filtrage)
            'subcategory' => $this->subcategory, // Sous-catégorie (pour filtrage)
            'description' => $this->description, // Description (pour recherche textuelle)
            'color' => $this->color,         // Couleur (pour filtrage)
            'material' => $this->material,   // Matériau (pour filtrage)
            'stock' => $this->stock,         // Stock (pour filtrage produits disponibles)
        ];
    }
    
    /**
     * Vérifie si le produit est en stock
     * 
     * Méthode utilitaire pour vérifier rapidement la disponibilité
     * d'un produit sans avoir à comparer manuellement le stock.
     *
     * @return bool True si au moins une unité est disponible
     */
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }
    
    /**
     * Vérifie si le produit est en promotion
     * (Simulé - à implémenter avec une logique réelle plus tard)
     * 
     * Pour l'instant, cette méthode simule une promotion pour 20% des
     * produits (ceux dont l'ID est divisible par 5).
     * Dans une implémentation réelle, on vérifierait un champ
     * 'on_sale' ou une relation avec une table de promotions.
     *
     * @return bool True si le produit est en promotion
     */
    public function isOnSale(): bool
    {
        // Pour l'exemple, 20% des produits sont en promotion
        return $this->id % 5 === 0;
    }
    
    /**
     * Accesseur pour obtenir le prix de promotion
     */
    protected function salePrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->isOnSale()) {
                    return round($this->price * 0.8, 2); // 20% de réduction
                }
                return $this->price;
            },
        );
    }
    
    /**
     * Accesseur pour obtenir le pourcentage de réduction
     */
    protected function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->isOnSale()) {
                    return 20; // 20% de réduction
                }
                return 0;
            },
        );
    }
    
    /**
     * Accesseur pour obtenir la note moyenne du produit (simulée)
     */
    protected function rating(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Récupérer depuis les attributs s'ils existent
                if (isset($this->attributes['attributes'])) {
                    $attrs = json_decode($this->attributes['attributes'], true);
                    return $attrs['rating'] ?? mt_rand(30, 50) / 10;
                }
                return mt_rand(30, 50) / 10;
            },
        );
    }
    
    /**
     * Relation avec les commandes (à implémenter plus tard)
     */
    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class, 'order_items')
    //         ->withPivot('quantity', 'price')
    //         ->withTimestamps();
    // }
}

