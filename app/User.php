<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname', 'email', 'password','contactno','role','departmentName','archived','security_question1_Id','security_answer1','security_question2_Id','security_answer2','security_question3_Id','security_answer3'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function EmailidRole() {
        return $this->belongsTo('App\EmailidRole');
    }
    public function Security() {
        return $this->belongsTo('App\Security');
    }
    public function users_patient() {
        return $this->belongsTo('App\users_patient');
    }
    public function patient() {
        return $this->belongsToMany('App\patient', 'created_by');
    }

    protected $table = 'users';
}