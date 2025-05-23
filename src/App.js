import React, { useState, useEffect } from 'react';
import './App.css';

/**
 * Composant de navigation
 * Affiche un menu permettant de naviguer entre les différentes sections
 * @param {string} activeSection - La section actuellement active
 * @param {function} naviguerVers - Fonction pour naviguer vers une section
 */
function Navigation({ activeSection, naviguerVers }) {
  const sections = [
    { id: 'accueil', nom: '🏠 Accueil' },
    { id: 'introduction', nom: '🎬 Introduction à Algolia' },
    { id: 'installation', nom: '🔧 Installation avec Laravel' },
    { id: 'configuration', nom: '⚙️ Configuration' },
    { id: 'indexation', nom: '📝 Indexation' },
    { id: 'recherche', nom: '🔍 Recherche' },
    { id: 'exemples', nom: '🧪 Exemples pratiques' },
    { id: 'conclusion', nom: '🎯 Conclusion' },
  ];
  
  return (
    <nav className="max-w-4xl mx-auto">
      <div className="bg-white rounded-xl shadow-lg overflow-x-auto">
        <ul className="flex flex-nowrap p-1 md:p-2">
          {sections.map((section) => (
            <li key={section.id} className="flex-none">
              <button
                onClick={() => naviguerVers(section.id)}
                className={`px-3 py-2 md:px-4 md:py-2 rounded-lg whitespace-nowrap transition-all ${
                  activeSection === section.id 
                    ? 'bg-blue-600 text-white font-bold' 
                    : 'text-gray-600 hover:bg-gray-100'
                }`}
              >
                {section.nom}
              </button>
            </li>
          ))}
        </ul>
      </div>
    </nav>
  );
}

/**
 * Composant Accueil
 * Page d'accueil du cours
 * @param {function} naviguerVers - Fonction pour naviguer vers une section
 */
function Accueil({ naviguerVers }) {
  return (
    <div className="text-center">
      <h2 className="text-3xl font-bold text-purple-600 mb-6">
        Bienvenue dans l'aventure magique d'Algolia avec Laravel! 🎉
      </h2>
      <div className="w-32 h-32 mx-auto bg-contain bg-center bg-no-repeat mb-6"
           style={{ backgroundImage: "url('https://www.algolia.com/static-assets/images/infrastructure/algolia-mark-circle.svg')" }}>
      </div>
      <p className="text-lg text-gray-700 mb-8">
        Dans ce cours amusant, tu vas découvrir comment intégrer la magie d'Algolia dans tes applications Laravel pour créer des recherches super rapides et intelligentes!
      </p>
      <button 
        className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full transition-all transform hover:scale-105" 
        onClick={() => naviguerVers('introduction')}
      >
        Commencer l'aventure 🧙‍♂️
      </button>
    </div>
  );
}

/**
 * Composant Introduction
 * Présente Algolia et ses avantages pour Laravel
 * @param {function} naviguerVers - Fonction pour naviguer vers une section
 */
function Introduction({ naviguerVers }) {
  return (
    <div className="max-w-4xl mx-auto">
      <h2 className="text-3xl font-bold text-center text-blue-600 mb-8">🎬 Introduction à Algolia</h2>
      <p className="text-lg text-gray-700 mb-4">
        Algolia est une plateforme de recherche puissante qui te permet d'ajouter une recherche rapide et pertinente à ton application Laravel!
      </p>
      <p className="text-lg text-gray-700 mb-4">
        Avec Algolia, tu peux offrir à tes utilisateurs une expérience de recherche similaire à celle de Google, avec des résultats instantanés et pertinents.
      </p>
      <div className="bg-blue-50 rounded-lg p-6 border-2 border-blue-200 mb-6">
        <h3 className="text-xl font-bold text-blue-600 mb-3">✨ Pourquoi utiliser Algolia avec Laravel?</h3>
        <ul className="space-y-2 list-disc pl-6">
          <li>Recherche ultra-rapide (résultats en quelques millisecondes)</li>
          <li>Tolérance aux fautes de frappe</li>
          <li>Recherche par facettes</li>
          <li>Mise en surbrillance des résultats</li>
          <li>Intégration facile avec Laravel via Laravel Scout</li>
        </ul>
      </div>
      <div className="flex justify-between mt-8">
        <button 
          className="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('accueil')}
        >
          ⬅️ Accueil
        </button>
        <button 
          className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('installation')}
        >
          Installation ➡️
        </button>
      </div>
    </div>
  );
}

/**
 * Composant Installation
 * Explique comment installer Algolia avec Laravel
 * @param {function} naviguerVers - Fonction pour naviguer vers une section
 */
function Installation({ naviguerVers }) {
  return (
    <div className="max-w-4xl mx-auto">
      <h2 className="text-3xl font-bold text-center text-blue-600 mb-8">🔧 Installation avec Laravel</h2>
      <p className="text-lg text-gray-700 mb-4">
        Pour installer Algolia dans ton projet Laravel 12, nous allons utiliser Laravel Scout!
      </p>
      <div className="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 mb-6 overflow-x-auto">
        <h3 className="text-xl font-bold text-gray-700 mb-3">📦 Étape 1: Installation des packages</h3>
        <pre className="bg-gray-800 text-green-400 p-4 rounded-md">
          composer require laravel/scout algolia/algoliasearch-client-php
        </pre>
      </div>
      <div className="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 mb-6 overflow-x-auto">
        <h3 className="text-xl font-bold text-gray-700 mb-3">⚙️ Étape 2: Publication de la configuration</h3>
        <pre className="bg-gray-800 text-green-400 p-4 rounded-md">
          php artisan vendor:publish --provider="Laravel\\Scout\\ScoutServiceProvider"
        </pre>
      </div>
      <div className="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 mb-6 overflow-x-auto">
        <h3 className="text-xl font-bold text-gray-700 mb-3">🔑 Étape 3: Configuration des clés API</h3>
        <p className="text-md text-gray-700 mb-2">Ajoute tes clés API Algolia dans le fichier .env:</p>
        <pre className="bg-gray-800 text-green-400 p-4 rounded-md">
          ALGOLIA_APP_ID=ton_app_id<br/>
          ALGOLIA_SECRET=ta_clé_secrète
        </pre>
      </div>
      <div className="flex justify-between mt-8">
        <button 
          className="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('introduction')}
        >
          ⬅️ Introduction
        </button>
        <button 
          className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('configuration')}
        >
          Configuration ➡️
        </button>
      </div>
    </div>
  );
}

/**
 * Composant Configuration
 * Explique comment configurer Algolia dans Laravel
 * @param {function} naviguerVers - Fonction pour naviguer vers une section
 */
function Configuration({ naviguerVers }) {
  return (
    <div className="max-w-4xl mx-auto">
      <h2 className="text-3xl font-bold text-center text-blue-600 mb-8">⚙️ Configuration</h2>
      <p className="text-lg text-gray-700 mb-4">
        Maintenant que nous avons installé Algolia, configurons-le pour notre application Laravel!
      </p>
      <div className="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 mb-6 overflow-x-auto">
        <h3 className="text-xl font-bold text-gray-700 mb-3">📝 Étape 1: Configuration du fichier scout.php</h3>
        <p className="text-md text-gray-700 mb-2">Vérifie que ton fichier config/scout.php contient bien:</p>
        <pre className="bg-gray-800 text-green-400 p-4 rounded-md">
{`'driver' => env('SCOUT_DRIVER', 'algolia'),

'algolia' => [
    'id' => env('ALGOLIA_APP_ID', ''),
    'secret' => env('ALGOLIA_SECRET', ''),
],`}
        </pre>
      </div>
      <div className="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 mb-6">
        <h3 className="text-xl font-bold text-gray-700 mb-3">🧙‍♂️ Étape 2: Préparation de ton modèle</h3>
        <p className="text-md text-gray-700 mb-2">Ajoute le trait Searchable à ton modèle:</p>
        <pre className="bg-gray-800 text-green-400 p-4 rounded-md">
{`<?php

namespace App\\Models;

use Laravel\\Scout\\Searchable;
use Illuminate\\Database\\Eloquent\\Model;

class Produit extends Model
{
    use Searchable;
    
    // Le reste de ton modèle...
}`}
        </pre>
      </div>
      <div className="flex justify-between mt-8">
        <button 
          className="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('installation')}
        >
          ⬅️ Installation
        </button>
        <button 
          className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('indexation')}
        >
          Indexation ➡️
        </button>
      </div>
    </div>
  );
}

/**
 * Composant Indexation
 * Explique comment indexer des modèles avec Algolia
 * @param {function} naviguerVers - Fonction pour naviguer vers une section
 */
function Indexation({ naviguerVers }) {
  return (
    <div className="max-w-4xl mx-auto">
      <h2 className="text-3xl font-bold text-center text-blue-600 mb-8">📝 Indexation</h2>
      <p className="text-lg text-gray-700 mb-4">
        L'indexation est l'étape où nous envoyons nos données à Algolia pour qu'elles puissent être recherchées rapidement!
      </p>
      <div className="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 mb-6">
        <h3 className="text-xl font-bold text-gray-700 mb-3">🔮 Méthode toSearchableArray()</h3>
        <p className="text-md text-gray-700 mb-2">Personnalise les données à indexer:</p>
        <pre className="bg-gray-800 text-green-400 p-4 rounded-md">
{`/**
 * Get the indexable data array for the model.
 *
 * @return array
 */
public function toSearchableArray()
{
    $array = $this->toArray();
    
    // Personnalise les données à indexer
    return [
        'id' => $array['id'],
        'nom' => $array['nom'],
        'description' => $array['description'],
        'prix' => $array['prix'],
        'categorie' => $this->categorie->nom,
    ];
}`}
        </pre>
      </div>
      <div className="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 mb-6">
        <h3 className="text-xl font-bold text-gray-700 mb-3">🚀 Indexation des modèles</h3>
        <p className="text-md text-gray-700 mb-2">Pour indexer tous tes modèles existants:</p>
        <pre className="bg-gray-800 text-green-400 p-4 rounded-md">
          php artisan scout:import "App\\Models\\Produit"
        </pre>
        <p className="text-md text-gray-700 mt-4 mb-2">L'indexation automatique est activée par défaut pour les opérations create/update/delete!</p>
      </div>
      <div className="flex justify-between mt-8">
        <button 
          className="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('configuration')}
        >
          ⬅️ Configuration
        </button>
        <button 
          className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('recherche')}
        >
          Recherche ➡️
        </button>
      </div>
    </div>
  );
}

/**
 * Composant Recherche
 * Explique comment implémenter la recherche avec Algolia
 * @param {function} naviguerVers - Fonction pour naviguer vers une section
 */
function Recherche({ naviguerVers }) {
  return (
    <div className="max-w-4xl mx-auto">
      <h2 className="text-3xl font-bold text-center text-blue-600 mb-8">🔍 Recherche</h2>
      <p className="text-lg text-gray-700 mb-4">
        Maintenant que nos données sont indexées, voyons comment effectuer des recherches avec Algolia!
      </p>
      <div className="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 mb-6">
        <h3 className="text-xl font-bold text-gray-700 mb-3">🔎 Recherche de base</h3>
        <p className="text-md text-gray-700 mb-2">Dans ton contrôleur:</p>
        <pre className="bg-gray-800 text-green-400 p-4 rounded-md">
{`public function search(Request $request)
{
    $query = $request->input('query');
    
    // Recherche simple
    $resultats = Produit::search($query)->get();
    
    return view('resultats', ['resultats' => $resultats]);
}`}
        </pre>
      </div>
      <div className="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 mb-6">
        <h3 className="text-xl font-bold text-gray-700 mb-3">✨ Recherche avancée</h3>
        <p className="text-md text-gray-700 mb-2">Avec des filtres et de la pagination:</p>
        <pre className="bg-gray-800 text-green-400 p-4 rounded-md">
{`// Recherche avec filtres et pagination
$resultats = Produit::search($query)
    ->where('categorie', 'Électronique')
    ->where('prix', '>', 100)
    ->paginate(10);`}
        </pre>
      </div>
      <div className="flex justify-between mt-8">
        <button 
          className="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('indexation')}
        >
          ⬅️ Indexation
        </button>
        <button 
          className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('exemples')}
        >
          Exemples ➡️
        </button>
      </div>
    </div>
  );
}

/**
 * Composant Exemples
 * Présente des exemples pratiques d'utilisation d'Algolia avec Laravel
 * @param {function} naviguerVers - Fonction pour naviguer vers une section
 */
function Exemples({ naviguerVers }) {
  return (
    <div className="max-w-4xl mx-auto">
      <h2 className="text-3xl font-bold text-center text-blue-600 mb-8">🧪 Exemples pratiques</h2>
      <p className="text-lg text-gray-700 mb-4">
        Voici quelques exemples concrets d'utilisation d'Algolia avec Laravel!
      </p>
      <div className="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 mb-6">
        <h3 className="text-xl font-bold text-gray-700 mb-3">🛒 Exemple 1: Barre de recherche pour un e-commerce</h3>
        <p className="text-md text-gray-700 mb-2">Implémentation d'une recherche instantanée:</p>
        <pre className="bg-gray-800 text-green-400 p-4 rounded-md">
{`// routes/web.php
Route::get('/api/produits/search', [ProduitController::class, 'search']);

// ProduitController.php
public function search(Request $request)
{
    $query = $request->input('q');
    $resultats = Produit::search($query)->get();
    return response()->json($resultats);
}`}
        </pre>
      </div>
      <div className="bg-gray-50 rounded-lg p-6 border-2 border-gray-200 mb-6">
        <h3 className="text-xl font-bold text-gray-700 mb-3">📱 Exemple 2: API de recherche pour une application mobile</h3>
        <p className="text-md text-gray-700 mb-2">Création d'un endpoint API:</p>
        <pre className="bg-gray-800 text-green-400 p-4 rounded-md">
{`// routes/api.php
Route::get('/search', [SearchController::class, 'search']);

// SearchController.php
public function search(Request $request)
{
    $query = $request->input('q');
    $filters = $request->input('filters', []);
    
    $search = Produit::search($query);
    
    // Appliquer les filtres dynamiquement
    foreach ($filters as $key => $value) {
        $search->where($key, $value);
    }
    
    $resultats = $search->get();
    return response()->json($resultats);
}`}
        </pre>
      </div>
      <div className="flex justify-between mt-8">
        <button 
          className="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('recherche')}
        >
          ⬅️ Recherche
        </button>
        <button 
          className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('conclusion')}
        >
          Conclusion ➡️
        </button>
      </div>
    </div>
  );
}

/**
 * Composant Conclusion
 * Résume le cours et fournit des ressources supplémentaires
 * @param {function} naviguerVers - Fonction pour naviguer vers une section
 */
function Conclusion({ naviguerVers }) {
  return (
    <div className="max-w-4xl mx-auto">
      <h2 className="text-3xl font-bold text-center text-blue-600 mb-8">🎯 Conclusion</h2>
      <p className="text-lg text-gray-700 mb-4">
        Félicitations! Tu as maintenant toutes les connaissances nécessaires pour intégrer Algolia dans tes applications Laravel 12!
      </p>
      <p className="text-lg text-gray-700 mb-6">
        N'oublie pas que la magie d'Algolia est dans sa simplicité et sa puissance. Avec quelques lignes de code, tu peux offrir une expérience de recherche exceptionnelle à tes utilisateurs!
      </p>
      <div className="bg-blue-50 rounded-lg p-6 border-2 border-blue-200 mb-6">
        <h3 className="text-xl font-bold text-blue-600 mb-3">📚 Ressources supplémentaires</h3>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <a href="https://www.algolia.com/doc/" target="_blank" rel="noopener noreferrer" className="block p-4 bg-white rounded-lg border-2 border-blue-200 hover:bg-blue-50 transition-colors">
            <h4 className="text-lg font-bold text-blue-600 mb-2">📖 Documentation Algolia</h4>
            <p className="text-gray-700">La documentation officielle d'Algolia</p>
          </a>
          
          <a href="https://laravel.com/docs/12.x/scout" target="_blank" rel="noopener noreferrer" className="block p-4 bg-white rounded-lg border-2 border-red-200 hover:bg-red-50 transition-colors">
            <h4 className="text-lg font-bold text-red-600 mb-2">🔥 Documentation Laravel Scout</h4>
            <p className="text-gray-700">La documentation officielle de Laravel Scout</p>
          </a>
        </div>
      </div>
      <div className="flex justify-between mt-8">
        <button 
          className="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('exemples')}
        >
          ⬅️ Exemples
        </button>
        <button 
          className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition-all transform hover:scale-105 flex items-center" 
          onClick={() => naviguerVers('accueil')}
        >
          Retour à l'accueil 🏠
        </button>
      </div>
    </div>
  );
}

/**
 * Composant principal de l'application
 * Gère la navigation entre les différentes sections du cours sur l'intégration d'Algolia avec Laravel 12
 */
function App() {
  // État pour suivre la section active
  const [activeSection, setActiveSection] = useState('accueil');
  
  // Fonction pour naviguer entre les sections
  const naviguerVers = (section) => {
    setActiveSection(section);
    window.scrollTo(0, 0);
  };
  
  // Fonction pour rendre la section active
  const renderSection = () => {
    switch (activeSection) {
      case 'accueil':
        return <Accueil naviguerVers={naviguerVers} />;
      case 'introduction':
        return <Introduction naviguerVers={naviguerVers} />;
      case 'installation':
        return <Installation naviguerVers={naviguerVers} />;
      case 'configuration':
        return <Configuration naviguerVers={naviguerVers} />;
      case 'indexation':
        return <Indexation naviguerVers={naviguerVers} />;
      case 'recherche':
        return <Recherche naviguerVers={naviguerVers} />;
      case 'exemples':
        return <Exemples naviguerVers={naviguerVers} />;
      case 'conclusion':
        return <Conclusion naviguerVers={naviguerVers} />;
      default:
        return <Accueil naviguerVers={naviguerVers} />;
    }
  };
  
  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 py-8 px-4">
      {/* En-tête avec logo Algolia */}
      <header className="max-w-4xl mx-auto mb-8 flex flex-col items-center">
        <div className="flex items-center mb-4">
          <img 
            src="https://www.algolia.com/static-assets/images/infrastructure/algolia-mark-circle.svg" 
            alt="Logo Algolia" 
            className="w-12 h-12 mr-3"
          />
          <h1 className="text-4xl font-bold text-blue-600">
            Algolia + Laravel 12
          </h1>
        </div>
        <p className="text-lg text-gray-600 text-center">
          Apprends à ajouter une recherche magique à ton application Laravel! 
          <span className="inline-block animate-bounce ml-1">🧙‍♂️</span>
          <span className="inline-block ml-1">🔍</span>
        </p>
      </header>
      
      {/* Navigation */}
      <Navigation activeSection={activeSection} naviguerVers={naviguerVers} />
      
      {/* Contenu principal */}
      <main className="max-w-4xl mx-auto mt-8">
        {renderSection()}
      </main>
      
      {/* Pied de page */}
      <footer className="max-w-4xl mx-auto mt-12 pt-8 border-t border-gray-200 text-center text-gray-500">
        <p>Créé avec ❤️ pour les apprentis magiciens du code</p>
        <p className="mt-2">© 2025 École de Magie du Code</p>
      </footer>
    </div>
  );
}

export default App;
