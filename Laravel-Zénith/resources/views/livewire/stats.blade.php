{{--
    Page Statistiques Digit All
    - Graphique principal (placeholder)
    - KPIs (widgets)
    - Design Digit All, animations, clean code
    - Commentaires détaillés
--}}
<div class="space-y-8 animate-fade-in">
    {{-- Titre de la page --}}
    <h2 class="text-2xl font-bold text-[#1A1333]">Statistiques</h2>

    {{-- KPIs --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center animate-fade-in">
            <span class="text-3xl font-bold text-[#FFA726]">1 245</span>
            <span class="text-sm text-[#1A1333]">Visiteurs ce mois</span>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center animate-fade-in">
            <span class="text-3xl font-bold text-[#FFA726]">98%</span>
            <span class="text-sm text-[#1A1333]">Satisfaction clients</span>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center animate-fade-in">
            <span class="text-3xl font-bold text-[#FFA726]">325</span>
            <span class="text-sm text-[#1A1333]">Commandes</span>
        </div>
    </div>

    {{-- Graphique principal (placeholder) --}}
    <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center justify-center min-h-[340px] animate-fade-in">
        <span class="text-[#FFA726] font-bold text-lg mb-4">Graphique d'évolution (prochainement)</span>
        <svg width="200" height="100" class="opacity-40">
            <rect x="10" y="40" width="30" height="50" fill="#FFA726" />
            <rect x="50" y="20" width="30" height="70" fill="#1A1333" />
            <rect x="90" y="60" width="30" height="30" fill="#FFA726" />
            <rect x="130" y="30" width="30" height="60" fill="#1A1333" />
        </svg>
    </div>
</div>
