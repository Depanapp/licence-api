<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appareil extends Model
{
    use HasFactory;

    protected $fillable = [
        'licence_id',
        'identifiant_machine',
        'nom_machine',
        'derniere_verification',
    ];

    protected $casts = [
        'derniere_verification' => 'datetime',
    ];

    public function licence(): BelongsTo
    {
        return $this->belongsTo(Licence::class);
    }
}