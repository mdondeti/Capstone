<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class patient extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'gender', 'age','weight','height','room_number','visit_date','submitted_date','completed_flag','archived', 'module_id','created_by','updated_by'
    ];

    public function module() {
        return $this->belongsTo('App\module','module_id','module_id');
    }
    public function users_patients() {
        return $this->hasMany('App\users_patient');
    }

    public function getStatusAttribute(){
        $status_id = users_patient::where('patient_id',$this->patient_id)->get();
        return  $status_id[0]->patient_record_status_id;
    }
    public function user() {
        return $this->belongsTo('App\user', 'created_by', 'id');
    }

    protected $table = 'patient';
    protected $primaryKey ='patient_id';
}