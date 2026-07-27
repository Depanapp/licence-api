@extends('admin.layout')

@section('titre', 'Licences')

@section('contenu')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- En-tête de page --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Licences</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $licences->count() }} licence(s) au total.</p>
        </div>
        <div>
            <a href="{{ route('admin.entreprises.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition active:scale-[0.98] w-full sm:w-auto shadow-sm">
                <span>+</span> Nouvelle licence
            </a>
        </div>
    </div>

    @php
        $statutClasses = [
            'active' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
            'expiree' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
            'bloquee' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        ];
    @endphp

    {{-- VUE MOBILE : Cartes (masqué sur desktop) --}}
    <div class="block md:hidden space-y-4">
        @forelse ($licences as $licence)
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-xl p-5 space-y-4">
                <div class="flex items-start justify-between gap-2 border-b border-gray-100 pb-3">
                    <div>
                        <h2 class="font-bold text-gray-900 text-base">{{ $licence->entreprise->nom }}</h2>
                        <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold">{{ ucfirst($licence->type) }}</span>
                    </div>
                    <span class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $statutClasses[$licence->statut] ?? 'bg-gray-50 text-gray-600' }}">
                        {{ ucfirst($licence->statut) }}
                    </span>
                </div>

                {{-- Clé de licence mobile --}}
                <div>
                    <span class="block text-xs font-medium text-gray-500 mb-1">Clé de licence</span>
                    <div class="flex items-center gap-2">
                        <code id="cle-mob-{{ $licence->id }}" class="flex-1 bg-gray-50 border border-gray-200 font-mono text-xs text-gray-800 rounded px-2.5 py-1.5 break-all">
                            {{ $licence->cle }}
                        </code>
                        <button 
                            type="button" 
                            onclick="copierCle('cle-mob-{{ $licence->id }}', this)"
                            class="px-2.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded transition">
                            <span class="btn-text">📋 Copier</span>
                        </button>
                    </div>
                </div>

                {{-- Informations clés --}}
                <div class="grid grid-cols-2 gap-2 text-xs bg-gray-50/50 p-3 rounded-lg border border-gray-100">
                    <div>
                        <span class="text-gray-500 block">Expiration</span>
                        <span class="font-semibold text-gray-800">{{ \Illuminate\Support\Carbon::parse($licence->date_expiration)->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Postes utilisés</span>
                        <span class="font-semibold text-gray-800">{{ $licence->appareils->count() }} / {{ $licence->nombre_utilisateurs }}</span>
                    </div>
                </div>

                {{-- Action Voir Détail --}}
                <div class="pt-1">
                    <a href="{{ route('admin.licences.show', $licence) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-lg transition">
                        🔍 Voir le détail
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white ring-1 ring-gray-900/5 rounded-xl p-8 text-center text-gray-400 text-sm">
                Aucune licence pour l'instant.
            </div>
        @endforelse
    </div>

    {{-- VUE DESKTOP : Tableau (masqué sur mobile) --}}
    <div class="hidden md:block bg-white shadow-sm ring-1 ring-gray-900/5 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 font-semibold">Entreprise</th>
                        <th class="px-5 py-3.5 font-semibold">Clé</th>
                        <th class="px-5 py-3.5 font-semibold">Type</th>
                        <th class="px-5 py-3.5 font-semibold">Expiration</th>
                        <th class="px-5 py-3.5 font-semibold">Postes</th>
                        <th class="px-5 py-3.5 font-semibold">Statut</th>
                        <th class="px-5 py-3.5 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($licences as $licence)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-5 py-4 font-semibold text-gray-900 whitespace-nowrap">
                                {{ $licence->entreprise->nom }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <code id="cle-dt-{{ $licence->id }}" class="bg-gray-100 border border-gray-200 font-mono text-xs text-gray-800 rounded px-2 py-1">
                                        {{ $licence->cle }}
                                    </code>
                                    <button 
                                        type="button" 
                                        onclick="copierCle('cle-dt-{{ $licence->id }}', this)"
                                        class="px-2 py-1 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-600 text-xs rounded transition">
                                        <span class="btn-text">📋 Copier</span>
                                    </button>
                                </div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-gray-700">
                                {{ ucfirst($licence->type) }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-gray-700">
                                {{ \Illuminate\Support\Carbon::parse($licence->date_expiration)->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-gray-700">
                                <span class="font-medium text-gray-900">{{ $licence->appareils->count() }}</span>
                                <span class="text-gray-400">/ {{ $licence->nombre_utilisateurs }}</span>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $statutClasses[$licence->statut] ?? 'bg-gray-50 text-gray-600' }}">
                                    {{ ucfirst($licence->statut) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('admin.licences.show', $licence) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-md transition">
                                    <span>🔍</span> Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                                Aucune licence pour l'instant.
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
function copierCle(elementId, btn) {
    const cleElem = document.getElementById(elementId);
    if (!cleElem) return;

    const cle = cleElem.innerText.trim();
    const btnText = btn.querySelector('.btn-text');

    navigator.clipboard.writeText(cle)
        .then(() => {
            if (btnText) {
                const texteOriginal = btnText.innerText;
                btnText.innerText = '✅ Copié !';
                btn.classList.add('bg-emerald-100', 'text-emerald-700');
                
                setTimeout(() => {
                    btnText.innerText = texteOriginal;
                    btn.classList.remove('bg-emerald-100', 'text-emerald-700');
                }, 2000);
            }
        })
        .catch(() => {
            alert('Impossible de copier la clé.');
        });
}
</script>
@endpush