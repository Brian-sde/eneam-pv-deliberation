<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenoms',
        'credits_valides',
        'decision',
        'pv_id',
    ];

    protected function casts(): array
    {
        return [
            'credits_valides' => 'integer',
        ];
    }

    public function pv(): BelongsTo
    {
        return $this->belongsTo(Pv::class);
    }
}