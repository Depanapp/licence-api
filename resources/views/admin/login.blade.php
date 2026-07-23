@extends('admin.layout')

@section('titre', 'Connexion')

@section('contenu')
<div style="max-width:380px; margin: 60px auto 0;">
    <div class="carte">
        <h1>Connexion admin</h1>
        <p class="sous-titre">Gestion des entreprises et des licences.</p>

        @if ($errors->any())
            <div class="alerte-erreur">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" class="bouton" style="width:100%; margin-top:20px;">Se connecter</button>
        </form>
    </div>
</div>
@endsection