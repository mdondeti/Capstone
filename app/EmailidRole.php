<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailidRole extends Model
{
    protected $fillable = [
        'email','role'
        ];

    public function users() {
        return $this->hasOne('App\User');
    }
    protected $table = 'EmailIdRole';
}
