@extends('admin.layout')

@section('titre', 'Licence ' . $licence->cle)

@section('contenu')
<style>
    .entete-page {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .grille-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .champ-cle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #F4F4F1;
        border: 1px solid var(--bordure);
        padding: 12px 16px;
        border-radius: 10px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .champ-cle code {
        font-family: 'SF Mono', Consolas, monospace;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 1px;
        word-break: break-all;
    }

    .liste-info {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .liste-info li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid var(--bordure);
        font-size: 13.5px;
    }

    .liste-info li:last-child {
        border-bottom: none;
    }

    .groupe-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .entete-page {
            flex-direction: column;
            align-items: flex-start;
        }

        .groupe-actions {
            width: 100%;
        }

        .groupe-actions .bouton, 
        .groupe-actions form {
            width: 100%;
        }

        .groupe-actions form button {
            width: 100%;
        }
    }
</style>

<div class="entete-page">
    <div>
        <a href="{{ route('admin.dashboard') }}" style="color: var(--texte-secondaire); text-decoration: none; font-size: 13px;">← Retour aux licences</a>
        <h1 style="margin-top: 6px;">Gestion de la licence</h1>
        <p class="sous-titre" style="margin-bottom:0;">Attribuée à <strong>{{ $licence->entreprise->nom }}</strong></p>
    </div>

    <div class="groupe-actions">
        @if($licence->statut === 'active')
            <form method="POST" action="{{ route('admin.licences.bloquer', $licence) }}">
                @csrf
                <button type="submit" class="bouton bouton-danger">Bloquer la licence</button>
            </form>
        @else
            <form method="POST" action="{{ route('admin.licences.activer', $licence) }}">
                @csrf
                <button type="submit" class="bouton">Activer la licence</button>
            </form>
        @endif
    </div>
</div>

<div class="carte">
    <label style="margin-top: 0;">Clé de licence</label>
    <div class="champ-cle">
        <code id="cle-licence">{{ $licence->cle }}</code>
        <button type="button" onclick="copierCle('cle-licence', this)" class="bouton bouton-secondaire" style="padding: 6px 12px; font-size: 12.5px;">
            📋 Copier la clé
        </button>
    </div>
</div>

<div class="grille-details">
    <div class="carte">
        <h3 style="margin-top: 0; font-size: 16px;">Informations générales</h3>
        <ul class="liste-info">
            <li>
                <span style="color: var(--texte-secondaire);">Statut</span>
                <span class="badge badge-{{ $licence->statut === 'active' ? 'active' : ($licence->statut === 'expiree' ? 'expiree' : 'bloquee') }}">
                    {{ ucfirst($licence->statut) }}
                </span>
            </li>
            <li>
                <span style="color: var(--texte-secondaire);">Type d'abonnement</span>
                <strong>{{ ucfirst($licence->type) }}</strong>
            </li>
            <li>
                <span style="color: var(--texte-secondaire);">Date de début</span>
                <span>{{ \Illuminate\Support\Carbon::parse($licence->date_debut)->format('d/m/Y') }}</span>
            </li>
            <li>
                <span style="color: var(--texte-secondaire);">Date d'expiration</span>
                <span>{{ \Illuminate\Support\Carbon::parse($licence->date_expiration)->format('d/m/Y') }}</span>
            </li>
        </ul>
    </div>

    <div class="carte">
        <h3 style="margin-top: 0; font-size: 16px;">Limites & Postes</h3>
        <ul class="liste-info">
            <li>
                <span style="color: var(--texte-secondaire);">Postes actifs</span>
                <strong>{{ $licence->appareils->count() }} / {{ $licence->nombre_utilisateurs }}</strong>
            </li>
            <li>
                <span style="color: var(--texte-secondaire);">Véhicules autorisés</span>
                <strong>{{ $licence->nombre_vehicules }}</strong>
            </li>
        </ul>
    </div>
</div>

<div class="carte" style="padding: 0;">
    <div style="padding: 16px 20px; border-bottom: 1px solid var(--bordure);">
        <h3 style="margin: 0; font-size: 16px;">Appareils / Postes enregistrés</h3>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nom de l'appareil</th>
                    <th>Identifiant unique</th>
                    <th>Dernière connexion</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($licence->appareils as $appareil)
                    <tr>
                        <td style="font-weight: 600;">{{ $appareil->nom ?? 'Appareil inconnu' }}</td>
                        <td><code>{{ $appareil->identifiant_unique }}</code></td>
                        <td>{{ $appareil->updated_at ? $appareil->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--texte-secondaire); padding: 24px;">
                            Aucun poste n'a encore été enregistré avec cette licence.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copierCle(idElement, btn) {
    const cle = document.getElementById(idElement).innerText;
    navigator.clipboard.writeText(cle).then(() => {
        const texteOriginal = btn.innerText;
        btn.innerText = '✅ Copié !';
        setTimeout(() => { btn.innerText = texteOriginal; }, 2000);
    });
}
</script>
@endpush