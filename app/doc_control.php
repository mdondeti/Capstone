<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class doc_control extends Model
{
    protected $fillable = [
        'navigation_id', 'label','doc_control_type_id','freetext_value_type_id','doc_control_group','doc_control_group_order',
        'freetext_minval_number','freetext_maxval_number', 'freetext_minval_date','freetext_maxval_date',
        'freetext_minval_length','freetext_maxval_length','archived','created_by','updated_by'
    ];

    public function navigations() {
        return $this->hasMany('App\navigation');
    }

    public function doc_control_type() {
        return $this->hasMany('App\doc_control_type');
    }
    public function freetext_value_type() {
        return $this->hasMany('App\freetext_value_type');
    }

    public function LookupValues()
    {
        return $this->belongsToMany('App\lookup_value');
    }

    protected $table = 'doc_control';
    protected $primaryKey = 'doc_control_id';
}
