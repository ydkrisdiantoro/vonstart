<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ErrorLog extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = ['message', 'file', 'line', 'code', 'user_id'];
    protected $table = 'error_logs';
    protected $defaultOrderBy = ['created_at' => 'desc'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
