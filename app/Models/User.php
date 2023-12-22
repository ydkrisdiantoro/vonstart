<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'photo',
        'phone',
        'password',
        'email_verified_at'
    ];
    protected $table = 'users';

    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function menus()
    {
        return $this->hasManyThrough(Menu::class, UserRole::class);
    }
}
