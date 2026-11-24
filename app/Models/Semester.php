<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_id',
        'code',
        'name',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function pvs(): HasMany
    {
        return $this->hasMany(Pv::class);
    }
}
