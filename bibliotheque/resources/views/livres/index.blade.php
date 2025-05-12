@extends('layouts.app')

@section('title', 'Liste des livres')

@section('content')
    <div class="row mb-3">
        <div class="col">
            <h1>Liste des livres</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('livres.create') }}" class="btn btn-primary">Ajouter un livre</a>
        </div>
    </div>

    @if($livres->isEmpty())
        <div class="alert alert-info">
            Aucun livre n'est disponible pour le moment.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Année</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($livres as $livre)
                        <tr>
                            <td>{{ $livre->titre }}</td>
                            <td>{{ $livre->auteur }}</td>
                            <td>{{ $livre->annee_publication }}</td>
                            <td>
                                <a href="{{ route('livres.show', $livre->id) }}" class="btn btn-sm btn-info">Voir</a>
                                <a href="{{ route('livres.edit', $livre->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('livres.destroy', $livre->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection