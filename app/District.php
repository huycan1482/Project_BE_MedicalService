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

    protected static $relations_to_wards = ['hasManyWards'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($district) {
        //     $district->hasManyWards()->delete();
        // });

        // static::restoring(function($district) {
        //     $district->hasManyWards()->withTrashed()->restore();
        // });

        static::deleting(function($resource) {
            foreach (static::$relations_to_wards as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_wards as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }
        });
    }

    public function belongsToProvince () {
        return $this->belongsTo('App\Province', 'province_id', 'id');
    }

    public function belongsToProvinceTrashed () {
        return $this->belongsTo('App\Province', 'province_id', 'id')->onlyTrashed();
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
