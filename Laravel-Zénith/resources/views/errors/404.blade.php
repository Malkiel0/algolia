{{-- Page 404 personnalisée Digit All --}}
{{-- Design unique, animation, bouton retour, clean code, commentaires détaillés --}}
@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh] animate-fade-in">
    {{-- Illustration SVG animée Digit All --}}
    <svg width="180" height="180" viewBox="0 0 180 180" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-8 animate-bounce">
        <circle cx="90" cy="90" r="80" fill="#FFA726" opacity="0.12"/>
        <circle cx="90" cy="90" r="60" fill="#1A1333" opacity="0.08"/>
        <text x="50%" y="54%" text-anchor="middle" fill="#FFA726" font-size="56" font-weight="bold" dy=".3em">404</text>
    </svg>
    <h1 class="text-4xl font-extrabold text-[#FFA726] mb-2">Oups ! Page introuvable</h1>
    <p class="text-[#1A1333] text-lg mb-6">La page que vous cherchez n'existe pas ou a été déplacée.<br>Revenez à l'accueil pour continuer votre expérience Digit All.</p>
    <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-[#FFA726] text-white font-bold rounded-lg shadow hover:bg-[#ff9800] transition-colors">Retour à l'accueil</a>
</div>
@endsection
