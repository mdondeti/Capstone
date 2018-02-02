<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class freetext_value_type extends Model
{
    protected $fillable = [
        'freetext_value_type','created_by','updated_by'
    ];
    protected $table = "freetext_value_type";
    protected $primaryKey ='freetext_value_type_id';
}
