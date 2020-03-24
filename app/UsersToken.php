<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersToken extends Model
{
    protected $table = 'users_token';

    protected $fillable = [
        'token', 'user_id', 'active',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
