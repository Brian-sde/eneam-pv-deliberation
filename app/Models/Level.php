<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'cycle',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    public function semesters(): HasMany
    {
        return $this->hasMany(Semester::class)->orderBy('order');
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }
}
