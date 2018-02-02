<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class diagnosis_lookup_value extends Model
{
    use Eloquence;
    protected $searchableColumns = ['diagnosis_lookup_value'];
    protected $fillable = [
        'diagnosis_lookup_value','archived','created_by','updated_by'
    ];
    protected $table = "diagnosis_lookup_value";
    protected $primaryKey ='diagnosis_lookup_value_id';

}
