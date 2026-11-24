<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'department',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
