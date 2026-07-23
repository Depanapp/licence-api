@extends('admin.layout')

@section('titre', 'Nouvelle entreprise')

@section('contenu')
<h1>Nouvelle entreprise</h1>
<p class="sous-titre">Créez l'entreprise avant de lui générer une licence.</p>

<div class="carte" style="max-width:560px;">
    @if ($errors->any())
        <div class="alerte-erreur">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.entreprises.store') }}">
        @csrf
        <label for="nom">Nom de l'entreprise</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required autofocus>

        <div class="grille-2">
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">
            </div>
            <div>
                <label for="telephone">Téléphone</label>
                <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}">
            </div>
        </div>

        <div class="grille-2">
            <div>
                <label for="pays">Pays</label>
                <input type="text" name="pays" id="pays" value="{{ old('pays') }}">
            </div>
            <div>
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}">
            </div>
        </div>

        <button type="submit" class="bouton" style="margin-top:20px;">Créer et continuer vers la licence</button>
    </form>
</div>
@endsection