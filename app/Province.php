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

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($province) {
            $province->hasManyDistricts()->delete();
        });

        static::restoring(function($province) {
            $province->hasManyDistricts()->withTrashed()->restore();
        });
    }

    public function hasManyDistricts ()
    {
        return $this->hasMany('App\District', 'province_id', 'id');
    }
    
}
