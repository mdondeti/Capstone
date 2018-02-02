<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
     protected $fillable = [
        'id','security_question'
    ];

    public function users() {
        return $this->hasMany('App\User');
    }
    protected $table = 'security';
}
