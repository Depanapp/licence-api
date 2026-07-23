<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licence;
use App\Models\Appareil;
use Carbon\Carbon;

class LicenseController extends Controller
{
    /**
     * Vérifie une licence pour un appareil donné.
     *
     * - Si l'appareil (identifiant_machine) est déjà connu pour cette
     *   licence, on met simplement à jour sa dernière vérification.
     * - Sinon, on tente de l'activer : refusé si le nombre de postes déjà
     *   actifs a atteint la limite (nombre_utilisateurs) de la licence.
     */
    public function check(Request $request)
    {
        $donnees = $request->validate([
            'cle' => 'required|string',
            'identifiant_machine' => 'required|string',
            'nom_machine' => 'nullable|string',
        ]);

        $licence = Licence::where('cle', $donnees['cle'])->first();

        if (!$licence) {
            return response()->json([
                'valid' => false,
                'message' => 'Licence introuvable',
            ], 404);
        }

        if ($licence->statut === 'bloquee') {
            return response()->json([
                'valid' => false,
                'message' => 'Licence bloquée',
            ], 403);
        }

        if ($licence->statut !== 'active') {
            return response()->json([
                'valid' => false,
                'message' => 'Licence inactive',
            ], 403);
        }

        if ($licence->estExpiree()) {
            $licence->update(['statut' => 'expiree']);

            return response()->json([
                'valid' => false,
                'message' => 'Licence expirée',
            ], 403);
        }

        // ---------- Activation / vérification de l'appareil ----------

        $appareil = Appareil::where('licence_id', $licence->id)
            ->where('identifiant_machine', $donnees['identifiant_machine'])
            ->first();

        if ($appareil) {
            // Appareil déjà connu : on rafraîchit juste son horodatage,
            // et le nom de machine au cas où il aurait changé.
            $appareil->update([
                'nom_machine' => $donnees['nom_machine'] ?? $appareil->nom_machine,
                'derniere_verification' => Carbon::now(),
            ]);
        } else {
            // Nouvel appareil pour cette licence : on vérifie d'abord qu'il
            // reste des postes disponibles avant de l'enregistrer.
            if ($licence->limiteAppareilsAtteinte()) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Limite de postes atteinte pour cette licence',
                    'appareils_actifs' => $licence->nombreAppareilsActifs(),
                    'appareils_max' => $licence->nombre_utilisateurs,
                ], 403);
            }

            $appareil = Appareil::create([
                'licence_id' => $licence->id,
                'identifiant_machine' => $donnees['identifiant_machine'],
                'nom_machine' => $donnees['nom_machine'] ?? null,
                'derniere_verification' => Carbon::now(),
            ]);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Licence valide',
            'licence' => [
                'type' => $licence->type,
                'expiration' => $licence->date_expiration,
                'utilisateurs' => $licence->nombre_utilisateurs,
                'vehicules' => $licence->nombre_vehicules,
            ],
            'appareil' => [
                'identifiant_machine' => $appareil->identifiant_machine,
                'nom_machine' => $appareil->nom_machine,
                'derniere_verification' => $appareil->derniere_verification,
            ],
            'appareils_actifs' => $licence->nombreAppareilsActifs(),
            'appareils_max' => $licence->nombre_utilisateurs,
        ]);
    }
}