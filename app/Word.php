<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $table = 'words';

    protected $fillable = [
    ];

    public function course() {
        return $this->belongsTo('App\Course');
    }

    public function usersResult() {
        return $this->belongsToMany('App\User');
    }
}
