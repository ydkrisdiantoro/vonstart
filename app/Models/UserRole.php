<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    use HasFactory,SoftDeletes,HasUuids;

    protected $fillable = ['role_id','user_id'];
    protected $table = 'user_roles';

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roleNameAttribute()
    {
        return $this->role->name;
    }

    public function userNameAttribute()
    {
        return $this->user->name;
    }
}
