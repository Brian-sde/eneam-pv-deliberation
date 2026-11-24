<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'actif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
            'actif' => 'boolean',
        ];
    }

    // Relations

    /** Filières dont cet utilisateur est le chef */
    public function filieres(): HasMany
    {
        return $this->hasMany(Filiere::class, 'chef_id');
    }

    /** PV créés par cet utilisateur */
    public function pvs(): HasMany
    {
        return $this->hasMany(Pv::class);
    }

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    // Aides

    public function isAdmin(): bool
    {
        return $this->role === Role::Admin;
    }

    public function isDirecteur(): bool
    {
        return $this->role === Role::Directeur;
    }

    public function isChefDepartement(): bool
    {
        return $this->role === Role::ChefDepartement;
    }
}