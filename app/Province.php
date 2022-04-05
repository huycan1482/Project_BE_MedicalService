<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Province extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id', 'name', 'code', 'is_active'
    ];

    protected static $relations_to_districts = ['hasManyDistricts'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($province) {
        //     $province->hasManyDistricts()->delete();
        // });

        // static::restoring(function($province) {
        //     $province->hasManyDistricts()->withTrashed()->restore();
        // });

        static::deleting(function($resource) {
            foreach (static::$relations_to_districts as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_districts as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }
        });
    }

    public function hasManyDistricts ()
    {
        return $this->hasMany('App\District', 'province_id', 'id');
    }

    public function hasManyActiveDistricts ()
    {
        return $this->hasMany('App\District', 'province_id', 'id')->where('is_active', 1);
    }
    
}
