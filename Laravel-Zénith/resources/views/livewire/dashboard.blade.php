{{--
    Dashboard d'accueil Digit All
    - Widgets statistiques animés
    - Section graphique (placeholder)
    - Design moderne et dynamique
    - Palette Digit All : orange, bleu nuit, blanc
    - Code très commenté et structuré
--}}
<div class="space-y-8 animate-fade-in">
    {{-- Titre principal --}}
    <div class="flex items-center gap-4">
        <h2 class="text-2xl font-bold text-[#1A1333]">Tableau de bord</h2>
        <span class="px-3 py-1 rounded-full bg-[#FFA726]/20 text-[#FFA726] text-xs font-semibold animate-bounce">Bienvenue !</span>
    </div>

    {{-- Widgets statistiques --}}
    {{-- Exemple de notification de succès (réutilisable partout) --}}
<livewire:notification type="success" message="Bienvenue sur votre dashboard Digit All !" />

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Utilisateurs actifs --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start group hover:scale-105 transition-transform cursor-pointer">
            <span class="text-[#FFA726] text-3xl font-bold">1,245</span>
            <span class="text-[#1A1333] text-sm mt-2">Utilisateurs actifs</span>
        </div>
        {{-- Taux de conversion --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start group hover:scale-105 transition-transform cursor-pointer">
            <span class="text-[#FFA726] text-3xl font-bold">12.8%</span>
            <span class="text-[#1A1333] text-sm mt-2">Taux de conversion</span>
        </div>
        {{-- Revenus mensuels --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start group hover:scale-105 transition-transform cursor-pointer">
            <span class="text-[#FFA726] text-3xl font-bold">€9,800</span>
            <span class="text-[#1A1333] text-sm mt-2">Revenus mensuels</span>
        </div>
        {{-- Tickets support --}}
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start group hover:scale-105 transition-transform cursor-pointer">
            <span class="text-[#FFA726] text-3xl font-bold">37</span>
            <span class="text-[#1A1333] text-sm mt-2">Tickets support</span>
        </div>
    </div>

    {{-- Section graphique (placeholder) --}}
    <div class="bg-white rounded-xl shadow p-8 mt-6 flex flex-col items-center justify-center h-64">
        <span class="text-[#FFA726] text-lg font-bold mb-2">Graphique d'activité</span>
        <div class="w-full h-32 flex items-center justify-center bg-[#FFA726]/10 rounded animate-pulse">
            <span class="text-[#FFA726]">[Graphique à intégrer ici]</span>
        </div>
    </div>
</div>

{{--
    Astuce : Pour intégrer un vrai graphique, utiliser Livewire Charts, ApexCharts ou Chart.js côté JS.
--}}
