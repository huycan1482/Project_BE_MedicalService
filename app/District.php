<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class District extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id', 'name', 'province_id', 'is_active'
    ];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($district) {
            $district->hasManyWards()->delete();
        });

        static::restoring(function($district) {
            $district->hasManyWards()->withTrashed()->restore();
        });
    }

    public function belongsToProvince () {
        return $this->belongsTo('App\Province', 'province_id', 'id');
    }

    public function hasManyWards ()
    {
        return $this->hasMany('App\Ward', 'district_id', 'id');
    }

    public function hasManyActiveWards ()
    {
        return $this->hasMany('App\Ward', 'district_id', 'id')->where('is_active', 1);
    }

}
