<!-- Conteneur principal avec gestion des animations via Alpine.js -->
<div class="w-full search-container relative overflow-hidden" 
     x-data="{ 
        showFilters: false, 
        selectedTab: 'all',
        animating: false,
        showLoading: false,
        showSearchResults: false,
        darkMode: localStorage.getItem('darkMode') === 'true',
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
        }
     }"
     :class="{ 'dark-mode': darkMode }">
     
     <!-- Cercles décoratifs flottants en arrière-plan -->
     <div class="fixed inset-0 pointer-events-none overflow-hidden" style="z-index: -1;">
        @for ($i = 1; $i <= 15; $i++)
            <div class="absolute rounded-full backdrop-blur-md animate-float-slow"
                 :class="darkMode ? 'bg-purple-500/10' : 'bg-indigo-500/10'"
                 style="
                    width: {{ rand(50, 300) }}px; 
                    height: {{ rand(50, 300) }}px; 
                    top: {{ rand(-10, 110) }}%; 
                    left: {{ rand(-10, 110) }}%; 
                    animation-delay: {{ $i * 0.5 }}s;
                    animation-duration: {{ rand(15, 30) }}s;
                 "></div>
        @endfor
     </div>
     
     <!-- Bouton toggle mode sombre/clair -->
     <button 
         @click="toggleDarkMode()" 
         class="fixed top-4 right-4 z-50 p-2 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110"
         :class="darkMode ? 'bg-gray-800 text-yellow-300' : 'bg-white text-indigo-600'">
         <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
         </svg>
         <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
         </svg>
     </button>
    
    <!-- En-tête avec effet de parallaxe avancé -->
    <div class="relative overflow-hidden rounded-xl mb-8 shadow-2xl transition-all duration-500"
         :class="darkMode ? 'bg-gradient-to-r from-purple-900 to-indigo-900' : 'bg-gradient-to-r from-indigo-500 to-purple-600'">
        
        <!-- Vagues animées dans l'arrière-plan -->
        <div class="absolute inset-x-0 bottom-0 h-20 opacity-30">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full h-full transform animate-wave">
                <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L48,122.7C96,117,192,107,288,122.7C384,139,480,181,576,170.7C672,160,768,96,864,74.7C960,53,1056,75,1152,90.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
        
        <!-- Étoiles scintillantes dans l'arrière-plan -->
        <div class="absolute inset-0 overflow-hidden">
            @for ($i = 1; $i <= 25; $i++)
                <div class="absolute rounded-full animate-twinkle"
                     :class="darkMode ? 'bg-blue-200' : 'bg-white'"
                     style="
                        width: {{ rand(2, 4) }}px; 
                        height: {{ rand(2, 4) }}px; 
                        top: {{ rand(5, 95) }}%; 
                        left: {{ rand(5, 95) }}%; 
                        opacity: {{ rand(30, 70) / 100 }};
                        animation-delay: {{ $i * 0.2 }}s;
                        animation-duration: {{ rand(2, 6) }}s;
                     "></div>
            @endfor
        </div>
        
        <!-- Cercles lumineux avec effets de glassmorphism -->
        <div class="absolute inset-0 overflow-hidden">
            @for ($i = 1; $i <= 6; $i++)
                <div class="absolute rounded-full backdrop-blur-xl animate-float-medium"
                     :class="darkMode ? 'bg-purple-400/10' : 'bg-white/10'"
                     style="
                        width: {{ rand(80, 200) }}px; 
                        height: {{ rand(80, 200) }}px; 
                        top: {{ rand(-20, 120) }}%; 
                        left: {{ rand(-20, 120) }}%; 
                        animation-delay: {{ $i * 0.7 }}s;
                        animation-duration: {{ rand(10, 20) }}s;
                     "></div>
            @endfor
        </div>
        
        <div class="relative z-10 px-8 py-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-6 tracking-tight animate-fadeIn">Trouvez vos produits préférés</h1>
            
            <!-- Barre de recherche animée -->
            <div class="relative max-w-3xl mx-auto transition-all duration-500 transform hover:scale-[1.02]" 
                 x-data="{ focused: false }"
                 :class="{'ring-4 ring-white/30': focused}">
                
                <input type="text" 
                       wire:model.live.debounce.300ms="query"
                       placeholder="Rechercher un produit..."
                       x-on:focus="focused = true; $wire.isLoading = true"
                       x-on:blur="focused = false"
                       x-on:keydown="showLoading = true"
                       x-on:keydown.debounce.500ms="showLoading = $wire.isLoading"
                       class="w-full pl-12 pr-4 py-4 rounded-full border-0 bg-white/95 backdrop-blur-sm shadow-2xl focus:outline-none text-gray-800 placeholder-gray-400">
                
                <!-- Icône de recherche animée -->
                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                    <svg class="w-6 h-6 text-indigo-600 transition-transform duration-300"
                         :class="{'rotate-[-20deg]': focused}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                
                <!-- Animation de chargement -->
                <div x-show="showLoading" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="absolute right-4 top-1/2 transform -translate-y-1/2">
                    <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
            
            <!-- Onglets de filtrage -->
            <div class="flex flex-wrap justify-center gap-3 mt-8 tabs-container">
                <!-- Bouton pour afficher tous les produits (réinitialise les filtres) -->
                <button 
                    wire:click="clearCategoryFilter"
                    @click="selectedTab = 'all'" 
                    :class="{'bg-white text-indigo-600': selectedTab === 'all', 'bg-indigo-400/40 text-white': selectedTab !== 'all'}"
                    class="px-5 py-2 rounded-full text-sm font-medium backdrop-blur-sm transition-all duration-300 hover:bg-white/90 hover:text-indigo-600 tab-button">
                    Tous les produits
                </button>
                
                <!-- Boutons de filtrage par catégorie -->
                @foreach($categories as $index => $category)
                    <button 
                        wire:click="selectCategory('{{ $category }}')" 
                        @click="selectedTab = '{{ $category }}'" 
                        :class="{'bg-white text-indigo-600': selectedTab === '{{ $category }}', 'bg-indigo-400/40 text-white': selectedTab !== '{{ $category }}'}"
                        class="px-5 py-2 rounded-full text-sm font-medium backdrop-blur-sm transition-all duration-300 hover:bg-white/90 hover:text-indigo-600 tab-button"
                        style="animation-delay: {{ $index * 0.1 }}s">
                        {{ $category }}
                    </button>
                @endforeach
                
                <button @click="showFilters = !showFilters" 
                        class="px-5 py-2 rounded-full text-sm font-medium backdrop-blur-sm transition-all duration-300 bg-white/20 text-white hover:bg-white/90 hover:text-indigo-600">
                    <span x-show="!showFilters">Plus de filtres</span>
                    <span x-show="showFilters">Masquer les filtres</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Panneau de filtres avancés avec animation -->
    <div x-show="showFilters"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-4"
         class="bg-white rounded-xl p-6 mb-8 shadow-lg border border-gray-100">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Section filtrage par prix -->
            <div class="filter-group">
                <h3 class="text-gray-800 font-medium mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Filtrer par prix
                </h3>
                <div class="flex items-center gap-2 mb-2">
                    <input type="number" 
                           wire:model.live.debounce.500ms="priceMin" 
                           placeholder="Prix min" 
                           class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all">
                </div>
                <div class="flex items-center gap-2">
                    <input type="number" 
                           wire:model.live.debounce.500ms="priceMax" 
                           placeholder="Prix max" 
                           class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all">
                </div>
            </div>
            
            <!-- Section filtrage par catégorie -->
            <div class="filter-group col-span-1 md:col-span-2">
                <h3 class="text-gray-800 font-medium mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Filtrer par catégorie
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach($categories as $category)
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" 
                                  wire:model.live="selectedCategories" 
                                  value="{{ $category }}"
                                  class="form-checkbox h-5 w-5 text-indigo-600 transition-all duration-150 ease-in-out">
                            <span class="text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $category }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            
            <!-- Section tri des résultats -->
            <div class="filter-group">
                <h3 class="text-gray-800 font-medium mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                    </svg>
                    Trier par
                </h3>
                <div class="space-y-2">
                    <button wire:click="sort('name')" 
                            class="w-full p-2 text-left flex justify-between items-center {{ $sortBy === 'name' ? 'bg-indigo-50 text-indigo-700' : 'bg-white text-gray-700' }} hover:bg-indigo-50 transition-colors rounded-lg">
                        <span>Nom</span>
                        @if($sortBy === 'name')
                            <svg class="w-5 h-5 transition-transform {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        @endif
                    </button>
                    
                    <button wire:click="sort('price')" 
                            class="w-full p-2 text-left flex justify-between items-center {{ $sortBy === 'price' ? 'bg-indigo-50 text-indigo-700' : 'bg-white text-gray-700' }} hover:bg-indigo-50 transition-colors rounded-lg">
                        <span>Prix</span>
                        @if($sortBy === 'price')
                            <svg class="w-5 h-5 transition-transform {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        @endif
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Boutons de filtrage -->
        <div class="mt-6 flex justify-end space-x-3">
            <button wire:click="clearFilters" 
                    class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                Réinitialiser
            </button>
            <button wire:click="applyFilters" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Appliquer les filtres
            </button>
        </div>
    </div>
    
    <!-- Section des résultats de recherche avec animations -->
    <div class="results-container">
        <!-- Affichage du nombre de résultats -->
        @if(count($results) > 0)
            <div class="mb-6 fade-in-up">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 text-indigo-700 mr-2">
                        {{ count($results) }}
                    </span>
                    résultat(s) trouvé(s) {{ !empty($query) ? "pour \"$query\"" : '' }}
                </h2>
            </div>
            
            <!-- Grille des résultats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($results as $index => $product)
                    <div class="product-card" 
                         style="animation-delay: {{ $index * 0.05 }}s;"
                         x-data="{ showQuickView: false }"
                         wire:key="product-{{ $product['id'] }}">
                        <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative h-full flex flex-col">
                            <!-- Badge de promotion avec animation (pour certains produits)-->
                            @if($index % 5 === 0)
                                <div class="absolute top-3 left-3 z-10 animate-pulse">
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        -{{ rand(10, 40) }}%
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Badge de nouveauté (pour certains produits)-->
                            @if($index % 7 === 0)
                                <div class="absolute top-3 right-3 z-10">
                                    <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        NOUVEAU
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Image du produit avec effet de zoom au survol -->
                            <div class="h-48 overflow-hidden relative group">
                                <img src="https://source.unsplash.com/300x200/?product,{{ $product['name'] }}" 
                                     alt="{{ $product['name'] }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                     
                                <!-- Overlay avec boutons d'action -->
                                <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button @click="showQuickView = true" 
                                            class="p-2 rounded-full bg-white text-gray-800 hover:bg-indigo-500 hover:text-white transition-colors shadow-lg transform hover:scale-105">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Détails du produit -->
                            <div class="p-4 flex-grow flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 hover:text-indigo-600 transition-colors line-clamp-1">{{ $product['name'] }}</h3>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ Str::words('Description du produit ' . $product['name'] . ' avec des détails sur ses caractéristiques.', 10) }}</p>
                                </div>
                                
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="text-xl font-bold text-indigo-600">{{ number_format($product['price'], 2) }} €</span>
                                    
                                    <!-- Bouton d'achat avec animation -->
                                    <button 
                                        wire:click="showProductDetails({{ $product['id'] }})" 
                                        class="flex items-center gap-1 px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors group">
                                        <span>Voir</span>
                                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Modal de prévisualisation rapide -->
                            <div x-show="showQuickView" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform scale-90"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-90"
                                 @click.away="showQuickView = false"
                                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
                                 
                                <div class="bg-white rounded-xl overflow-hidden max-w-2xl w-full max-h-[90vh] overflow-y-auto" @click.stop>
                                    <div class="relative">
                                        <img src="https://source.unsplash.com/800x600/?product,{{ $product['name'] }}" 
                                             alt="{{ $product['name'] }}" 
                                             class="w-full h-64 object-cover">
                                             
                                        <button @click="showQuickView = false" 
                                                class="absolute top-3 right-3 bg-white text-gray-800 rounded-full p-1 shadow-md hover:bg-gray-100 transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <div class="p-6">
                                        <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ $product['name'] }}</h3>
                                        <div class="flex items-center mb-4">
                                            <span class="text-2xl font-bold text-indigo-600 mr-3">{{ number_format($product['price'], 2) }} €</span>
                                            @if($index % 5 === 0)
                                                <span class="line-through text-gray-400">{{ number_format($product['price'] * 1.2, 2) }} €</span>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-4">
                                            <h4 class="font-medium text-gray-800 mb-2">Description</h4>
                                            <p class="text-gray-600">{{ 'Description détaillée du produit ' . $product['name'] . '. Ce produit est de haute qualité et offre une excellente performance. Il est conçu pour durer et s\'adapter à vos besoins quotidiens.' }}</p>
                                        </div>
                                        
                                        <div class="flex space-x-3 mt-6">
                                            <button 
                                                class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Ajouter au panier
                                            </button>
                                            <button 
                                                wire:click="showProductDetails({{ $product['id'] }})" 
                                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                                Plus de détails
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Bouton pour charger plus -->
            @if(count($results) >= 12)
                <div class="mt-10 text-center">
                    <button 
                        wire:click="loadMore" 
                        class="px-6 py-3 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-300 text-gray-700 flex items-center justify-center mx-auto">
                        <span wire:loading.remove wire:target="loadMore">Charger plus de produits</span>
                        <span wire:loading wire:target="loadMore" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Chargement...
                        </span>
                    </button>
                </div>
            @endif
        @elseif(strlen($query) > 1)
            <!-- Message quand aucun résultat n'est trouvé -->
            <div class="bg-white rounded-xl p-8 text-center shadow-md border border-gray-100 my-8 fade-in-up">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun résultat trouvé</h3>
                <p class="text-gray-500 mb-6">Nous n'avons trouvé aucun produit correspondant à votre recherche "{{ $query }}".</p>
                <div class="space-y-4">
                    <p class="text-gray-600">Suggestions :</p>
                    <ul class="text-sm text-gray-500 list-disc list-inside space-y-1">
                        <li>Vérifiez l'orthographe de votre recherche</li>
                        <li>Utilisez des mots plus génériques</li>
                        <li>Essayez une autre catégorie</li>
                        <li>Réduisez le nombre de filtres appliqués</li>
                    </ul>
                </div>
            </div>
        @elseif(empty($query))
            <!-- Produits populaires quand aucune recherche n'est faite -->
            <div class="popular-products fade-in-up">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    Produits populaires
                </h2>
                
                <!-- Carousel de produits populaires -->
                <div class="relative overflow-hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 popular-slider">
                        @foreach($popularProducts as $index => $product)
                            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 popular-product-card" style="animation-delay: {{ $index * 0.05 }}s;">
                                <!-- Contenu similaire aux cartes de résultats, mais avec une animation d'entrée différente -->
                                <div class="h-48 overflow-hidden relative group">
                                    <img src="https://source.unsplash.com/300x200/?product,{{ $product->name }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </div>
                                
                                <div class="p-4">
                                    <h3 class="text-lg font-medium text-gray-800 line-clamp-1">{{ $product->name }}</h3>
                                    
                                    <div class="mt-4 flex justify-between items-center">
                                        <span class="text-xl font-bold text-indigo-600">{{ number_format($product->price, 2) }} €</span>
                                        
                                        <button 
                                            wire:click="showProductDetails({{ $product->id }})" 
                                            class="flex items-center gap-1 px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors group">
                                            <span>Voir</span>
                                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Panneau de filtres avancés avec animation -->
    <div x-show="showFilters"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-4"
         class="bg-white rounded-xl p-6 mb-8 shadow-lg border border-gray-100">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Section filtrage par prix -->
            <div class="filter-group">
                <h3 class="text-gray-800 font-medium mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Filtrer par prix
                </h3>
                <div class="flex items-center gap-2 mb-2">
                    <input type="number" 
                           wire:model.live.debounce.500ms="priceMin" 
                           placeholder="Prix min" 
                           class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all">
                </div>
                <div class="flex items-center gap-2">
                    <input type="number" 
                           wire:model.live.debounce.500ms="priceMax" 
                           placeholder="Prix max" 
                           class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all">
                </div>
            </div>
            
            <!-- Section filtrage par catégorie -->
            <div class="filter-group col-span-1 md:col-span-2">
                <h3 class="text-gray-800 font-medium mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Filtrer par catégorie
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach($categories as $category)
                        <label class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" 
                                  wire:model.live="selectedCategories" 
                                  value="{{ $category }}"
                                  class="form-checkbox h-5 w-5 text-indigo-600 transition-all duration-150 ease-in-out">
                            <span class="text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $category }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            
            <!-- Section tri des résultats -->
            <div class="filter-group">
                <h3 class="text-gray-800 font-medium mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                    </svg>
                    Trier par
                </h3>
                <div class="space-y-2">
                    <button wire:click="sort('name')" 
                            class="w-full p-2 text-left flex justify-between items-center {{ $sortBy === 'name' ? 'bg-indigo-50 text-indigo-700' : 'bg-white text-gray-700' }} hover:bg-indigo-50 transition-colors rounded-lg">
                        <span>Nom</span>
                        @if($sortBy === 'name')
                            <svg class="w-5 h-5 transition-transform {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        @endif
                    </button>
                    
                    <button wire:click="sort('price')" 
                            class="w-full p-2 text-left flex justify-between items-center {{ $sortBy === 'price' ? 'bg-indigo-50 text-indigo-700' : 'bg-white text-gray-700' }} hover:bg-indigo-50 transition-colors rounded-lg">
                        <span>Prix</span>
                        @if($sortBy === 'price')
                            <svg class="w-5 h-5 transition-transform {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        @endif
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Boutons de filtrage -->
        <div class="mt-6 flex justify-end space-x-3">
            <button wire:click="clearFilters" 
                    class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                Réinitialiser
            </button>
            <button wire:click="applyFilters" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Appliquer les filtres
            </button>
        </div>
    </div>
    <!-- Styles pour les animations -->
    <style>
        /* Animation d'apparition des résultats */
        .product-card {
            opacity: 0;
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        .popular-product-card {
            opacity: 0;
            animation: fadeInRight 0.5s ease-out forwards;
        }
        
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Animation de flottement pour les particules */
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-10px) rotate(5deg);
            }
            100% {
                transform: translateY(0) rotate(0deg);
            }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Animation d'apparition du contenu */
        .animate-fadeIn {
            animation: fadeIn 1s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Animation des onglets */
        .tab-button {
            opacity: 0;
            animation: fadeInDown 0.5s ease-out forwards;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Animation de pulsation pour les badges */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</div>