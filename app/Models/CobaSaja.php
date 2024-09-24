<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CobaSaja extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = ['menu_group_id','name','icon','route','cluster','is_show','order'];
    protected $table = 'menus';
    protected $defaultOrderBy = ['created_at' => 'desc'];
    
    public function menuGroup(){
        return $this->belongsTo(MenuGroup::class);
    }
}
