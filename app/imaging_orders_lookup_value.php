<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class imaging_orders_lookup_value extends Model
{
    use Eloquence;
    protected $searchableColumns = ['imaging_orders_lookup_value'];
    protected $fillable = [
        'imaging_orders_lookup_value','archived','created_by','updated_by'
    ];
    protected $table = "imaging_orders_lookup_value";
    protected $primaryKey ='imaging_orders_lookup_value_id';

}
