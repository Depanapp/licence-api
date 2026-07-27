@extends('admin.layout')

@section('titre', 'Connexion')

@section('contenu')
<div class="min-h-[calc(100vh-12rem)] flex flex-col justify-center items-center py-6 px-4">

    <div class="w-full max-w-md">
        {{-- En-tête de la carte --}}
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-600 text-white mb-3 shadow-md shadow-indigo-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Connexion admin</h1>
            <p class="text-sm text-gray-500 mt-1">Gestion des entreprises et des licences</p>
        </div>

        {{-- Carte Formulaire --}}
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-2xl p-6 sm:p-8">

            {{-- Message d'erreur --}}
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs sm:text-sm flex items-center gap-2.5">
                    <span class="text-base shrink-0">⚠️</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4" onsubmit="desactiverBouton(this)">
                @csrf

                {{-- Champ Email --}}
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1.5">
                        Adresse email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        placeholder="admin@exemple.com"
                        required 
                        autofocus
                        class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition duration-150"
                    >
                </div>

                {{-- Champ Mot de passe --}}
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1.5">
                        Mot de passe
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="••••••••"
                        required
                        class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition duration-150"
                    >
                </div>

                {{-- Bouton Connexion --}}
                <div class="pt-2">
                    <button 
                        type="submit" 
                        id="btn-submit"
                        class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold rounded-lg shadow-sm transition active:scale-[0.99] disabled:opacity-70 disabled:cursor-not-allowed">
                        <span>Se connecter</span>
                        <span class="text-gray-400">→</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function desactiverBouton(form) {
    const btn = form.querySelector('#btn-submit');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span>Connexion en cours...</span>';
    }
}
</script>
@endpush