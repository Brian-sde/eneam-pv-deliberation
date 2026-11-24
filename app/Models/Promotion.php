<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'filiere_id',
        'level_id',
        'name',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function pvs(): HasMany
    {
        return $this->hasMany(Pv::class);
    }

    /**
     * Obtenir le nom complet et formatté de la promotion.
     * Ex: "2023-2024 - L2 Informatique de Gestion (IG)"
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function () {
                $year = $this->academicYear?->code ?? '';
                $level = $this->level?->code ?? '';
                $filiere = $this->filiere?->name ?? '';
                $filiereCode = $this->filiere?->code ? " ({$this->filiere->code})" : '';
                return trim("{$year} - {$level} {$filiere}{$filiereCode}");
            }
        );
    }
}
