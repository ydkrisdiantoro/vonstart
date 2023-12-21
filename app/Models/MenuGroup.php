<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuGroup extends Model
{
    use HasFactory,SoftDeletes,HasUuids;

    protected $fillable = ['name', 'order'];
    protected $table = 'menu_groups';
    protected $defaultOrderBy = ['order' => 'asc'];
}
