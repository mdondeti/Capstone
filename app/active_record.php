<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class active_record extends Model
{
    protected $fillable = [
        'patient_id','navigation_id','doc_control_id','doc_control_group','doc_control_group_order',
        'value','created_by','updated_by'
    ];

    public function patient() {
        return $this->belongsTo('App\patient');
    }
    public function navigation() {
        return $this->belongsTo('App\navigation');
    }
    public function doc_control_id() {
        return $this->belongsTo('App\doc_control_id');
    }

    protected $table = 'active_record';
    protected $primaryKey='active_record_id';
}
