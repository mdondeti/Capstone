<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class lab_orders_lookup_value extends Model
{
    use Eloquence;
    protected $searchableColumns = ['lab_orders_lookup_value'];
    protected $fillable = [
        'lab_orders_lookup_value','archived','created_by','updated_by'
    ];
    protected $table = "lab_orders_lookup_value";
    protected $primaryKey ='lab_orders_lookup_value_id';

}
