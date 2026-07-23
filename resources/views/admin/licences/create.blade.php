@extends('admin.layout')

@section('titre', 'Nouvelle licence')

@section('contenu')
<h1>Générer une licence</h1>
<p class="sous-titre">La clé est générée automatiquement à la création.</p>

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

    @if ($entreprises->isEmpty())
        <p>Aucune entreprise n'existe encore. <a href="{{ route('admin.entreprises.create') }}">Créez-en une d'abord</a>.</p>
    @else
        <form method="POST" action="{{ route('admin.licences.store') }}">
            @csrf
            <label for="entreprise_id">Entreprise</label>
            <select name="entreprise_id" id="entreprise_id" required>
                <option value="">— Choisir —</option>
                @foreach ($entreprises as $entreprise)
                    <option value="{{ $entreprise->id }}" @selected(old('entreprise_id', $entrepriseSelectionnee) == $entreprise->id)>
                        {{ $entreprise->nom }}
                    </option>
                @endforeach
            </select>

            <label for="type">Type</label>
            <select name="type" id="type">
                <option value="mensuelle" @selected(old('type') === 'mensuelle')>Mensuelle</option>
                <option value="annuelle" @selected(old('type', 'annuelle') === 'annuelle')>Annuelle</option>
                <option value="perpetuelle" @selected(old('type') === 'perpetuelle')>Perpétuelle</option>
            </select>

            <div class="grille-2">
                <div>
                    <label for="date_debut">Date de début</label>
                    <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut', now()->format('Y-m-d')) }}" required>
                </div>
                <div>
                    <label for="date_expiration">Date d'expiration</label>
                    <input type="date" name="date_expiration" id="date_expiration" value="{{ old('date_expiration', now()->addYear()->format('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="grille-2">
                <div>
                    <label for="nombre_utilisateurs">Postes autorisés</label>
                    <input type="number" name="nombre_utilisateurs" id="nombre_utilisateurs" min="1" value="{{ old('nombre_utilisateurs', 5) }}" required>
                </div>
                <div>
                    <label for="nombre_vehicules">Véhicules max</label>
                    <input type="number" name="nombre_vehicules" id="nombre_vehicules" min="1" value="{{ old('nombre_vehicules', 100) }}" required>
                </div>
            </div>

            <button type="submit" class="bouton" style="margin-top:20px;">Générer la licence</button>
        </form>
    @endif
</div>
@endsection