<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class doc_lookup_value extends Model
{
    protected $fillable = [
        'doc_control_id','lookup_value_id','sort_order_number','created_by','updated_by'
    ];

    public function doc_control() {
        return $this->hasMany('App\doc_control');
    }

    public function lookup_values() {
        return $this->hasMany('App\lookup_value');
    }

    protected $table = 'doc_lookup_value';
}
