@extends('layouts.app')

@section('title', $livre->titre)

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>{{ $livre->titre }}</h1>
            <div>
                <a href="{{ route('livres.edit', $livre->id) }}" class="btn btn-warning">Modifier</a>
                <a href="{{ route('livres.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
        <div class="card-body">
            <h5>Auteur: {{ $livre->auteur }}</h5>
            <p>Année de publication: {{ $livre->annee_publication }}</p>
            
            <h5 class="mt-4">Description:</h5>
            <p>{{ $livre->description ?: 'Aucune description disponible.' }}</p>
            
            <div class="mt-4">
                <small class="text-muted">Créé le: {{ $livre->created_at->format('d/m/Y H:i') }}</small><br>
                <small class="text-muted">Dernière mise à jour: {{ $livre->updated_at->format('d/m/Y H:i') }}</small>
            </div>
        </div>
    </div>
@endsection