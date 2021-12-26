<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;

class AdminUser extends \Illuminate\Foundation\Auth\User implements FilamentUser
{
    use HasFactory, Authenticatable, Authorizable;

    protected $fillable = [
        'name', 'password', 'ip_address'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessFilament(): bool
    {
        return true;
    }

}
