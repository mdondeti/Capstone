<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class module extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module_name','archived'
    ];


    public function patients() {
        return $this->hasMany('App\patient');
    }

    protected $table = 'module';
    protected $primaryKey ='module_id';
}
