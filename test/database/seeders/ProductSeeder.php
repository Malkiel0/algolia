<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Liste des catégories de produits pour générer des données cohérentes
     */
    protected $categories = [
        'Électronique' => [
            'Smartphones', 'Ordinateurs', 'Tablettes', 'Accessoires', 'Audio', 
            'Télévisions', 'Appareils photo', 'Drones', 'Consoles'
        ],
        'Vêtements' => [
            'T-shirts', 'Pantalons', 'Robes', 'Chemises', 'Vestes', 
            'Chaussures', 'Accessoires', 'Sous-vêtements', 'Sport'
        ],
        'Maison' => [
            'Meubles', 'Décoration', 'Linge de maison', 'Cuisine', 'Electroménager', 
            'Jardin', 'Bricolage', 'Rangement', 'Salle de bain'
        ],
        'Alimentation' => [
            'Épicerie', 'Boissons', 'Snacks', 'Bio', 'Frais', 
            'Surgelés', 'Épices', 'Pâtisserie', 'Produits du monde'
        ],
        'Sports' => [
            'Fitness', 'Running', 'Cyclisme', 'Sports d\'équipe', 'Natation', 
            'Randonnée', 'Sports d\'hiver', 'Équipements', 'Vêtements'
        ],
        'Beauté' => [
            'Soins du visage', 'Soins du corps', 'Parfums', 'Maquillage', 'Cheveux', 
            'Bio', 'Homme', 'Sets', 'Accessoires'
        ],
        'Jouets' => [
            'Peluches', 'Jeux de société', 'Figurines', 'Construction', 'Éducatifs', 
            'Plein air', 'Poupées', 'Véhicules', 'Créatifs'
        ],
        'Livres' => [
            'Romans', 'Science-fiction', 'Policier', 'Jeunesse', 'Cuisine', 
            'Développement personnel', 'Histoire', 'Sciences', 'BD'
        ]
    ];
    
    /**
     * Liste des matériaux pour des descriptions variées
     */
    protected $materials = [
        'Bois', 'Métal', 'Plastique', 'Verre', 'Cuir', 'Coton', 'Lin', 'Soie',
        'Nylon', 'Polyester', 'Céramique', 'Aluminium', 'Carbone', 'Caoutchouc'
    ];
    
    /**
     * Liste des couleurs pour des descriptions variées
     */
    protected $colors = [
        'Noir', 'Blanc', 'Rouge', 'Bleu', 'Vert', 'Jaune', 'Orange', 'Violet',
        'Rose', 'Gris', 'Marron', 'Beige', 'Doré', 'Argenté', 'Turquoise'
    ];
    
    /**
     * Liste des adjectifs pour des descriptions variées
     */
    protected $adjectives = [
        'Premium', 'Élégant', 'Moderne', 'Traditionnel', 'Innovant', 'Compact',
        'Spacieux', 'Léger', 'Robuste', 'Luxueux', 'Pratique', 'Économique',
        'Intelligent', 'Ergonomique', 'Écologique', 'Durable', 'Sophistiqué'
    ];

    /**
     * Exécute le seeder pour générer 500 produits
     */
    public function run(): void
    {
        // Vider la table avant de remplir
        Product::query()->delete();
        
        // Générer 500 produits avec des données réalistes
        for ($i = 0; $i < 500; $i++) {
            // Sélectionner une catégorie et sous-catégorie aléatoire
            $category = array_rand($this->categories);
            $subcategories = $this->categories[$category];
            $subcategory = $subcategories[array_rand($subcategories)];
            
            // Sélectionner des caractéristiques aléatoires
            $material = $this->materials[array_rand($this->materials)];
            $color = $this->colors[array_rand($this->colors)];
            $adjective = $this->adjectives[array_rand($this->adjectives)];
            
            // Générer un prix réaliste basé sur la catégorie
            $basePrice = $this->getPriceRangeByCategory($category);
            $price = round(mt_rand($basePrice[0] * 100, $basePrice[1] * 100) / 100, 2);
            
            // Créer un nom de produit réaliste
            $productName = $this->generateProductName($category, $subcategory, $adjective);
            
            // Créer la description du produit
            $description = $this->generateProductDescription($productName, $category, $subcategory, $material, $color, $adjective);
            
            // Générer des attributs supplémentaires (à stocker en JSON)
            $attributes = $this->generateAttributes($category, $subcategory);
            
            // Créer le produit
            Product::create([
                'name' => $productName,
                'price' => $price,
                'category' => $category,
                'subcategory' => $subcategory,
                'description' => $description,
                'attributes' => json_encode($attributes),
                'color' => $color,
                'material' => $material,
                'stock' => mt_rand(0, 100),
                'sku' => Str::random(8),
                'created_at' => now()->subDays(rand(1, 365))
            ]);
        }
        
        $this->command->info('500 produits générés avec succès !');
    }
    
    /**
     * Génère un nom de produit réaliste basé sur la catégorie et la sous-catégorie
     */
    protected function generateProductName($category, $subcategory, $adjective): string
    {
        // Générer des préfixes de marque aléatoires
        $brands = [
            'Électronique' => ['Tech', 'Smart', 'Neo', 'Ultra', 'Digi', 'Max', 'Pro', 'i', 'Cyber', 'Quantum'],
            'Vêtements' => ['Style', 'Fashion', 'Trend', 'Lux', 'Chic', 'Elite', 'Urban', 'Classic', 'Modern', 'Cosy'],
            'Maison' => ['Home', 'Deco', 'Comfort', 'Living', 'House', 'Majestic', 'Cozy', 'Dream', 'Harmony', 'Eco'],
            'Alimentation' => ['Bio', 'Fresh', 'Tasty', 'Gourmet', 'Delice', 'Natural', 'Pure', 'Saveur', 'Artisan', 'Select'],
            'Sports' => ['Active', 'Power', 'Energy', 'Pro', 'Athletic', 'Flex', 'Fit', 'Dynamic', 'Champion', 'Boost'],
            'Beauté' => ['Glow', 'Beauty', 'Radiant', 'Divine', 'Essence', 'Pure', 'Sublime', 'Charm', 'Elite', 'Magic'],
            'Jouets' => ['Fun', 'Play', 'Joy', 'Kids', 'Wonder', 'Magic', 'Happy', 'Dream', 'Imagine', 'Adventure'],
            'Livres' => ['Saga', 'Story', 'Chronicle', 'Scholar', 'Mind', 'Wisdom', 'Journey', 'Knowledge', 'Epic', 'Tales']
        ];
        
        $brand = $brands[$category][array_rand($brands[$category])];
        $uniqueId = mt_rand(1, 9999);
        
        // Construire le nom du produit
        return $adjective . ' ' . $brand . ' ' . $subcategory . ' ' . $uniqueId;
    }
    
    /**
     * Génère une description de produit réaliste
     */
    protected function generateProductDescription($name, $category, $subcategory, $material, $color, $adjective): string
    {
        $templates = [
            "Découvrez notre {$name}, le choix parfait pour tous vos besoins en {$subcategory}. Fabriqué en {$material} {$color} de haute qualité, ce produit {$adjective} offre une expérience utilisateur inégalée. Ses caractéristiques exceptionnelles en font un indispensable dans votre collection de {$category}.",
            
            "Le {$name} est conçu pour répondre aux exigences les plus élevées. Son design {$adjective} en {$material} {$color} allie esthétique et fonctionnalité. Idéal pour les amateurs de {$subcategory} qui recherchent un produit durable et performant.",
            
            "Profitez de l'excellence avec notre {$name}. Sa fabrication en {$material} {$color} garantit durabilité et élégance. Ce produit {$adjective} représente l'innovation dans le domaine du {$subcategory}. Une valeur sûre pour les connaisseurs de {$category}.",
            
            "Le {$name} se distingue par sa qualité supérieure et son design {$adjective}. Réalisé en {$material} {$color}, il offre confort et style pour tous les passionnés de {$subcategory}. Un must-have dans l'univers du {$category} moderne.",
            
            "Notre {$name} redéfinit les standards du {$subcategory}. Avec sa structure en {$material} {$color} et son approche {$adjective}, il combine innovation et tradition. Une pièce exceptionnelle pour les amateurs exigeants de {$category}."
        ];
        
        return $templates[array_rand($templates)];
    }
    
    /**
     * Génère des attributs spécifiques à la catégorie
     */
    protected function generateAttributes($category, $subcategory): array
    {
        $commonAttrs = [
            'warranty' => ['1 an', '2 ans', '3 ans', '5 ans', 'À vie'][array_rand(['1 an', '2 ans', '3 ans', '5 ans', 'À vie'])],
            'origin' => ['France', 'Italie', 'Allemagne', 'Espagne', 'Portugal', 'Suisse', 'Belgique', 'Pays-Bas', 'Japon', 'Corée du Sud'][array_rand(['France', 'Italie', 'Allemagne', 'Espagne', 'Portugal', 'Suisse', 'Belgique', 'Pays-Bas', 'Japon', 'Corée du Sud'])],
            'rating' => mt_rand(30, 50) / 10, // Note entre 3.0 et 5.0
        ];
        
        // Attributs spécifiques par catégorie
        $specificAttrs = [];
        
        switch ($category) {
            case 'Électronique':
                $specificAttrs = [
                    'processor' => ['Intel Core i3', 'Intel Core i5', 'Intel Core i7', 'Intel Core i9', 'AMD Ryzen 5', 'AMD Ryzen 7'][array_rand(['Intel Core i3', 'Intel Core i5', 'Intel Core i7', 'Intel Core i9', 'AMD Ryzen 5', 'AMD Ryzen 7'])],
                    'memory' => [4, 8, 16, 32, 64][array_rand([4, 8, 16, 32, 64])] . ' GB',
                    'storage' => [128, 256, 512, 1024, 2048][array_rand([128, 256, 512, 1024, 2048])] . ' GB',
                    'screen_size' => [5.5, 6.1, 6.7, 13.3, 15.6, 27, 32, 43, 55, 65][array_rand([5.5, 6.1, 6.7, 13.3, 15.6, 27, 32, 43, 55, 65])] . ' pouces',
                ];
                break;
                
            case 'Vêtements':
                $specificAttrs = [
                    'size' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'][array_rand(['XS', 'S', 'M', 'L', 'XL', 'XXL'])],
                    'fabric' => ['Coton', 'Polyester', 'Lin', 'Soie', 'Laine', 'Denim'][array_rand(['Coton', 'Polyester', 'Lin', 'Soie', 'Laine', 'Denim'])] . ' ' . mt_rand(80, 100) . '%',
                    'care' => ['Lavage machine', 'Lavage à main', 'Nettoyage à sec'][array_rand(['Lavage machine', 'Lavage à main', 'Nettoyage à sec'])],
                ];
                break;
                
            case 'Maison':
                $specificAttrs = [
                    'dimensions' => mt_rand(30, 200) . 'x' . mt_rand(30, 200) . 'x' . mt_rand(30, 200) . ' cm',
                    'weight' => mt_rand(1, 50) . ' kg',
                    'assembly_required' => [true, false][array_rand([true, false])],
                ];
                break;
                
            case 'Alimentation':
                $specificAttrs = [
                    'weight' => mt_rand(100, 1000) . ' g',
                    'calories' => mt_rand(50, 500) . ' kcal',
                    'organic' => [true, false][array_rand([true, false])],
                    'allergens' => ['Aucun', 'Gluten', 'Lactose', 'Fruits à coque', 'Soja'][array_rand(['Aucun', 'Gluten', 'Lactose', 'Fruits à coque', 'Soja'])],
                ];
                break;
                
            default:
                $specificAttrs = [
                    'weight' => mt_rand(100, 5000) . ' g',
                    'dimensions' => mt_rand(10, 100) . 'x' . mt_rand(10, 100) . 'x' . mt_rand(10, 100) . ' cm',
                ];
        }
        
        return array_merge($commonAttrs, $specificAttrs);
    }
    
    /**
     * Retourne une fourchette de prix réaliste en fonction de la catégorie
     */
    protected function getPriceRangeByCategory($category): array
    {
        $priceRanges = [
            'Électronique' => [199, 1999],
            'Vêtements' => [19.99, 299.99],
            'Maison' => [29.99, 999.99],
            'Alimentation' => [2.99, 49.99],
            'Sports' => [19.99, 499.99],
            'Beauté' => [9.99, 149.99],
            'Jouets' => [12.99, 199.99],
            'Livres' => [7.99, 59.99]
        ];
        
        return $priceRanges[$category] ?? [9.99, 199.99];
    }
}
<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Liste des catégories de produits pour générer des données cohérentes
     */
    protected $categories = [
        'Électronique' => [
            'Smartphones', 'Ordinateurs', 'Tablettes', 'Accessoires', 'Audio', 
            'Télévisions', 'Appareils photo', 'Drones', 'Consoles'
        ],
        'Vêtements' => [
            'T-shirts', 'Pantalons', 'Robes', 'Chemises', 'Vestes', 
            'Chaussures', 'Accessoires', 'Sous-vêtements', 'Sport'
        ],
        'Maison' => [
            'Meubles', 'Décoration', 'Linge de maison', 'Cuisine', 'Electroménager', 
            'Jardin', 'Bricolage', 'Rangement', 'Salle de bain'
        ],
        'Alimentation' => [
            'Épicerie', 'Boissons', 'Snacks', 'Bio', 'Frais', 
            'Surgelés', 'Épices', 'Pâtisserie', 'Produits du monde'
        ],
        'Sports' => [
            'Fitness', 'Running', 'Cyclisme', 'Sports d\'équipe', 'Natation', 
            'Randonnée', 'Sports d\'hiver', 'Équipements', 'Vêtements'
        ],
        'Beauté' => [
            'Soins du visage', 'Soins du corps', 'Parfums', 'Maquillage', 'Cheveux', 
            'Bio', 'Homme', 'Sets', 'Accessoires'
        ],
        'Jouets' => [
            'Peluches', 'Jeux de société', 'Figurines', 'Construction', 'Éducatifs', 
            'Plein air', 'Poupées', 'Véhicules', 'Créatifs'
        ],
        'Livres' => [
            'Romans', 'Science-fiction', 'Policier', 'Jeunesse', 'Cuisine', 
            'Développement personnel', 'Histoire', 'Sciences', 'BD'
        ]
    ];
    
    /**
     * Liste des matériaux pour des descriptions variées
     */
    protected $materials = [
        'Bois', 'Métal', 'Plastique', 'Verre', 'Cuir', 'Coton', 'Lin', 'Soie',
        'Nylon', 'Polyester', 'Céramique', 'Aluminium', 'Carbone', 'Caoutchouc'
    ];
    
    /**
     * Liste des couleurs pour des descriptions variées
     */
    protected $colors = [
        'Noir', 'Blanc', 'Rouge', 'Bleu', 'Vert', 'Jaune', 'Orange', 'Violet',
        'Rose', 'Gris', 'Marron', 'Beige', 'Doré', 'Argenté', 'Turquoise'
    ];
    
    /**
     * Liste des adjectifs pour des descriptions variées
     */
    protected $adjectives = [
        'Premium', 'Élégant', 'Moderne', 'Traditionnel', 'Innovant', 'Compact',
        'Spacieux', 'Léger', 'Robuste', 'Luxueux', 'Pratique', 'Économique',
        'Intelligent', 'Ergonomique', 'Écologique', 'Durable', 'Sophistiqué'
    ];

    /**
     * Exécute le seeder pour générer 500 produits
     */
    public function run(): void
    {
        // Vider la table avant de remplir
        Product::query()->delete();
        
        // Générer 500 produits avec des données réalistes
        for ($i = 0; $i < 500; $i++) {
            // Sélectionner une catégorie et sous-catégorie aléatoire
            $category = array_rand($this->categories);
            $subcategories = $this->categories[$category];
            $subcategory = $subcategories[array_rand($subcategories)];
            
            // Sélectionner des caractéristiques aléatoires
            $material = $this->materials[array_rand($this->materials)];
            $color = $this->colors[array_rand($this->colors)];
            $adjective = $this->adjectives[array_rand($this->adjectives)];
            
            // Générer un prix réaliste basé sur la catégorie
            $basePrice = $this->getPriceRangeByCategory($category);
            $price = round(mt_rand($basePrice[0] * 100, $basePrice[1] * 100) / 100, 2);
            
            // Créer un nom de produit réaliste
            $productName = $this->generateProductName($category, $subcategory, $adjective);
            
            // Créer la description du produit
            $description = $this->generateProductDescription($productName, $category, $subcategory, $material, $color, $adjective);
            
            // Générer des attributs supplémentaires (à stocker en JSON)
            $attributes = $this->generateAttributes($category, $subcategory);
            
            // Créer le produit
            Product::create([
                'name' => $productName,
                'price' => $price,
                'category' => $category,
                'subcategory' => $subcategory,
                'description' => $description,
                'attributes' => json_encode($attributes),
                'color' => $color,
                'material' => $material,
                'stock' => mt_rand(0, 100),
                'sku' => Str::random(8),
                'created_at' => now()->subDays(rand(1, 365))
            ]);
        }
        
        $this->command->info('500 produits générés avec succès !');
    }
    
    /**
     * Génère un nom de produit réaliste basé sur la catégorie et la sous-catégorie
     */
    protected function generateProductName($category, $subcategory, $adjective): string
    {
        // Générer des préfixes de marque aléatoires
        $brands = [
            'Électronique' => ['Tech', 'Smart', 'Neo', 'Ultra', 'Digi', 'Max', 'Pro', 'i', 'Cyber', 'Quantum'],
            'Vêtements' => ['Style', 'Fashion', 'Trend', 'Lux', 'Chic', 'Elite', 'Urban', 'Classic', 'Modern', 'Cosy'],
            'Maison' => ['Home', 'Deco', 'Comfort', 'Living', 'House', 'Majestic', 'Cozy', 'Dream', 'Harmony', 'Eco'],
            'Alimentation' => ['Bio', 'Fresh', 'Tasty', 'Gourmet', 'Delice', 'Natural', 'Pure', 'Saveur', 'Artisan', 'Select'],
            'Sports' => ['Active', 'Power', 'Energy', 'Pro', 'Athletic', 'Flex', 'Fit', 'Dynamic', 'Champion', 'Boost'],
            'Beauté' => ['Glow', 'Beauty', 'Radiant', 'Divine', 'Essence', 'Pure', 'Sublime', 'Charm', 'Elite', 'Magic'],
            'Jouets' => ['Fun', 'Play', 'Joy', 'Kids', 'Wonder', 'Magic', 'Happy', 'Dream', 'Imagine', 'Adventure'],
            'Livres' => ['Saga', 'Story', 'Chronicle', 'Scholar', 'Mind', 'Wisdom', 'Journey', 'Knowledge', 'Epic', 'Tales']
        ];
        
        $brand = $brands[$category][array_rand($brands[$category])];
        $uniqueId = mt_rand(1, 9999);
        
        // Construire le nom du produit
        return $adjective . ' ' . $brand . ' ' . $subcategory . ' ' . $uniqueId;
    }
    
    /**
     * Génère une description de produit réaliste
     */
    protected function generateProductDescription($name, $category, $subcategory, $material, $color, $adjective): string
    {
        $templates = [
            "Découvrez notre {$name}, le choix parfait pour tous vos besoins en {$subcategory}. Fabriqué en {$material} {$color} de haute qualité, ce produit {$adjective} offre une expérience utilisateur inégalée. Ses caractéristiques exceptionnelles en font un indispensable dans votre collection de {$category}.",
            
            "Le {$name} est conçu pour répondre aux exigences les plus élevées. Son design {$adjective} en {$material} {$color} allie esthétique et fonctionnalité. Idéal pour les amateurs de {$subcategory} qui recherchent un produit durable et performant.",
            
            "Profitez de l'excellence avec notre {$name}. Sa fabrication en {$material} {$color} garantit durabilité et élégance. Ce produit {$adjective} représente l'innovation dans le domaine du {$subcategory}. Une valeur sûre pour les connaisseurs de {$category}.",
            
            "Le {$name} se distingue par sa qualité supérieure et son design {$adjective}. Réalisé en {$material} {$color}, il offre confort et style pour tous les passionnés de {$subcategory}. Un must-have dans l'univers du {$category} moderne.",
            
            "Notre {$name} redéfinit les standards du {$subcategory}. Avec sa structure en {$material} {$color} et son approche {$adjective}, il combine innovation et tradition. Une pièce exceptionnelle pour les amateurs exigeants de {$category}."
        ];
        
        return $templates[array_rand($templates)];
    }
    
    /**
     * Génère des attributs spécifiques à la catégorie
     */
    protected function generateAttributes($category, $subcategory): array
    {
        $commonAttrs = [
            'warranty' => ['1 an', '2 ans', '3 ans', '5 ans', 'À vie'][array_rand(['1 an', '2 ans', '3 ans', '5 ans', 'À vie'])],
            'origin' => ['France', 'Italie', 'Allemagne', 'Espagne', 'Portugal', 'Suisse', 'Belgique', 'Pays-Bas', 'Japon', 'Corée du Sud'][array_rand(['France', 'Italie', 'Allemagne', 'Espagne', 'Portugal', 'Suisse', 'Belgique', 'Pays-Bas', 'Japon', 'Corée du Sud'])],
            'rating' => mt_rand(30, 50) / 10, // Note entre 3.0 et 5.0
        ];
        
        // Attributs spécifiques par catégorie
        $specificAttrs = [];
        
        switch ($category) {
            case 'Électronique':
                $specificAttrs = [
                    'processor' => ['Intel Core i3', 'Intel Core i5', 'Intel Core i7', 'Intel Core i9', 'AMD Ryzen 5', 'AMD Ryzen 7'][array_rand(['Intel Core i3', 'Intel Core i5', 'Intel Core i7', 'Intel Core i9', 'AMD Ryzen 5', 'AMD Ryzen 7'])],
                    'memory' => [4, 8, 16, 32, 64][array_rand([4, 8, 16, 32, 64])] . ' GB',
                    'storage' => [128, 256, 512, 1024, 2048][array_rand([128, 256, 512, 1024, 2048])] . ' GB',
                    'screen_size' => [5.5, 6.1, 6.7, 13.3, 15.6, 27, 32, 43, 55, 65][array_rand([5.5, 6.1, 6.7, 13.3, 15.6, 27, 32, 43, 55, 65])] . ' pouces',
                ];
                break;
                
            case 'Vêtements':
                $specificAttrs = [
                    'size' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'][array_rand(['XS', 'S', 'M', 'L', 'XL', 'XXL'])],
                    'fabric' => ['Coton', 'Polyester', 'Lin', 'Soie', 'Laine', 'Denim'][array_rand(['Coton', 'Polyester', 'Lin', 'Soie', 'Laine', 'Denim'])] . ' ' . mt_rand(80, 100) . '%',
                    'care' => ['Lavage machine', 'Lavage à main', 'Nettoyage à sec'][array_rand(['Lavage machine', 'Lavage à main', 'Nettoyage à sec'])],
                ];
                break;
                
            case 'Maison':
                $specificAttrs = [
                    'dimensions' => mt_rand(30, 200) . 'x' . mt_rand(30, 200) . 'x' . mt_rand(30, 200) . ' cm',
                    'weight' => mt_rand(1, 50) . ' kg',
                    'assembly_required' => [true, false][array_rand([true, false])],
                ];
                break;
                
            case 'Alimentation':
                $specificAttrs = [
                    'weight' => mt_rand(100, 1000) . ' g',
                    'calories' => mt_rand(50, 500) . ' kcal',
                    'organic' => [true, false][array_rand([true, false])],
                    'allergens' => ['Aucun', 'Gluten', 'Lactose', 'Fruits à coque', 'Soja'][array_rand(['Aucun', 'Gluten', 'Lactose', 'Fruits à coque', 'Soja'])],
                ];
                break;
                
            default:
                $specificAttrs = [
                    'weight' => mt_rand(100, 5000) . ' g',
                    'dimensions' => mt_rand(10, 100) . 'x' . mt_rand(10, 100) . 'x' . mt_rand(10, 100) . ' cm',
                ];
        }
        
        return array_merge($commonAttrs, $specificAttrs);
    }
    
    /**
     * Retourne une fourchette de prix réaliste en fonction de la catégorie
     */
    protected function getPriceRangeByCategory($category): array
    {
        $priceRanges = [
            'Électronique' => [199, 1999],
            'Vêtements' => [19.99, 299.99],
            'Maison' => [29.99, 999.99],
            'Alimentation' => [2.99, 49.99],
            'Sports' => [19.99, 499.99],
            'Beauté' => [9.99, 149.99],
            'Jouets' => [12.99, 199.99],
            'Livres' => [7.99, 59.99]
        ];
        
        return $priceRanges[$category] ?? [9.99, 199.99];
    }
}
