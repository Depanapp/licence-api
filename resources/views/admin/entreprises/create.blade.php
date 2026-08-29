@extends('admin.layout')

@section('titre', 'Nouvelle entreprise')

@section('contenu')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap');

    .fiche-entreprise {
        --fe-ink: #10192B;
        --fe-canvas: #EFF2F5;
        --fe-card: #FFFFFF;
        --fe-line: #DFE4EA;
        --fe-accent: #2B6E5C;
        --fe-accent-soft: #E6F0EC;
        --fe-danger: #B8433C;
        --fe-danger-soft: #FBEDEC;
        --fe-muted: #667085;

        max-width: 620px;
        width: 100%;
        font-family: 'Inter', -apple-system, sans-serif;
        color: var(--fe-ink);
    }

    .fiche-entreprise .fe-retour {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--fe-muted);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: color .15s ease;
    }
    .fiche-entreprise .fe-retour:hover { color: var(--fe-ink); }

    .fiche-entreprise .fe-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--fe-accent);
    }
    .fiche-entreprise .fe-eyebrow::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--fe-accent);
        display: inline-block;
    }

    .fiche-entreprise h1 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        font-size: 28px;
        letter-spacing: -0.01em;
        margin: 6px 0 4px;
        color: var(--fe-ink);
    }

    .fiche-entreprise .fe-sous-titre {
        color: var(--fe-muted);
        font-size: 14px;
        line-height: 1.5;
        margin: 0 0 28px;
        max-width: 46ch;
    }

    /* ---- Carte "dossier" ---- */
    .fiche-entreprise .fe-carte {
        position: relative;
        background: var(--fe-card);
        border: 1px solid var(--fe-line);
        border-radius: 14px;
        padding: 30px 28px 28px;
        box-shadow: 0 1px 2px rgba(16, 25, 43, 0.04), 0 8px 24px -12px rgba(16, 25, 43, 0.08);
        overflow: hidden;
    }

    /* coin plié façon chemise cartonnée */
    .fiche-entreprise .fe-carte::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 34px 34px 0;
        border-color: transparent var(--fe-canvas) transparent transparent;
    }
    .fiche-entreprise .fe-carte::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--fe-accent);
    }

    .fiche-entreprise .fe-carte-tete {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 22px;
        padding-bottom: 18px;
        border-bottom: 1px dashed var(--fe-line);
    }
    .fiche-entreprise .fe-carte-titre {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 15px;
        font-weight: 600;
    }
    .fiche-entreprise .fe-carte-ref {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        letter-spacing: .06em;
        color: var(--fe-muted);
        text-transform: uppercase;
    }

    @keyframes fe-apparition {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @media (prefers-reduced-motion: no-preference) {
        .fiche-entreprise .fe-carte {
            animation: fe-apparition .35s ease-out;
        }
    }

    /* ---- Erreurs ---- */
    .fiche-entreprise .fe-alerte {
        background: var(--fe-danger-soft);
        border: 1px solid rgba(184, 67, 60, 0.25);
        color: var(--fe-danger);
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 20px;
        font-size: 13px;
    }
    .fiche-entreprise .fe-alerte ul { margin: 0; padding-left: 18px; }
    .fiche-entreprise .fe-alerte li + li { margin-top: 2px; }

    /* ---- Champs ---- */
    .fiche-entreprise .fe-champ { margin-bottom: 18px; }
    .fiche-entreprise .fe-champ:last-of-type { margin-bottom: 0; }

    .fiche-entreprise label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: var(--fe-ink);
        margin-bottom: 6px;
    }
    .fiche-entreprise label .fe-optionnel {
        font-weight: 400;
        color: var(--fe-muted);
        text-transform: none;
        letter-spacing: 0;
    }

    .fiche-entreprise .fe-champ-icone {
        position: relative;
        display: flex;
        align-items: center;
    }
    .fiche-entreprise .fe-champ-icone svg {
        position: absolute;
        left: 13px;
        width: 16px;
        height: 16px;
        color: var(--fe-muted);
        pointer-events: none;
    }

    .fiche-entreprise input,
    .fiche-entreprise select {
        width: 100%;
        min-height: 44px;
        padding: 0 14px 0 38px;
        font-size: 14.5px;
        font-family: inherit;
        color: var(--fe-ink);
        background: var(--fe-canvas);
        border: 1px solid var(--fe-line);
        border-radius: 9px;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .fiche-entreprise input::placeholder { color: #9AA4B2; }
    .fiche-entreprise input:hover { border-color: #C6CDD6; }
    .fiche-entreprise input:focus,
    .fiche-entreprise select:focus {
        outline: none;
        background: #fff;
        border-color: var(--fe-accent);
        box-shadow: 0 0 0 3px var(--fe-accent-soft);
    }

    .fiche-entreprise .fe-grille-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .fiche-entreprise .fe-pied {
        margin-top: 26px;
        padding-top: 20px;
        border-top: 1px dashed var(--fe-line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .fiche-entreprise .fe-pied-note {
        font-size: 12.5px;
        color: var(--fe-muted);
        line-height: 1.4;
    }

    .fiche-entreprise .fe-bouton {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 44px;
        padding: 0 22px;
        background: var(--fe-ink);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        font-family: inherit;
        border: none;
        border-radius: 9px;
        cursor: pointer;
        transition: background .15s ease, transform .1s ease;
    }
    .fiche-entreprise .fe-bouton:hover { background: var(--fe-accent); }
    .fiche-entreprise .fe-bouton:active { transform: scale(0.98); }
    .fiche-entreprise .fe-bouton:focus-visible {
        outline: 2px solid var(--fe-accent);
        outline-offset: 2px;
    }

    @media (max-width: 640px) {
        .fiche-entreprise { max-width: 100%; }
        .fiche-entreprise .fe-carte { padding: 24px 18px; }
        .fiche-entreprise .fe-grille-2 { grid-template-columns: 1fr; gap: 18px; }
        .fiche-entreprise .fe-pied {
            flex-direction: column-reverse;
            align-items: stretch;
        }
        .fiche-entreprise .fe-bouton { width: 100%; justify-content: center; }
    }
</style>

<div class="fiche-entreprise">

    <a href="{{ route('admin.dashboard') }}" class="fe-retour">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Retour au tableau de bord
    </a>

    <div class="fe-eyebrow">Gestion des comptes</div>
    <h1>Créer une entreprise</h1>
    <p class="fe-sous-titre">Ajoutez les coordonnées de l'entreprise pour pouvoir lui attribuer des licences.</p>

    <div class="fe-carte">
        <div class="fe-carte-tete">
            <span class="fe-carte-titre">Fiche entreprise</span>
            <span class="fe-carte-ref">Dossier · Nouveau</span>
        </div>

        @if ($errors->any())
            <div class="fe-alerte">
                <ul>
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.entreprises.store') }}">
            @csrf

            <div class="fe-champ">
                <label for="nom">Nom de l'entreprise</label>
                <div class="fe-champ-icone">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M9 8h1m-1 4h1m-1 4h1m4-8h1m-1 4h1m-1 4h1M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>
                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" placeholder="Ex : Transports Express S.A." required autofocus>
                </div>
            </div>

            <div class="fe-champ">
                <label for="email">Adresse e-mail de contact</label>
                <div class="fe-champ-icone">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 7 9 6 9-6M5 5h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/></svg>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="contact@entreprise.com" required>
                </div>
            </div>

            <div class="fe-grille-2">
                <div class="fe-champ">
                    <label for="telephone">Téléphone <span class="fe-optionnel">(facultatif)</span></label>
                    <div class="fe-champ-icone">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <input type="tel" name="telephone" id="telephone" value="{{ old('telephone') }}" placeholder="+33 1 23 45 67 89">
                    </div>
                </div>
                <div class="fe-champ">
                    <label for="ville">Ville / Localité <span class="fe-optionnel">(facultatif)</span></label>
                    <div class="fe-champ-icone">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <input type="text" name="ville" id="ville" value="{{ old('ville') }}" placeholder="Paris">
                    </div>
                </div>
            </div>

            <div class="fe-pied">
                <p class="fe-pied-note">Ces informations pourront être modifiées plus tard depuis la fiche de l'entreprise.</p>
                <button type="submit" class="fe-bouton">
                    Enregistrer
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection