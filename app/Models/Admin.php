<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable implements FilamentUser
{
    use HasFactory;

    protected $guarded = [];
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true;
    }
}
