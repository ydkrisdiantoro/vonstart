<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleMenu extends Model
{
    use HasFactory,SoftDeletes,HasUuids;

    protected $fillable = ['menu_id', 'role_id', 'is_create', 'is_read', 'is_update', 'is_delete', 'is_validate'];
    protected $table = 'role_menus';

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function roleNameAttribute()
    {
        return $this->role->name;
    }

    public function menuNameAttribute()
    {
        return $this->menu->name;
    }

    public function notification()
    {
        return $this->hasMany(Notification::class, 'menu_id', 'menu_id');
    }
}
