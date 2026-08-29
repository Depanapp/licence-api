@extends('admin.layout')

@section('titre', 'Nouvelle licence')

@section('contenu')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap');

    .fiche-licence {
        --fl-ink: #10192B;
        --fl-canvas: #EFF2F5;
        --fl-card: #FFFFFF;
        --fl-line: #DFE4EA;
        --fl-accent: #2B6E5C;
        --fl-accent-soft: #E6F0EC;
        --fl-danger: #B8433C;
        --fl-danger-soft: #FBEDEC;
        --fl-muted: #667085;

        max-width: 620px;
        width: 100%;
        font-family: 'Inter', -apple-system, sans-serif;
        color: var(--fl-ink);
    }

    .fiche-licence .fl-retour {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--fl-muted);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: color .15s ease;
    }
    .fiche-licence .fl-retour:hover { color: var(--fl-ink); }

    .fiche-licence .fl-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--fl-accent);
    }
    .fiche-licence .fl-eyebrow::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--fl-accent);
        display: inline-block;
    }

    .fiche-licence h1 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        font-size: 28px;
        letter-spacing: -0.01em;
        margin: 6px 0 4px;
    }

    .fiche-licence .fl-sous-titre {
        color: var(--fl-muted);
        font-size: 14px;
        line-height: 1.5;
        margin: 0 0 28px;
        max-width: 46ch;
    }

    /* ---- Carte "dossier" ---- */
    .fiche-licence .fl-carte {
        position: relative;
        background: var(--fl-card);
        border: 1px solid var(--fl-line);
        border-radius: 14px;
        padding: 30px 28px 28px;
        box-shadow: 0 1px 2px rgba(16, 25, 43, 0.04), 0 8px 24px -12px rgba(16, 25, 43, 0.08);
        overflow: hidden;
    }
    .fiche-licence .fl-carte::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 0; height: 0;
        border-style: solid;
        border-width: 0 34px 34px 0;
        border-color: transparent var(--fl-canvas) transparent transparent;
    }
    .fiche-licence .fl-carte::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--fl-accent);
    }

    .fiche-licence .fl-carte-tete {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 22px;
        padding-bottom: 18px;
        border-bottom: 1px dashed var(--fl-line);
    }
    .fiche-licence .fl-carte-titre {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 15px;
        font-weight: 600;
    }
    .fiche-licence .fl-carte-ref {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        letter-spacing: .06em;
        color: var(--fl-muted);
        text-transform: uppercase;
    }

    @keyframes fl-apparition {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @media (prefers-reduced-motion: no-preference) {
        .fiche-licence .fl-carte { animation: fl-apparition .35s ease-out; }
    }

    /* ---- Erreurs ---- */
    .fiche-licence .fl-alerte {
        background: var(--fl-danger-soft);
        border: 1px solid rgba(184, 67, 60, 0.25);
        color: var(--fl-danger);
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 20px;
        font-size: 13px;
    }
    .fiche-licence .fl-alerte ul { margin: 0; padding-left: 18px; }
    .fiche-licence .fl-alerte li + li { margin-top: 2px; }

    /* ---- Etat vide ---- */
    .fiche-licence .fl-vide {
        text-align: center;
        padding: 28px 16px;
    }
    .fiche-licence .fl-vide svg {
        width: 34px; height: 34px;
        color: var(--fl-muted);
        margin-bottom: 12px;
    }
    .fiche-licence .fl-vide p {
        color: var(--fl-muted);
        font-size: 14px;
        margin: 0 0 18px;
    }
    .fiche-licence .fl-vide a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 40px;
        padding: 0 18px;
        background: var(--fl-ink);
        color: #fff;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 9px;
        transition: background .15s ease;
    }
    .fiche-licence .fl-vide a:hover { background: var(--fl-accent); }

    /* ---- Champs ---- */
    .fiche-licence .fl-champ { margin-bottom: 18px; }
    .fiche-licence .fl-champ:last-of-type { margin-bottom: 0; }

    .fiche-licence label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .fiche-licence .fl-champ-icone { position: relative; display: flex; align-items: center; }
    .fiche-licence .fl-champ-icone svg.fl-icone-gauche {
        position: absolute; left: 13px;
        width: 16px; height: 16px;
        color: var(--fl-muted);
        pointer-events: none;
    }
    .fiche-licence .fl-champ-icone svg.fl-icone-droite {
        position: absolute; right: 13px;
        width: 14px; height: 14px;
        color: var(--fl-muted);
        pointer-events: none;
    }

    .fiche-licence input,
    .fiche-licence select {
        width: 100%;
        min-height: 44px;
        padding: 0 14px 0 38px;
        font-size: 14.5px;
        font-family: inherit;
        color: var(--fl-ink);
        background: var(--fl-canvas);
        border: 1px solid var(--fl-line);
        border-radius: 9px;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .fiche-licence select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 36px;
        cursor: pointer;
    }
    .fiche-licence input:hover,
    .fiche-licence select:hover { border-color: #C6CDD6; }
    .fiche-licence input:focus,
    .fiche-licence select:focus {
        outline: none;
        background: #fff;
        border-color: var(--fl-accent);
        box-shadow: 0 0 0 3px var(--fl-accent-soft);
    }

    .fiche-licence .fl-grille-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .fiche-licence .fl-note-cle {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-top: 22px;
        padding: 12px 14px;
        background: var(--fl-canvas);
        border: 1px dashed var(--fl-line);
        border-radius: 10px;
        font-size: 12.5px;
        color: var(--fl-muted);
        line-height: 1.5;
    }
    .fiche-licence .fl-note-cle svg { width: 15px; height: 15px; flex-shrink: 0; margin-top: 1px; color: var(--fl-accent); }
    .fiche-licence .fl-note-cle strong { color: var(--fl-ink); font-weight: 600; }

    .fiche-licence .fl-bouton {
        margin-top: 20px;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 46px;
        background: var(--fl-ink);
        color: #fff;
        font-size: 14.5px;
        font-weight: 600;
        font-family: inherit;
        border: none;
        border-radius: 9px;
        cursor: pointer;
        transition: background .15s ease, transform .1s ease;
    }
    .fiche-licence .fl-bouton:hover { background: var(--fl-accent); }
    .fiche-licence .fl-bouton:active { transform: scale(0.99); }
    .fiche-licence .fl-bouton:focus-visible { outline: 2px solid var(--fl-accent); outline-offset: 2px; }

    @media (max-width: 640px) {
        .fiche-licence .fl-carte { padding: 24px 18px; }
        .fiche-licence .fl-grille-2 { grid-template-columns: 1fr; gap: 18px; }
    }
</style>

<div class="fiche-licence">

    <a href="{{ route('admin.dashboard') }}" class="fl-retour">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Retour au tableau de bord
    </a>

    <div class="fl-eyebrow">Gestion des licences</div>
    <h1>Générer une licence</h1>
    <p class="fl-sous-titre">La clé est générée automatiquement à la création.</p>

    <div class="fl-carte">
        <div class="fl-carte-tete">
            <span class="fl-carte-titre">Fiche licence</span>
            <span class="fl-carte-ref">Dossier · Nouvelle</span>
        </div>

        @if ($errors->any())
            <div class="fl-alerte">
                <ul>
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($entreprises->isEmpty())
            <div class="fl-vide">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 21h18M9 8h1m-1 4h1m-1 4h1m4-8h1m-1 4h1m-1 4h1M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>
                <p>Aucune entreprise n'existe encore.<br>Créez-en une avant de générer une licence.</p>
                <a href="{{ route('admin.entreprises.create') }}">
                    Créer une entreprise
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                </a>
            </div>
        @else
            <form method="POST" action="{{ route('admin.licences.store') }}">
                @csrf

                <div class="fl-champ">
                    <label for="entreprise_id">Entreprise</label>
                    <div class="fl-champ-icone">
                        <svg class="fl-icone-gauche" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M9 8h1m-1 4h1m-1 4h1m4-8h1m-1 4h1m-1 4h1M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>
                        <select name="entreprise_id" id="entreprise_id" required>
                            <option value="">— Choisir —</option>
                            @foreach ($entreprises as $entreprise)
                                <option value="{{ $entreprise->id }}" @selected(old('entreprise_id', $entrepriseSelectionnee) == $entreprise->id)>
                                    {{ $entreprise->nom }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="fl-icone-droite" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                </div>

                <div class="fl-champ">
                    <label for="type">Type de licence</label>
                    <div class="fl-champ-icone">
                        <svg class="fl-icone-gauche" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M2 12h20"/></svg>
                        <select name="type" id="type">
                            <option value="mensuelle" @selected(old('type') === 'mensuelle')>Mensuelle</option>
                            <option value="annuelle" @selected(old('type', 'annuelle') === 'annuelle')>Annuelle</option>
                            <option value="perpetuelle" @selected(old('type') === 'perpetuelle')>Perpétuelle</option>
                        </select>
                        <svg class="fl-icone-droite" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                    </div>
                </div>

                <div class="fl-grille-2">
                    <div class="fl-champ">
                        <label for="date_debut">Date de début</label>
                        <div class="fl-champ-icone">
                            <svg class="fl-icone-gauche" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                            <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut', now()->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="fl-champ">
                        <label for="date_expiration">Date d'expiration</label>
                        <div class="fl-champ-icone">
                            <svg class="fl-icone-gauche" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                            <input type="date" name="date_expiration" id="date_expiration" value="{{ old('date_expiration', now()->addYear()->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                </div>

                <div class="fl-grille-2">
                    <div class="fl-champ">
                        <label for="nombre_utilisateurs">Postes autorisés</label>
                        <div class="fl-champ-icone">
                            <svg class="fl-icone-gauche" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <input type="number" name="nombre_utilisateurs" id="nombre_utilisateurs" min="1" value="{{ old('nombre_utilisateurs', 5) }}" required>
                        </div>
                    </div>
                    <div class="fl-champ">
                        <label for="nombre_vehicules">Véhicules max</label>
                        <div class="fl-champ-icone">
                            <svg class="fl-icone-gauche" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg>
                            <input type="number" name="nombre_vehicules" id="nombre_vehicules" min="1" value="{{ old('nombre_vehicules', 100) }}" required>
                        </div>
                    </div>
                </div>

                <div class="fl-note-cle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0 3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                    <span><strong>Clé générée automatiquement.</strong> Vous n'avez rien à saisir ici : elle sera visible sur la fiche de la licence une fois créée.</span>
                </div>

                <button type="submit" class="fl-bouton">
                    Générer la licence
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                </button>
            </form>
        @endif
    </div>
</div>
@endsection