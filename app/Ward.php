<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ward extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id', 'name', 'district_id', 'is_active'
    ];

    public function belongsToDistrict () {
        return $this->belongsTo('App\District', 'district_id', 'id');
    }
}
