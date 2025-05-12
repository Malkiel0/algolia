{{--
    Composant Notification Digit All
    - Réutilisable partout dans le dashboard
    - Affiche un message animé (succès, info, erreur)
    - Props dynamiques : type, message
    - Design Digit All, clean code, commentaires détaillés
--}}

@props([
    'type' => 'success', // success | info | error
    'message' => 'Opération réussie !',
])

@php
    $colors = [
        'success' => 'bg-green-100 text-green-800 border-green-300',
        'info' => 'bg-blue-100 text-blue-800 border-blue-300',
        'error' => 'bg-red-100 text-red-800 border-red-300',
    ];
    $icons = [
        'success' => '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
        'info' => '<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01"/></svg>',
        'error' => '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>',
    ];
@endphp

<div class="flex items-center gap-3 px-4 py-3 border-l-4 rounded-lg shadow animate-fade-in {{ $colors[$type] }}" role="alert">
    {!! $icons[$type] !!}
    <span class="font-semibold">{{ $message }}</span>
</div>
