<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'date',
        'user_id',
        'pv_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pv(): BelongsTo
    {
        return $this->belongsTo(Pv::class);
    }

    /** Raccourci : Journal::enregistrer('PV créé', $pv->id) */
    public static function enregistrer(string $action, ?int $pvId = null): self
    {
        return self::create([
            'action' => $action,
            'date' => now(),
            'user_id' => auth()->id(),
            'pv_id' => $pvId,
        ]);
    }
}