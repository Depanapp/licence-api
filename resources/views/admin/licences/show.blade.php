@extends('admin.layout')

@section('titre', 'Détail licence')

@section('contenu')
<h1>{{ $licence->entreprise->nom }}</h1>
<p class="sous-titre">Licence créée le {{ $licence->created_at->format('d/m/Y') }}</p>

<div class="carte">
    <label style="margin-top:0;">Clé de licence</label>

    <div style="display:flex; align-items:center; gap:10px;">
        <div class="cle-licence" id="cle-{{ $licence->id }}">
            {{ $licence->cle }}
        </div>

        <button 
            type="button" 
            onclick="copierCle('{{ $licence->id }}')"
            class="bouton-copie">
            📋 Copier
        </button>
    </div>
    <div class="grille-2" style="margin-top:20px;">
        <div>
            <label style="margin-top:0;">Statut</label>
            <span class="badge badge-{{ $licence->statut === 'active' ? 'active' : ($licence->statut === 'expiree' ? 'expiree' : 'bloquee') }}">
                {{ ucfirst($licence->statut) }}
            </span>
        </div>
        <div>
            <label style="margin-top:0;">Type</label>
            {{ ucfirst($licence->type) }}
        </div>
    </div>

    <div class="grille-2">
        <div>
            <label>Début</label>
            {{ \Illuminate\Support\Carbon::parse($licence->date_debut)->format('d/m/Y') }}
        </div>
        <div>
            <label>Expiration</label>
            {{ \Illuminate\Support\Carbon::parse($licence->date_expiration)->format('d/m/Y') }}
        </div>
    </div>

    <div class="grille-2">
        <div>
            <label>Postes utilisés</label>
            {{ $licence->appareils->count() }} / {{ $licence->nombre_utilisateurs }}
        </div>
        <div>
            <label>Véhicules max</label>
            {{ $licence->nombre_vehicules }}
        </div>
    </div>

    @if ($licence->statut !== 'expiree')
        <form method="POST" action="{{ route('admin.licences.toggle', $licence) }}" style="margin-top:20px;">
            @csrf
            <button type="submit" class="bouton {{ $licence->statut === 'bloquee' ? '' : 'bouton-danger' }}">
                {{ $licence->statut === 'bloquee' ? 'Débloquer la licence' : 'Bloquer la licence' }}
            </button>
        </form>
    @endif

    <hr style="margin:25px 0; border:none; border-top:1px solid #E5E7EB;">
    <form method="POST"
        action="{{ route('admin.licences.destroy', $licence) }}"
        onsubmit="return confirm('⚠️ Cette action est irréversible.\n\nVoulez-vous vraiment supprimer cette licence ?');">

        @csrf
        @method('DELETE')

        <button type="submit" class="bouton bouton-danger">
            🗑 Supprimer la licence
        </button>
    </form>
</div>

<div class="carte" style="padding:0;">
    <div style="padding:20px 20px 0;">
        <h1 style="font-size:15px;">Appareils activés</h1>
    </div>
    <table>
        <thead>
            <tr>
                <th>Machine</th>
                <th>Identifiant</th>
                <th>Dernière vérification</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($licence->appareils as $appareil)
                <tr>
                    <td>{{ $appareil->nom_machine ?? '—' }}</td>
                    <td><code>{{ $appareil->identifiant_machine }}</code></td>
                    <td>{{ $appareil->derniere_verification?->format('d/m/Y H:i') ?? '—' }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.appareils.revoquer', $appareil) }}" onsubmit="return confirm('Révoquer cet appareil ? Le poste sera libéré.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bouton bouton-danger" style="padding:6px 12px; font-size:12px;">Révoquer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center; color:#9CA3AF; padding:20px;">Aucun appareil activé pour le moment.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<a href="{{ route('admin.dashboard') }}" class="bouton bouton-secondaire" style="margin-top:8px;">← Retour à la liste</a>
@endsection

@push('scripts')
<script>
function copierCle(id) {
    const cle = document.getElementById('cle-' + id).innerText;

    navigator.clipboard.writeText(cle)
        .then(() => {
            alert('Clé copiée !');
        })
        .catch(() => {
            alert('Impossible de copier la clé.');
        });
}
</script>