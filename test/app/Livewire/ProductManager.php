<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductManager extends Component
{

    // Propriétés publiques
    public $products;
    public $name;
    public $price;
    public $editingId = null;

    // Propriétés pour les formulaires

    // Initialisation
    public function mount()
    {
        $this->loadProducts();
    }

    // Chargement des produits
    public function loadProducts()
    {
        $this->products = Product::all();
    }

    // Ajout d'un produit
    public function addProduct()
    {
        $validated = $this->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric'
        ]);

        Product::create($validated);
        $this->resetInputs();
        $this->loadProducts();
    }

    // Édition d'un produit
    public function editProduct($id)
    {
        $product = Product::find($id);
        $this->name = $product->name;
        $this->price = $product->price;
        $this->editingId = $id;
    }

    // Mise à jour d'un produit
    public function updateProduct()
    {
        $validated = $this->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric'
        ]);

        Product::find($this->editingId)->update($validated);
        $this->resetInputs();
        $this->loadProducts();
    }

    // Suppression d'un produit
    public function deleteProduct($id)
    {
        Product::destroy($id);
        $this->loadProducts();
    }

    // Réinitialisation des champs
    public function resetInputs()
    {
        $this->name = '';
        $this->price = '';
        $this->editingId = null;
    }

    // Rendu de la vue
    public function render()
    {
        return view('livewire.product-manager');
    }
}
