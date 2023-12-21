<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = ['code', 'name', 'icon', 'order'];
    protected $table = 'roles';
    protected $defaultOrderBy = ['order' => 'asc'];
}
