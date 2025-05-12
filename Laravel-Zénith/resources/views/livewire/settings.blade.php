{{--
    Page Paramètres Digit All
    - Section Profil utilisateur
    - Section Préférences
    - Design Digit All, animations, clean code
    - Commentaires détaillés
--}}
<div class="space-y-8 animate-fade-in">
    {{-- Titre de la page --}}
    <h2 class="text-2xl font-bold text-[#1A1333]">Paramètres</h2>

    {{-- Section Profil utilisateur --}}
    <div class="bg-white rounded-xl shadow p-6 animate-fade-in">
        <h3 class="text-lg font-bold text-[#FFA726] mb-2">Profil</h3>
        <div class="flex flex-col md:flex-row gap-4 items-center">
            <img src="https://ui-avatars.com/api/?name=DigitAll+User&background=FFA726&color=fff" class="w-16 h-16 rounded-full shadow" alt="Avatar utilisateur" />
            <div>
                <div class="font-semibold text-[#1A1333]">DigitAll User</div>
                <div class="text-sm text-[#FFA726]">admin@email.com</div>
            </div>
        </div>
    </div>

    {{-- Section Préférences --}}
    <div class="bg-white rounded-xl shadow p-6 animate-fade-in">
        <h3 class="text-lg font-bold text-[#FFA726] mb-2">Préférences</h3>
        <div class="flex flex-col gap-3">
            <label class="flex items-center gap-2">
                <input type="checkbox" checked class="accent-[#FFA726] rounded" />
                Recevoir les notifications par email
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" class="accent-[#FFA726] rounded" />
                Mode sombre (prochainement)
            </label>
        </div>
    </div>
</div>
