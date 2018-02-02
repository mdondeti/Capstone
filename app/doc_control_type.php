<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class doc_control_type extends Model
{
    protected $fillable = [
        'control_type','created_by','updated_by'
    ];

    public function navigations() {
        return $this->hasMany('App\navigation');
    }

    public function modules() {
        return $this->hasMany('App\module');
    }

    protected $table = 'doc_control_type';
    protected $primaryKey = 'doc_control_type_id';
}
