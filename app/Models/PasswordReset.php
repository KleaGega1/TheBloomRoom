<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations\HasMany, SoftDeletes};

class PasswordReset extends Model
{
    use SoftDeletes;
    protected  $table = 'password_resets';
    
    protected  $fillable = [
        'user_id',
        'token',
        'expired_time',
        'used'
    ];
    
    public function user()
    {
        return User::find($this->user_id);
    }
}