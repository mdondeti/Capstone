<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class lookup_value extends Model
{
    use Eloquence;
    protected $searchableColumns = ['lookup_value'];
    protected $fillable = [
        'lookup_value','archived','created_by','updated_by'
    ];
    protected $table = "lookup_value";
    protected $primaryKey ='lookup_value_id';
    public function docLookup()
    {
        return $this->belongsTo('app\doc_lookup_value');
    }
}
