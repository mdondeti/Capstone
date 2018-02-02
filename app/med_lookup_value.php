<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class med_lookup_value extends Model
{
    use Eloquence;
    protected $searchableColumns = ['med_lookup_value'];
    protected $fillable = [
        'med_lookup_value','archived','created_by','updated_by'
    ];
    protected $table = "med_lookup_value";
    protected $primaryKey ='med_lookup_value_id';

}
