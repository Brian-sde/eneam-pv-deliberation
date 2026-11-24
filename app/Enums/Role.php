<?php

namespace App\Enums;

enum Role: string
{
    case ChefDepartement = 'chef_departement';
    case Admin = 'admin';
    case User = 'user';
}