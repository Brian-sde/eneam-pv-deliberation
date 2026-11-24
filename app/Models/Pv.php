<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pv extends Model
{
    use HasFactory;

    protected $fillable = [
        'promotion_id',
        'semester_id',
        'reference',
        'session',
        'deliberation_date',
        'jury_president',
        'jury_members',
        'file_path',
        'file_hash_sha256',
        'status',
        'parent_pv_id',
        'rectification_reason',
        'observations',
        'created_by',
        'validated_by',
        'validated_at',
    ];

    protected function casts(): array
    {
        return [
            'deliberation_date' => 'date',
            'validated_at' => 'datetime',
            'jury_members' => 'array',
        ];
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function parentPv(): BelongsTo
    {
        return $this->belongsTo(Pv::class, 'parent_pv_id');
    }

    public function rectifications(): HasMany
    {
        return $this->hasMany(Pv::class, 'parent_pv_id');
    }

    public function studentResults(): HasMany
    {
        return $this->hasMany(PvStudentResult::class)->orderBy('rank');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // --- Helpers de statut ---
    public function isValidated(): bool
    {
        return $this->status === 'validated';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isRectified(): bool
    {
        return $this->status === 'rectified';
    }

    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }

    // --- Scopes ---
    public function scopeValidated($query)
    {
        return $query->where('status', 'validated');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Recherche multicritère de PV.
     */
    public function scopeSearch($query, array $filters = [])
    {
        if (!empty($filters['reference'])) {
            $query->where('reference', 'like', '%' . trim($filters['reference']) . '%');
        }

        if (!empty($filters['session'])) {
            $query->where('session', $filters['session']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['semester_id'])) {
            $query->where('semester_id', $filters['semester_id']);
        }

        if (!empty($filters['academic_year_id']) || !empty($filters['filiere_id']) || !empty($filters['level_id'])) {
            $query->whereHas('promotion', function ($q) use ($filters) {
                if (!empty($filters['academic_year_id'])) {
                    $q->where('academic_year_id', $filters['academic_year_id']);
                }
                if (!empty($filters['filiere_id'])) {
                    $q->where('filiere_id', $filters['filiere_id']);
                }
                if (!empty($filters['level_id'])) {
                    $q->where('level_id', $filters['level_id']);
                }
            });
        }

        return $query;
    }
}
