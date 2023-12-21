<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = ['menu_group_id', 'name', 'icon', 'route', 'is_show', 'cluster', 'order'];
    protected $table = 'menus';
    protected $defaultOrderBy = ['order' => 'asc'];

    public function menuGroup()
    {
        return $this->belongsTo(MenuGroup::class);
    }

    public function menuGroupNameAttribute()
    {
        return $this->menuGroup->name;
    }
}
