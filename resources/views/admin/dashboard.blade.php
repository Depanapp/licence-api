@extends('admin.layout')

@section('titre', 'Licences')

@section('contenu')
<div style="display:flex; align-items:center; justify-content:space-between;">
    <div>
        <h1>Licences</h1>
        <p class="sous-titre">{{ $licences->count() }} licence(s) au total.</p>
    </div>
    <a href="{{ route('admin.entreprises.create') }}" class="bouton">+ Nouvelle licence</a>
</div>

<div class="carte" style="padding:0;">
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
                    <td>{{ $licence->entreprise->nom }}</td>
                    <td>
                        <code id="cle-{{ $licence->id }}">{{ $licence->cle }}</code>
                        <button 
                            type="button" 
                            onclick="copierCle('{{ $licence->id }}')"
                            class="bouton-copie">
                            📋 Copier
                        </button>
                    </td>
                    <td>{{ ucfirst($licence->type) }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($licence->date_expiration)->format('d/m/Y') }}</td>
                    <td>{{ $licence->appareils->count() }} / {{ $licence->nombre_utilisateurs }}</td>
                    <td>
                        <span class="badge badge-{{ $licence->statut === 'active' ? 'active' : ($licence->statut === 'expiree' ? 'expiree' : 'bloquee') }}">
                            {{ ucfirst($licence->statut) }}
                        </span>
                    </td>
                    <td><a href="{{ route('admin.licences.show', $licence) }}">Voir</a></td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center; color:#9CA3AF; padding:24px;">Aucune licence pour l'instant.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
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
@endpush
@endsection

