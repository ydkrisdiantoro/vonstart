<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['user_id', 'token', 'expired_at'];
    protected $table = 'password_resets';
    protected $defaultOrderBy = ['expired_at' => 'desc'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
