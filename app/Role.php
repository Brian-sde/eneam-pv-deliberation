<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Directeur = 'directeur';
    case ChefDepartement = 'chef_departement';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrateur',
            self::Directeur => 'Directeur',
            self::ChefDepartement => 'Chef de département',
        };
    }
}