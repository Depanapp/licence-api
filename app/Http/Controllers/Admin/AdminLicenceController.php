<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appareil;
use App\Models\Entreprise;
use App\Models\Licence;
use Illuminate\Http\Request;

class AdminLicenceController extends Controller
{
    public function create(Request $request)
    {
        $entreprises = Entreprise::orderBy('nom')->get();
        $entrepriseSelectionnee = $request->integer('entreprise') ?: null;

        return view('admin.licences.create', compact('entreprises', 'entrepriseSelectionnee'));
    }

    public function store(Request $request)
    {
        $donnees = $request->validate([
            'entreprise_id' => 'required|exists:entreprises,id',
            'type' => 'required|string|in:mensuelle,annuelle,perpetuelle',
            'date_debut' => 'required|date',
            'date_expiration' => 'required|date|after:date_debut',
            'nombre_utilisateurs' => 'required|integer|min:1',
            'nombre_vehicules' => 'required|integer|min:1',
        ]);

        $donnees['cle'] = Licence::genererCle();
        $donnees['statut'] = 'active';

        $licence = Licence::create($donnees);

        return redirect()
            ->route('admin.licences.show', $licence)
            ->with('succes', 'Licence générée avec succès.');
    }

    public function show(Licence $licence)
    {
        $licence->load(['entreprise', 'appareils']);

        return view('admin.licences.show', compact('licence'));
    }

    public function toggleStatut(Licence $licence)
    {
        $licence->update([
            'statut' => $licence->statut === 'bloquee' ? 'active' : 'bloquee',
        ]);

        return back()->with('succes', 'Statut de la licence mis à jour.');
    }

    public function revoquerAppareil(Appareil $appareil)
    {
        $licence = $appareil->licence;
        $appareil->delete();

        return redirect()
            ->route('admin.licences.show', $licence)
            ->with('succes', 'Appareil révoqué : le poste est de nouveau disponible.');
    }

    public function destroy(Licence $licence)
    {
        if ($licence->appareils()->exists()) {
            return back()->with(
                'erreur',
                'Impossible de supprimer cette licence car des appareils sont encore activés.'
            );
        }

        $licence->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Licence supprimée avec succès.');
    }
}