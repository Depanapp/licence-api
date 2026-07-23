<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use Illuminate\Http\Request;

class AdminEntrepriseController extends Controller
{
    public function create()
    {
        return view('admin.entreprises.create');
    }

    public function store(Request $request)
    {
        $donnees = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:50',
            'pays' => 'nullable|string|max:100',
            'adresse' => 'nullable|string|max:255',
        ]);

        $entreprise = Entreprise::create($donnees);

        return redirect()
            ->route('admin.licences.create', ['entreprise' => $entreprise->id])
            ->with('succes', "Entreprise « {$entreprise->nom} » créée. Générez-lui maintenant une licence.");
    }
}