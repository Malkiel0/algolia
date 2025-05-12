{{--
    Header du dashboard Digit All
    - Affichage du nom de l'utilisateur (à remplacer par l'auth plus tard)
    - Avatar rond
    - Icône notification animée
    - Bouton de déconnexion stylisé
    - Palette Digit All : orange, bleu nuit, blanc
    - Code commenté et structuré
--}}
<div class="flex items-center w-full justify-between">
    {{-- Section gauche : titre ou breadcrumb --}}
    <div class="flex items-center gap-4">
        <h1 class="text-xl font-bold text-[#1A1333]">Bienvenue, <span class="text-[#FFA726]">DigitAll User</span></h1>
    </div>
    {{-- Section droite : actions utilisateur --}}
    <div class="flex items-center gap-6">
        {{-- Notification animée --}}
        <button class="relative focus:outline-none group">
            <svg class="w-7 h-7 text-[#FFA726] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="absolute top-1 right-1 block w-2 h-2 bg-[#FFA726] rounded-full animate-ping"></span>
        </button>
        {{-- Avatar utilisateur (factice) --}}
        <div class="flex items-center gap-2">
            <span class="w-10 h-10 rounded-full bg-[#FFA726]/20 flex items-center justify-center font-bold text-[#1A1333] shadow-inner">DA</span>
            <span class="text-sm text-[#1A1333] font-semibold">DigitAll User</span>
        </div>
        {{-- Bouton de déconnexion --}}
        <form method="POST" action="#" class="inline">
            @csrf
            <button type="submit" class="ml-2 px-4 py-2 bg-[#FFA726] text-white rounded-lg shadow hover:bg-[#ff9800] transition-colors font-semibold">Déconnexion</button>
        </form>
    </div>
</div>
