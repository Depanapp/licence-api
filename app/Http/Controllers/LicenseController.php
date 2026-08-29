<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licence;
use App\Models\Appareil;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Throwable;

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

        // ---------- Tout le traitement est protégé par un filet de sécurité ----------
        // En cas d'erreur inattendue (connexion DB coupée, timeout, etc.),
        // on ne renvoie JAMAIS la stack trace brute au client : on journalise
        // l'erreur côté serveur et on renvoie un message générique propre.
        try {
            return $this->traiterVerification($donnees);
        } catch (Throwable $e) {
            Log::error('[LicenceController] Erreur lors de la vérification de licence', [
                'message' => $e->getMessage(),
                'cle' => $donnees['cle'] ?? null,
                'identifiant_machine' => $donnees['identifiant_machine'] ?? null,
            ]);

            return response()->json([
                'valid' => false,
                'message' => 'Service de licence temporairement indisponible. Veuillez réessayer.',
            ], 503);
        }
    }

    /**
     * Logique métier de vérification, séparée pour pouvoir être encapsulée
     * dans le try/catch global de check().
     */
    private function traiterVerification(array $donnees)
    {
        // ---------- Lecture de la licence, avec reconnexion automatique ----------
        try {
            $licence = Licence::where('cle', $donnees['cle'])->first();
        } catch (QueryException $e) {
            // La connexion DB a pu être coupée (ex: "MySQL server has gone away").
            // On force une reconnexion et on retente une seule fois.
            DB::reconnect();
            $licence = Licence::where('cle', $donnees['cle'])->first();
        }

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

        // ---------- Activation / vérification de l'appareil (transactionnel) ----------

        try {
            DB::transaction(function () use ($licence, $donnees, &$appareil) {
                // Lock the licence row to prevent concurrent activation races.
                $licence = Licence::where('id', $licence->id)->lockForUpdate()->first();

                $appareil = Appareil::where('licence_id', $licence->id)
                    ->where('identifiant_machine', $donnees['identifiant_machine'])
                    ->first();

                if ($appareil) {
                    $appareil->update([
                        'nom_machine' => $donnees['nom_machine'] ?? $appareil->nom_machine,
                        'derniere_verification' => Carbon::now(),
                    ]);
                } else {
                    if ($licence->limiteAppareilsAtteinte()) {
                        throw new \RuntimeException('limit_reached');
                    }

                    $appareil = Appareil::create([
                        'licence_id' => $licence->id,
                        'identifiant_machine' => $donnees['identifiant_machine'],
                        'nom_machine' => $donnees['nom_machine'] ?? null,
                        'derniere_verification' => Carbon::now(),
                    ]);
                }
            });
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'limit_reached') {
                return response()->json([
                    'valid' => false,
                    'message' => 'Limite de postes atteinte pour cette licence',
                    'appareils_actifs' => $licence->nombreAppareilsActifs(),
                    'appareils_max' => $licence->nombre_utilisateurs,
                ], 403);
            }

            throw $e;
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