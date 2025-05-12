{{--
    Page Utilisateurs Digit All
    - Tableau dynamique (nom, email, rôle, actions)
    - Barre de recherche, pagination
    - Design Digit All, animations, clean code
    - Commentaires détaillés pour chaque section
--}}
<div class="space-y-8 animate-fade-in">
    {{-- Titre et barre de recherche --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h2 class="text-2xl font-bold text-[#1A1333]">Utilisateurs</h2>
        <input type="text" placeholder="Rechercher un utilisateur..." class="px-4 py-2 rounded-lg border border-[#FFA726]/30 focus:ring-2 focus:ring-[#FFA726] focus:outline-none transition w-full md:w-72" />
    </div>

    {{-- Tableau utilisateurs --}}
    <div class="overflow-x-auto rounded-xl shadow bg-white">
        <table class="min-w-full divide-y divide-[#FFA726]/20">
            <thead class="bg-[#FFA726]/10">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-[#FFA726] uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-[#FFA726] uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-[#FFA726] uppercase tracking-wider">Rôle</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-[#FFA726] uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#FFA726]/10">
                {{-- Exemple de données statiques, à remplacer par une boucle Livewire plus tard --}}
                <tr class="hover:bg-[#FFA726]/5 transition">
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-[#1A1333]">Jean Dupont</td>
                    <td class="px-6 py-4 whitespace-nowrap">jean.dupont@email.com</td>
                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 rounded-full bg-[#FFA726]/20 text-[#FFA726] text-xs font-bold">Admin</span></td>
                    <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                        <button class="px-3 py-1 bg-[#FFA726] text-white rounded-lg shadow hover:bg-[#ff9800] transition-colors text-xs font-bold">Éditer</button>
                        <button class="px-3 py-1 bg-red-500 text-white rounded-lg shadow hover:bg-red-700 transition-colors text-xs font-bold">Supprimer</button>
                    </td>
                </tr>
                <tr class="hover:bg-[#FFA726]/5 transition">
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-[#1A1333]">Sarah Martin</td>
                    <td class="px-6 py-4 whitespace-nowrap">sarah.martin@email.com</td>
                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 py-1 rounded-full bg-[#FFA726]/20 text-[#FFA726] text-xs font-bold">Client</span></td>
                    <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                        <button class="px-3 py-1 bg-[#FFA726] text-white rounded-lg shadow hover:bg-[#ff9800] transition-colors text-xs font-bold">Éditer</button>
                        <button class="px-3 py-1 bg-red-500 text-white rounded-lg shadow hover:bg-red-700 transition-colors text-xs font-bold">Supprimer</button>
                    </td>
                </tr>
                {{-- Ajouter ici une boucle Livewire pour afficher les vrais utilisateurs --}}
            </tbody>
        </table>
    </div>

    {{-- Pagination (statique pour l'exemple) --}}
    <div class="flex justify-end pt-4">
        <nav class="inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            <a href="#" class="px-3 py-2 rounded-l-md border border-[#FFA726]/20 bg-white text-[#1A1333] hover:bg-[#FFA726]/10">&laquo;</a>
            <a href="#" class="px-3 py-2 border-t border-b border-[#FFA726]/20 bg-[#FFA726]/20 text-[#FFA726] font-bold">1</a>
            <a href="#" class="px-3 py-2 border border-[#FFA726]/20 bg-white text-[#1A1333] hover:bg-[#FFA726]/10">2</a>
            <a href="#" class="px-3 py-2 rounded-r-md border border-[#FFA726]/20 bg-white text-[#1A1333] hover:bg-[#FFA726]/10">&raquo;</a>
        </nav>
    </div>
</div>
