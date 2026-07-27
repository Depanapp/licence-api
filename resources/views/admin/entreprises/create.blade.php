@extends('admin.layout')

@section('titre', 'Nouvelle entreprise')

@section('contenu')
<style>
    .conteneur-formulaire {
        max-width: 560px;
        width: 100%;
    }

    form input, 
    form select {
        min-height: 44px;
        font-size: 15px !important;
    }

    @media (max-width: 768px) {
        .conteneur-formulaire {
            max-width: 100%;
        }

        .bouton-soumettre {
            width: 100%;
            padding: 12px;
            font-size: 15px;
        }
    }
</style>

<a href="{{ route('admin.dashboard') }}" style="color: var(--texte-secondaire); text-decoration: none; font-size: 13px;">← Retour au tableau de bord</a>
<h1 style="margin-top: 8px;">Créer une entreprise</h1>
<p class="sous-titre">Ajoutez les coordonnées de l'entreprise pour lui attribuer des licences.</p>

<div class="carte conteneur-formulaire">
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
        
        <div>
            <label for="nom">Nom de l'entreprise</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" placeholder="Ex: Transports Express S.A." required autofocus>
        </div>

        <div>
            <label for="email">Adresse e-mail de contact</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="contact@entreprise.com" required>
        </div>

        <div class="grille-2">
            <div>
                <label for="telephone">Téléphone</label>
                <input type="tel" name="telephone" id="telephone" value="{{ old('telephone') }}" placeholder="+33 1 23 45 67 89">
            </div>
            <div>
                <label for="ville">Ville / Localité</label>
                <input type="text" name="ville" id="ville" value="{{ old('ville') }}" placeholder="Paris">
            </div>
        </div>

        <div style="margin-top: 24px;">
            <button type="submit" class="bouton bouton-soumettre">Enregistrer l'entreprise</button>
        </div>
    </form>
</div>
@endsection