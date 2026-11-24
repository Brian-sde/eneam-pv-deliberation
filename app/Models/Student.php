<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'last_name',
        'first_name',
        'gender',
        'birth_date',
        'birth_place',
        'email',
        'phone',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function results(): HasMany
    {
        return $this->hasMany(PvStudentResult::class);
    }

    /**
     * Nom complet (NOM Prénoms).
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => mb_strtoupper($this->last_name) . ' ' . ucwords(mb_strtolower($this->first_name))
        );
    }

    /**
     * Recherche d'un étudiant par mot-clé (matricule, nom ou prénom).
     */
    public function scopeSearch($query, ?string $term)
    {
        if (empty($term)) {
            return $query;
        }

        $term = '%' . trim($term) . '%';
        return $query->where(function ($q) use ($term) {
            $q->where('matricule', 'like', $term)
              ->orWhere('last_name', 'like', $term)
              ->orWhere('first_name', 'like', $term);
        });
    }
}
