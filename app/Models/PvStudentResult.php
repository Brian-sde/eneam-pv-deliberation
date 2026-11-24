<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PvStudentResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'pv_id',
        'student_id',
        'average',
        'credits_earned',
        'decision',
        'rank',
        'mention',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'average' => 'decimal:2',
            'credits_earned' => 'integer',
            'rank' => 'integer',
        ];
    }

    public function pv(): BelongsTo
    {
        return $this->belongsTo(Pv::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // --- Helpers décision ---
    public function isAdmitted(): bool
    {
        return in_array($this->decision, ['admis', 'compense']);
    }

    public function isAjourned(): bool
    {
        return $this->decision === 'ajourne';
    }

    // --- Scopes ---
    public function scopeAdmitted($query)
    {
        return $query->whereIn('decision', ['admis', 'compense']);
    }

    public function scopeAjourned($query)
    {
        return $query->where('decision', 'ajourne');
    }

    public function scopeRattrapage($query)
    {
        return $query->where('decision', 'rattrapage');
    }
}
