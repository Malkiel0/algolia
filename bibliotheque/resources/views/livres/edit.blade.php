@extends('layouts.app')

@section('title', 'Modifier ' . $livre->titre)

@section('content')
    <h1>Modifier le livre: {{ $livre->titre }}</h1>

    <form action="{{ route('livres.update', $livre->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre', $livre->titre) }}">
            @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="auteur" class="form-label">Auteur</label>
            <input type="text" class="form-control @error('auteur') is-invalid @enderror" id="auteur" name="auteur" value="{{ old('auteur', $livre->auteur) }}">
            @error('auteur')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="annee_publication" class="form-label">Année de publication</label>
            <input type="number" class="form-control @error('annee_publication') is-invalid @enderror" id="annee_publication" name="annee_publication" value="{{ old('annee_publication', $livre->annee_publication) }}">
            @error('annee_publication')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $livre->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('livres.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
@endsection