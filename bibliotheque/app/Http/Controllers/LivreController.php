<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Illuminate\Http\Request;

class LivreController extends Controller
{
     /**
     * Affiche la liste de tous les livres.
     */
    public function index()
    {
        // Récupère tous les livres de la base de données et les trie du plus récent au plus ancien
        $livres = Livre::orderBy('created_at', 'desc')->get();
        
        // Renvoie la vue 'livres.index' avec les livres
        return view('livres.index', compact('livres'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau livre.
     */
    public function create()
    {
        // Renvoie la vue avec le formulaire de création
        return view('livres.create');
    }

    /**
     * Enregistre un nouveau livre dans la base de données.
     */
    public function store(Request $request)
    {
        // Valide les données envoyées par le formulaire
        $validatedData = $request->validate([
            'titre' => 'required|max:255', // Le titre est obligatoire et max 255 caractères
            'auteur' => 'required|max:255', // L'auteur est obligatoire et max 255 caractères
            'annee_publication' => 'required|integer|min:1000|max:' . date('Y'), // Année valide
            'description' => 'nullable', // La description est optionnelle
        ]);
        
        // Crée un nouveau livre avec les données validées
        Livre::create($validatedData);
        
        // Redirige vers la liste des livres avec un message de succès
        return redirect()->route('livres.index')->with('success', 'Livre ajouté avec succès!');
    }

    /**
     * Affiche les détails d'un livre spécifique.
     */
    public function show(Livre $livre)
    {
        // Renvoie la vue avec les détails du livre
        return view('livres.show', compact('livre'));
    }

    /**
     * Affiche le formulaire pour modifier un livre existant.
     */
    public function edit(Livre $livre)
    {
        // Renvoie la vue avec le formulaire d'édition et les données du livre
        return view('livres.edit', compact('livre'));
    }

    /**
     * Met à jour un livre existant dans la base de données.
     */
    public function update(Request $request, Livre $livre)
    {
        // Valide les données envoyées par le formulaire
        $validatedData = $request->validate([
            'titre' => 'required|max:255',
            'auteur' => 'required|max:255',
            'annee_publication' => 'required|integer|min:1000|max:' . date('Y'),
            'description' => 'nullable',
        ]);
        
        // Met à jour le livre avec les données validées
        $livre->update($validatedData);
        
        // Redirige vers la liste des livres avec un message de succès
        return redirect()->route('livres.index')->with('success', 'Livre mis à jour avec succès!');
    }

    /**
     * Supprime un livre de la base de données.
     */
    public function destroy(Livre $livre)
    {
        // Supprime le livre
        $livre->delete();
        
        // Redirige vers la liste des livres avec un message de succès
        return redirect()->route('livres.index')->with('success', 'Livre supprimé avec succès!');
    }
}
