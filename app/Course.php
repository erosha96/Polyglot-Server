<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
    ];

    public function user() {
        return $this->belongsTo('App\User', 'created_user_id');
    }

    public function usersResult() {
        return $this->belongsToMany('App\User', 'user_course');
    }

    public function words() {
        return $this->hasMany('App\Word');
    }
}
