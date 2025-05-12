{{--
    Sidebar du dashboard Digit All
    - Logo en haut (remplacer le span par le SVG ou l'image du logo réel)
    - Menu de navigation animé (Accueil, Utilisateurs, Statistiques, Paramètres)
    - Palette Digit All : orange, bleu nuit, blanc
    - Code commenté et structuré
--}}
<div class="flex flex-col h-full">
    {{-- Logo Digit All --}}
    <div class="flex items-center justify-center h-24 border-b border-[#FFA726]/20">
        <span class="inline-block w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center">
            {{-- Remplacer ce span par le SVG ou l'image du logo Digit All --}}
            <span class="text-3xl font-bold text-[#FFA726]">DA</span>
        </span>
    </div>

    {{-- Menu de navigation --}}
    <nav class="flex-1 py-8 px-4 space-y-2">
        {{-- Lien Accueil --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all font-medium group {{ request()->routeIs('dashboard') ? 'bg-[#FFA726]/20 text-[#FFA726]' : 'hover:bg-[#FFA726]/20 hover:text-[#FFA726]' }}">
            <svg class="w-5 h-5 text-[#FFA726] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 0v6a2 2 0 002 2h6a2 2 0 002-2v-6a2 2 0 00-2-2h-6z"/></svg>
            Accueil
        </a>
        {{-- Lien Utilisateurs --}}
        <a href="{{ route('users') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all font-medium group {{ request()->routeIs('users') ? 'bg-[#FFA726]/20 text-[#FFA726]' : 'hover:bg-[#FFA726]/20 hover:text-[#FFA726]' }}">
            {{-- Icône utilisateurs --}}
            <svg class="w-5 h-5 text-[#FFA726] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2a4 4 0 10-8 0 4 4 0 008 0zm6 2a4 4 0 00-3-3.87"/></svg>
            Utilisateurs
        </a>
        {{-- Lien Statistiques --}}
        <a href="{{ route('stats') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all font-medium group {{ request()->routeIs('stats') ? 'bg-[#FFA726]/20 text-[#FFA726]' : 'hover:bg-[#FFA726]/20 hover:text-[#FFA726]' }}">
            {{-- Icône statistiques --}}
            <svg class="w-5 h-5 text-[#FFA726] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 17v-2a4 4 0 014-4h8a4 4 0 014 4v2" /><circle cx="12" cy="7" r="4" /></svg>
            Statistiques
        </a>
        {{-- Lien Paramètres --}}
        <a href="{{ route('settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all font-medium group {{ request()->routeIs('settings') ? 'bg-[#FFA726]/20 text-[#FFA726]' : 'hover:bg-[#FFA726]/20 hover:text-[#FFA726]' }}">
            {{-- Icône paramètres --}}
            <svg class="w-5 h-5 text-[#FFA726] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" /><circle cx="12" cy="12" r="10" /></svg>
            Paramètres
        </a>
    </nav>

    {{-- Footer ou version --}}
    <div class="py-4 text-xs text-center text-[#FFA726]/70">
        &copy; 2025 Digit All
    </div>
</div>
