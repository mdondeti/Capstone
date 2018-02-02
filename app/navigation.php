<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class navigation extends Model
{
    protected $fillable = [
        'navigation_name', 'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'navigation_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    protected $table = 'navigations';
    protected $primaryKey = 'navigation_id';
}