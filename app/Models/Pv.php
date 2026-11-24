<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pv extends Model
{
    use HasFactory;

    public const STATUT_BROUILLON = 'brouillon';
    public const STATUT_VALIDE = 'valide';
    public const STATUT_ARCHIVE = 'archive';

    protected $fillable = [
        'reference',
        'session',
        'date_deliberation',
        'president_jury',
        'membres_jury',
        'fichier_path',
        'statut',
        'filiere_id',
        'annee_academique_id',
        'niveau_id',
        'semestre_id',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'date_deliberation' => 'date',
        ];
    }

    // Relations

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    public function anneeAcademique(): BelongsTo
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    public function semestre(): BelongsTo
    {
        return $this->belongsTo(Semestre::class);
    }

    /** Utilisateur qui a créé le PV */
    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function resultats(): HasMany
    {
        return $this->hasMany(Resultat::class);
    }

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    // Scope : PV visibles selon l'utilisateur

    public function scopeVisiblePar(Builder $query, User $user): Builder
    {
        if ($user->role === Role::ChefDepartement) {
            return $query->whereIn('filiere_id', $user->filieres()->pluck('id'));
        }

        return $query; // admin et directeur : tout
    }

    // Aides

    public function estBrouillon(): bool
    {
        return $this->statut === self::STATUT_BROUILLON;
    }

    public function estValide(): bool
    {
        return $this->statut === self::STATUT_VALIDE;
    }
}