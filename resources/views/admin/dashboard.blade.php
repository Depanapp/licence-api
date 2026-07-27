@extends('admin.layout')

@section('titre', 'Licences')

@section('contenu')
<style>
    /* En-tête réactif */
    .entete-page {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
    }

    /* Style du bouton de copie */
    .bouton-copie {
        background: transparent;
        border: 1px solid var(--bordure);
        border-radius: 6px;
        padding: 4px 8px;
        font-size: 11.5px;
        cursor: pointer;
        margin-left: 6px;
        transition: background 0.2s;
    }

    .bouton-copie:hover {
        background: #F4F4F1;
    }

    /* Styles spécifiques au mobile */
    @media (max-width: 768px) {
        .entete-page {
            flex-direction: column;
            align-items: flex-start;
        }

        .entete-page .bouton {
            width: 100%;
        }

        /* Adapte la cellule de la clé sur petit écran */
        .cellule-cle {
            display: flex;
            align-items: center;
            gap: 8px;
        }
    }
</style>

<div class="entete-page">
    <div>
        <h1>Licences</h1>
        <p class="sous-titre" style="margin-bottom: 0;">{{ $licences->count() }} licence(s) au total.</p>
    </div>
    <a href="{{ route('admin.entreprises.create') }}" class="bouton">+ Nouvelle licence</a>
</div>

<div class="carte" style="padding:0; overflow: hidden;">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Entreprise</th>
                    <th>Clé</th>
                    <th>Type</th>
                    <th>Expiration</th>
                    <th>Postes</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($licences as $licence)
                    <tr>
                        <td style="font-weight: 600;">{{ $licence->entreprise->nom }}</td>
                        <td>
                            <div class="cellule-cle">
                                <code id="cle-{{ $licence->id }}" style="font-family: monospace; background: #F4F4F1; padding: 2px 6px; border-radius: 4px;">{{ $licence->cle }}</code>
                                <button 
                                    type="button" 
                                    onclick="copierCle('{{ $licence->id }}', this)"
                                    class="bouton-copie">
                                    📋 Copier
                                </button>
                            </div>
                        </td>
                        <td>{{ ucfirst($licence->type) }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($licence->date_expiration)->format('d/m/Y') }}</td>
                        <td>{{ $licence->appareils->count() }} / {{ $licence->nombre_utilisateurs }}</td>
                        <td>
                            <span class="badge badge-{{ $licence->statut === 'active' ? 'active' : ($licence->statut === 'expiree' ? 'expiree' : 'bloquee') }}">
                                {{ ucfirst($licence->statut) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.licences.show', $licence) }}" style="color: var(--accent); text-decoration: none; font-weight: 600;">Voir</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; color:#9CA3AF; padding:24px;">
                            Aucune licence pour l'instant.
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
function copierCle(id, btn) {
    const cle = document.getElementById('cle-' + id).innerText;

    navigator.clipboard.writeText(cle)
        .then(() => {
            const texteOriginal = btn.innerText;
            btn.innerText = '✅ Copié !';
            setTimeout(() => {
                btn.innerText = texteOriginal;
            }, 2000);
        })
        .catch(() => {
            alert('Impossible de copier la clé.');
        });
}
</script>
@endpush