@extends('admin.layout')

@section('titre', 'Détail licence')

@section('contenu')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap');

    .fld {
        --fld-ink: #10192B;
        --fld-canvas: #EFF2F5;
        --fld-card: #FFFFFF;
        --fld-line: #DFE4EA;
        --fld-accent: #2B6E5C;
        --fld-accent-soft: #E6F0EC;
        --fld-danger: #B8433C;
        --fld-danger-soft: #FBEDEC;
        --fld-amber: #B4791F;
        --fld-amber-soft: #FBF1E1;
        --fld-muted: #667085;

        max-width: 980px;
        margin: 0 auto;
        font-family: 'Inter', -apple-system, sans-serif;
        color: var(--fld-ink);
    }

    .fld .fld-retour {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--fld-muted);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 10px;
        transition: color .15s ease;
    }
    .fld .fld-retour:hover { color: var(--fld-ink); }

    .fld .fld-entete {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    .fld .fld-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--fld-accent);
        margin-bottom: 6px;
    }
    .fld .fld-eyebrow::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--fld-accent);
        display: inline-block;
    }

    .fld h1 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        font-size: 26px;
        letter-spacing: -0.01em;
        margin: 0 0 4px;
    }
    .fld .fld-sous-titre { color: var(--fld-muted); font-size: 13.5px; margin: 0; }

    .fld .fld-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 20px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11.5px;
        font-weight: 500;
        letter-spacing: .04em;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .fld .fld-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
    .fld .fld-badge--active { background: var(--fld-accent-soft); color: var(--fld-accent); }
    .fld .fld-badge--active::before { background: var(--fld-accent); }
    .fld .fld-badge--expiree { background: var(--fld-danger-soft); color: var(--fld-danger); }
    .fld .fld-badge--expiree::before { background: var(--fld-danger); }
    .fld .fld-badge--bloquee { background: var(--fld-amber-soft); color: var(--fld-amber); }
    .fld .fld-badge--bloquee::before { background: var(--fld-amber); }

    /* ---- Carte "dossier" générique ---- */
    .fld .fld-carte {
        position: relative;
        background: var(--fld-card);
        border: 1px solid var(--fld-line);
        border-radius: 14px;
        padding: 26px;
        box-shadow: 0 1px 2px rgba(16,25,43,.04), 0 8px 24px -12px rgba(16,25,43,.08);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .fld .fld-carte::after {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--fld-accent);
    }
    .fld .fld-carte-titre {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 15px;
        font-weight: 600;
        margin: 0 0 18px;
    }

    /* ---- Clé de licence ---- */
    .fld .fld-label {
        display: block;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--fld-muted);
        margin-bottom: 8px;
    }
    .fld .fld-cle-ligne {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: stretch;
    }
    .fld .fld-cle-boite {
        flex: 1;
        min-width: 220px;
        background: var(--fld-canvas);
        border: 1px dashed var(--fld-line);
        border-radius: 10px;
        padding: 13px 16px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 14px;
        letter-spacing: .03em;
        word-break: break-all;
        display: flex;
        align-items: center;
    }
    .fld .fld-btn-copier {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 20px;
        min-height: 46px;
        background: var(--fld-ink);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s ease, transform .1s ease;
    }
    .fld .fld-btn-copier:hover { background: var(--fld-accent); }
    .fld .fld-btn-copier:active { transform: scale(.98); }
    .fld .fld-btn-copier.fld-copie-ok { background: var(--fld-accent); }
    .fld .fld-btn-copier svg { width: 15px; height: 15px; }

    .fld hr { border: none; border-top: 1px dashed var(--fld-line); margin: 22px 0; }

    /* ---- Grille stats ---- */
    .fld .fld-stats {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
    }
    .fld .fld-stat {
        background: var(--fld-canvas);
        border: 1px solid var(--fld-line);
        border-radius: 10px;
        padding: 12px 14px;
    }
    .fld .fld-stat-label {
        display: block;
        font-size: 11px;
        color: var(--fld-muted);
        margin-bottom: 3px;
    }
    .fld .fld-stat-valeur {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 16px;
        font-weight: 600;
        color: var(--fld-ink);
    }
    .fld .fld-stat-valeur .fld-stat-sur {
        font-family: 'Inter', sans-serif;
        font-weight: 400;
        color: var(--fld-muted);
        font-size: 13px;
    }

    /* ---- Actions ---- */
    .fld .fld-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .fld .fld-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 42px;
        padding: 0 18px;
        border-radius: 9px;
        font-family: inherit;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid transparent;
        transition: background .15s ease, border-color .15s ease;
    }
    .fld .fld-btn--amber { background: var(--fld-amber-soft); color: var(--fld-amber); border-color: rgba(180,121,31,.25); }
    .fld .fld-btn--amber:hover { background: #F5E4C6; }
    .fld .fld-btn--accent { background: var(--fld-accent); color: #fff; }
    .fld .fld-btn--accent:hover { background: #235a4c; }
    .fld .fld-btn--danger { background: var(--fld-danger-soft); color: var(--fld-danger); border-color: rgba(184,67,60,.25); }
    .fld .fld-btn--danger:hover { background: #F6DEDC; }
    .fld .fld-btn svg { width: 14px; height: 14px; }

    /* ---- Table appareils ---- */
    .fld .fld-table-carte { padding: 0; }
    .fld .fld-table-tete {
        padding: 18px 22px;
        border-bottom: 1px dashed var(--fld-line);
    }
    .fld table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .fld thead th {
        text-align: left;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 10.5px;
        font-weight: 500;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--fld-muted);
        background: var(--fld-canvas);
        padding: 11px 22px;
        border-bottom: 1px solid var(--fld-line);
    }
    .fld tbody td {
        padding: 13px 22px;
        border-bottom: 1px solid var(--fld-line);
        color: var(--fld-ink);
        vertical-align: middle;
    }
    .fld tbody tr:last-child td { border-bottom: none; }
    .fld tbody tr:hover { background: #FAFBFC; }
    .fld .fld-id-machine {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11.5px;
        background: var(--fld-canvas);
        border: 1px solid var(--fld-line);
        padding: 3px 8px;
        border-radius: 6px;
        color: var(--fld-muted);
    }
    .fld .fld-vide {
        text-align: center;
        padding: 40px 20px;
        color: var(--fld-muted);
        font-size: 13.5px;
    }
    .fld .fld-btn-revoquer {
        padding: 6px 12px;
        font-size: 12px;
        min-height: 32px;
        background: var(--fld-danger-soft);
        color: var(--fld-danger);
        border: none;
        border-radius: 7px;
        font-family: inherit;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s ease;
    }
    .fld .fld-btn-revoquer:hover { background: #F6DEDC; }

    @media (max-width: 860px) {
        .fld .fld-stats { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .fld .fld-carte { padding: 18px; }
        .fld .fld-cle-ligne { flex-direction: column; }
        .fld .fld-actions { flex-direction: column-reverse; align-items: stretch; }
        .fld .fld-actions form,
        .fld .fld-actions .fld-btn { width: 100%; }
        .fld table, .fld thead, .fld tbody, .fld th, .fld td, .fld tr { display: block; }
        .fld thead { display: none; }
        .fld tbody tr { padding: 12px 16px; border-bottom: 1px solid var(--fld-line); }
        .fld tbody td { border: none; padding: 4px 0; }
        .fld tbody td::before {
            content: attr(data-label);
            display: block;
            font-size: 10.5px;
            color: var(--fld-muted);
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: 2px;
        }
    }
</style>

<div class="fld">

    <div class="fld-entete">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="fld-retour">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Retour à la liste
            </a>
            <div class="fld-eyebrow">Fiche licence</div>
            <h1>{{ $licence->entreprise->nom }}</h1>
            <p class="fld-sous-titre">Créée le {{ $licence->created_at->format('d/m/Y') }}</p>
        </div>

        @php
            $classesStatut = [
                'active' => 'fld-badge--active',
                'expiree' => 'fld-badge--expiree',
                'bloquee' => 'fld-badge--bloquee',
            ];
        @endphp
        <span class="fld-badge {{ $classesStatut[$licence->statut] ?? '' }}">
            {{ ucfirst($licence->statut) }}
        </span>
    </div>

    {{-- Carte principale --}}
    <div class="fld-carte">

        <span class="fld-label">Clé de licence</span>
        <div class="fld-cle-ligne">
            <div id="cle-{{ $licence->id }}" class="fld-cle-boite">{{ $licence->cle }}</div>
            <button type="button" onclick="copierCle('{{ $licence->id }}', this)" class="fld-btn-copier">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                <span class="btn-text">Copier la clé</span>
            </button>
        </div>

        <hr>

        <div class="fld-stats">
            <div class="fld-stat">
                <span class="fld-stat-label">Type</span>
                <span class="fld-stat-valeur">{{ ucfirst($licence->type) }}</span>
            </div>
            <div class="fld-stat">
                <span class="fld-stat-label">Début</span>
                <span class="fld-stat-valeur">{{ \Illuminate\Support\Carbon::parse($licence->date_debut)->format('d/m/Y') }}</span>
            </div>
            <div class="fld-stat">
                <span class="fld-stat-label">Expiration</span>
                <span class="fld-stat-valeur">{{ \Illuminate\Support\Carbon::parse($licence->date_expiration)->format('d/m/Y') }}</span>
            </div>
            <div class="fld-stat">
                <span class="fld-stat-label">Postes utilisés</span>
                <span class="fld-stat-valeur">{{ $licence->appareils->count() }} <span class="fld-stat-sur">/ {{ $licence->nombre_utilisateurs }}</span></span>
            </div>
            <div class="fld-stat">
                <span class="fld-stat-label">Véhicules max</span>
                <span class="fld-stat-valeur">{{ $licence->nombre_vehicules }}</span>
            </div>
        </div>

        <hr>

        <div class="fld-actions">
            <div>
                @if ($licence->statut !== 'expiree')
                    <form method="POST" action="{{ route('admin.licences.toggle', $licence) }}">
                        @csrf
                        <button type="submit" class="fld-btn {{ $licence->statut === 'bloquee' ? 'fld-btn--accent' : 'fld-btn--amber' }}">
                            @if ($licence->statut === 'bloquee')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>
                                Débloquer la licence
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Bloquer la licence
                            @endif
                        </button>
                    </form>
                @endif
            </div>

            <form method="POST"
                action="{{ route('admin.licences.destroy', $licence) }}"
                onsubmit="return confirm('⚠️ Cette action est irréversible.\n\nVoulez-vous vraiment supprimer cette licence ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="fld-btn fld-btn--danger">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>
                    Supprimer la licence
                </button>
            </form>
        </div>
    </div>

    {{-- Carte tableau : appareils --}}
    <div class="fld-carte fld-table-carte">
        <div class="fld-table-tete">
            <span class="fld-carte-titre" style="margin:0;">Appareils activés</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Machine</th>
                    <th>Identifiant</th>
                    <th>Dernière vérification</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($licence->appareils as $appareil)
                    <tr>
                        <td data-label="Machine"><strong>{{ $appareil->nom_machine ?? '—' }}</strong></td>
                        <td data-label="Identifiant"><span class="fld-id-machine">{{ $appareil->identifiant_machine }}</span></td>
                        <td data-label="Dernière vérification">{{ $appareil->derniere_verification?->format('d/m/Y H:i') ?? '—' }}</td>
                        <td data-label="Action" style="text-align:right;">
                            <form method="POST" action="{{ route('admin.appareils.revoquer', $appareil) }}" onsubmit="return confirm('Révoquer cet appareil ? Le poste sera libéré.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="fld-btn-revoquer">Révoquer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="fld-vide">Aucun appareil activé pour le moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection

@push('scripts')
<script>
function copierCle(id, btn) {
    const cle = document.getElementById('cle-' + id).innerText.trim();
    const btnText = btn.querySelector('.btn-text');

    navigator.clipboard.writeText(cle)
        .then(() => {
            if (btnText) {
                const texteOriginal = btnText.innerText;
                btnText.innerText = 'Copié !';
                btn.classList.add('fld-copie-ok');

                setTimeout(() => {
                    btnText.innerText = texteOriginal;
                    btn.classList.remove('fld-copie-ok');
                }, 2000);
            }
        })
        .catch(() => {
            alert('Impossible de copier la clé.');
        });
}
</script>
@endpush