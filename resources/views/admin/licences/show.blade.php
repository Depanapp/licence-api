@extends('admin.layout')

@section('titre', 'Détail licence')

@section('contenu')
<div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

    {{-- En-tête avec bouton retour --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 mb-2 transition">
                ← Retour à la liste
            </a>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">{{ $licence->entreprise->nom }}</h1>
            <p class="text-sm text-gray-500">Licence créée le {{ $licence->created_at->format('d/m/Y') }}</p>
        </div>

        <div>
            @php
                $statutClasses = [
                    'active' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                    'expiree' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
                    'bloquee' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                ];
            @endphp
            <span class="inline-flex items-center rounded-md px-3 py-1 text-sm font-semibold ring-1 ring-inset {{ $statutClasses[$licence->statut] ?? 'bg-gray-50 text-gray-600' }}">
                {{ ucfirst($licence->statut) }}
            </span>
        </div>
    </div>

    {{-- Carte principale : Détails Licence --}}
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-xl p-5 sm:p-6 space-y-6">
        
        {{-- Section Clé de Licence --}}
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Clé de licence</label>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div id="cle-{{ $licence->id }}" class="flex-1 bg-gray-50 border border-gray-200 font-mono text-sm sm:text-base text-gray-800 rounded-lg p-3 break-all tracking-wide text-center sm:text-left">
                    {{ $licence->cle }}
                </div>
                <button 
                    type="button" 
                    onclick="copierCle('{{ $licence->id }}', this)"
                    class="inline-flex justify-center items-center gap-2 px-4 py-3 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition active:scale-[0.98]">
                    <span>📋</span> <span class="btn-text">Copier la clé</span>
                </button>
            </div>
        </div>

        <hr class="border-gray-100">

        {{-- Grille des données --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gray-50/50 p-3.5 rounded-lg border border-gray-100">
                <span class="block text-xs font-medium text-gray-500">Type</span>
                <span class="text-base font-semibold text-gray-900">{{ ucfirst($licence->type) }}</span>
            </div>

            <div class="bg-gray-50/50 p-3.5 rounded-lg border border-gray-100">
                <span class="block text-xs font-medium text-gray-500">Début</span>
                <span class="text-base font-semibold text-gray-900">{{ \Illuminate\Support\Carbon::parse($licence->date_debut)->format('d/m/Y') }}</span>
            </div>

            <div class="bg-gray-50/50 p-3.5 rounded-lg border border-gray-100">
                <span class="block text-xs font-medium text-gray-500">Expiration</span>
                <span class="text-base font-semibold text-gray-900">{{ \Illuminate\Support\Carbon::parse($licence->date_expiration)->format('d/m/Y') }}</span>
            </div>

            <div class="bg-gray-50/50 p-3.5 rounded-lg border border-gray-100">
                <span class="block text-xs font-medium text-gray-500">Postes utilisés</span>
                <span class="text-base font-semibold text-gray-900">{{ $licence->appareils->count() }} <span class="text-gray-400 font-normal">/ {{ $licence->nombre_utilisateurs }}</span></span>
            </div>
        </div>

        <div class="text-sm text-gray-600">
            <strong class="font-medium text-gray-900">Véhicules max :</strong> {{ $licence->nombre_vehicules }}
        </div>

        <hr class="border-gray-100">

        {{-- Actions Licence --}}
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-2">
            <div>
                @if ($licence->statut !== 'expiree')
                    <form method="POST" action="{{ route('admin.licences.toggle', $licence) }}">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2.5 rounded-lg text-sm font-medium transition border {{ $licence->statut === 'bloquee' ? 'bg-emerald-600 text-white hover:bg-emerald-700 border-transparent' : 'bg-amber-50 text-amber-700 hover:bg-amber-100 border-amber-200' }}">
                            {{ $licence->statut === 'bloquee' ? 'Débloquer la licence' : 'Bloquer la licence' }}
                        </button>
                    </form>
                @endif
            </div>

            <form method="POST"
                action="{{ route('admin.licences.destroy', $licence) }}"
                onsubmit="return confirm('⚠️ Cette action est irréversible.\n\nVoulez-vous vraiment supprimer cette licence ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-sm font-medium rounded-lg transition">
                    🗑 Supprimer la licence
                </button>
            </form>
        </div>

    </div>

    {{-- Carte tableau : Appareils activés --}}
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Appareils activés</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Machine</th>
                        <th class="px-5 py-3 font-semibold">Identifiant</th>
                        <th class="px-5 py-3 font-semibold">Dernière vérification</th>
                        <th class="px-5 py-3 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($licence->appareils as $appareil)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-5 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $appareil->nom_machine ?? '—' }}</td>
                            <td class="px-5 py-4 font-mono text-xs text-gray-500 whitespace-nowrap">
                                <span class="bg-gray-100 px-2 py-1 rounded">{{ $appareil->identifiant_machine }}</span>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-gray-500">{{ $appareil->derniere_verification?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <form method="POST" action="{{ route('admin.appareils.revoquer', $appareil) }}" onsubmit="return confirm('Révoquer cet appareil ? Le poste sera libéré.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 text-xs font-semibold rounded-md transition">
                                        Révoquer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-400">
                                Aucun appareil activé pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
                const textOriginal = btnText.innerText;
                btnText.innerText = 'Copié !';
                btn.classList.add('bg-emerald-700');
                
                setTimeout(() => {
                    btnText.innerText = textOriginal;
                    btn.classList.remove('bg-emerald-700');
                }, 2000);
            }
        })
        .catch(() => {
            alert('Impossible de copier la clé.');
        });
}
</script>
@endpush