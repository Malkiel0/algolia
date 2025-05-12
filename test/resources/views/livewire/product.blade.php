<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <!-- Formulaire -->
    <div class="mb-8 p-4 border border-gray-200 rounded-lg">
        <h2 class="text-xl font-semibold mb-4">
            {{ $editingId ? 'Modifier Produit' : 'Ajouter Produit' }}
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Champ Nom -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                <input 
                    type="text" 
                    id="name" 
                    wire:model="name" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <!-- Champ Prix -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Prix</label>
                <input 
                    type="number" 
                    step="0.01" 
                    id="price" 
                    wire:model="price" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <!-- Boutons -->
        <div class="mt-4 flex justify-end space-x-2">
            @if($editingId)
                <button 
                    wire:click="updateProduct" 
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                >
                    Mettre à jour
                </button>
                <button 
                    wire:click="resetInputs" 
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600"
                >
                    Annuler
                </button>
            @else
                <button 
                    wire:click="addProduct" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                >
                    Ajouter
                </button>
            @endif
        </div>
    </div>
    
    <!-- Liste des produits -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($product->price, 2) }} €</td>
                        <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                            <button 
                                wire:click="editProduct({{ $product->id }})"
                                class="text-indigo-600 hover:text-indigo-900"
                            >
                                Éditer
                            </button>
                            <button 
                                wire:click="deleteProduct({{ $product->id }})"
                                class="text-red-600 hover:text-red-900"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit?')"
                            >
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            Aucun produit trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
