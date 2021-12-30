<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Province extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'code'
    ];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($province) {
            $province->districts()->delete();
        });

        static::restoring(function($province) {
            $province->districts()->withTrashed()->restore();
        });
    }

    public function districts ()
    {
        return $this->hasMany('App\District', 'province_id', 'id');
    }
    
}
