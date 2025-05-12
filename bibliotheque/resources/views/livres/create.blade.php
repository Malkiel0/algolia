<!DOCTYPE html>
<html>
<head>
  <style>
    /* Styles généraux */
    body {
      background-color: #f5f5f5;
      font-family: 'Georgia', serif;
    }
    
    .book-container {
      position: relative;
      width: 900px;
      height: 600px;
      margin: 50px auto;
      perspective: 1200px;
    }
    
    .book {
      position: relative;
      transform-style: preserve-3d;
      transform: rotateY(-10deg);
      width: 100%;
      height: 100%;
      transition: transform 0.5s;
    }
    
    .book:hover {
      transform: rotateY(0deg);
    }
    
    .book-page {
      position: absolute;
      width: 450px;
      height: 100%;
      box-shadow: 0 15px 30px rgba(0,0,0,0.3);
      border-radius: 0 3px 3px 0;
      overflow: hidden;
      background: #fffef0;
      color: #333;
    }
    
    .page-left {
      left: 0;
      border-radius: 3px 0 0 3px;
      background: linear-gradient(to right, #fffef0 95%, #e1ddd2 100%);
      box-shadow: inset -10px 0 20px -10px rgba(0,0,0,0.2);
    }
    
    .page-right {
      right: 0;
      background: linear-gradient(to left, #fffef0 95%, #e1ddd2 100%);
      border-radius: 0 3px 3px 0;
      box-shadow: inset 10px 0 20px -10px rgba(0,0,0,0.2);
    }
    
    .page-content {
      padding: 40px;
      height: 100%;
      box-sizing: border-box;
      overflow-y: auto;
    }
    
    .book-spine {
      position: absolute;
      width: 40px;
      height: 600px;
      background: #a50000;
      left: 50%;
      top: 0;
      transform: translateX(-50%);
      z-index: -1;
      box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }
    
    /* Stylisation du titre */
    h1 {
      font-family: 'Georgia', serif;
      color: #5c1010;
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #8b0000;
      padding-bottom: 10px;
      font-size: 24px;
      letter-spacing: 1px;
    }
    
    /* Stylisation du formulaire */
    .form-label {
      font-family: 'Georgia', serif;
      color: #5c1010;
      font-weight: bold;
      margin-bottom: 5px;
      display: block;
    }
    
    .form-control {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #d1c8b9;
      background-color: #fffef8;
      border-radius: 0;
      font-family: 'Georgia', serif;
      box-sizing: border-box;
    }
    
    .form-control:focus {
      outline: none;
      border-color: #8b0000;
      box-shadow: 0 0 5px rgba(139, 0, 0, 0.3);
    }
    
    .invalid-feedback {
      color: #8b0000;
      font-size: 14px;
      margin-top: -10px;
      margin-bottom: 10px;
      font-style: italic;
    }
    
    textarea.form-control {
      min-height: 150px;
      line-height: 1.5;
      background-image: linear-gradient(#fffef8 49px, #d1c8b9 0px, #d1c8b9 50px, #fffef8 0px);
      background-size: 100% 50px;
      line-height: 50px;
      padding: 0 10px;
    }
    
    .btn {
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      font-family: 'Georgia', serif;
      transition: all 0.3s;
      margin-right: 10px;
    }
    
    .btn-primary {
      background-color: #8b0000;
      color: white;
    }
    
    .btn-primary:hover {
      background-color: #5c1010;
    }
    
    .btn-secondary {
      background-color: #d1c8b9;
      color: #333;
    }
    
    .btn-secondary:hover {
      background-color: #beae98;
    }
    
    /* Page de gauche - style décoratif */
    .left-page-decorative {
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    
    .book-icon {
      font-size: 60px;
      color: #8b0000;
      margin-bottom: 20px;
    }
    
    .quote {
      font-style: italic;
      text-align: center;
      padding: 20px;
      margin: 20px;
      border-top: 1px solid #d1c8b9;
      border-bottom: 1px solid #d1c8b9;
    }
  </style>
</head>
<body>
  @extends('layouts.app')

  @section('title', 'Ajouter un livre')

  @section('content')
  <div class="book-container">
    <div class="book-spine"></div>
    <div class="book">
      <div class="book-page page-left">
        <div class="page-content left-page-decorative">
          <div class="book-icon">📚</div>
          <h1>Ma Bibliothèque</h1>
          <div class="quote">
            "Un livre est un jardin que l'on peut mettre dans sa poche."
            <p>— Proverbe Arabe</p>
          </div>
          <p>Ajoutez votre prochain chef-d'œuvre et enrichissez votre collection...</p>
        </div>
      </div>
      
      <div class="book-page page-right">
        <div class="page-content">
          <h1>Ajouter un nouveau livre</h1>
      
          <form action="{{ route('livres.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
              <label for="titre" class="form-label">Titre</label>
              <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}">
              @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="mb-3">
              <label for="auteur" class="form-label">Auteur</label>
              <input type="text" class="form-control @error('auteur') is-invalid @enderror" id="auteur" name="auteur" value="{{ old('auteur') }}">
              @error('auteur')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="mb-3">
              <label for="annee_publication" class="form-label">Année de publication</label>
              <input type="number" class="form-control @error('annee_publication') is-invalid @enderror" id="annee_publication" name="annee_publication" value="{{ old('annee_publication') }}">
              @error('annee_publication')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="mb-3">
              <button type="submit" class="btn btn-primary">Enregistrer</button>
              <a href="{{ route('livres.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endsection
</body>
</html>