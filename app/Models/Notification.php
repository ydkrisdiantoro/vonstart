<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = ['menu_id', 'notification', 'is_read'];
    protected $table = 'notifications';
    protected $defaultOrderBy = ['order' => 'asc'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
