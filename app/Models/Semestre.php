<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semestre extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
    ];

    public function pvs(): HasMany
    {
        return $this->hasMany(Pv::class);
    }
}