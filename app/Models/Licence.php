<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Licence extends Model
{
    use HasFactory;

    protected $fillable = [
        'entreprise_id',
        'cle',
        'type',
        'date_debut',
        'date_expiration',
        'statut',
        'nombre_utilisateurs',
        'nombre_vehicules',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_expiration' => 'date',
    ];

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function appareils(): HasMany
    {
        return $this->hasMany(Appareil::class);
    }

    public function estExpiree(): bool
    {
        return Carbon::now()->gt(Carbon::parse($this->date_expiration));
    }

    public function estActive(): bool
    {
        return $this->statut === 'active' && !$this->estExpiree();
    }

    // Nombre d'appareils déjà activés sur cette licence.
    public function nombreAppareilsActifs(): int
    {
        return $this->appareils()->count();
    }

    // La limite de postes est atteinte pour un nouvel appareil (celui-ci
    // n'étant pas déjà enregistré).
    public function limiteAppareilsAtteinte(): bool
    {
        return $this->nombreAppareilsActifs() >= $this->nombre_utilisateurs;
    }

    // Génère une clé lisible du type XXXX-XXXX-XXXX-XXXX, en garantissant
    // qu'elle n'existe pas déjà en base.
    public static function genererCle(): string
    {
        do {
            $segments = collect(range(1, 4))->map(fn () => strtoupper(Str::random(4)));
            $cle = $segments->implode('-');
        } while (self::where('cle', $cle)->exists());

        return $cle;
    }
}