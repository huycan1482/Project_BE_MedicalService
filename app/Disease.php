<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Disease extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static $relations_to_vaccine_disease = ['hasManyVaccineDisease'];
    protected static $relations_to_sessions = ['hasManySessions'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($disease) {
        //     $disease->hasManyVaccineDisease()->delete();
        //     $disease->hasManySessions()->delete();
        // });

        // static::restoring(function($disease) {
        //     $disease->hasManyVaccineDisease()->withTrashed()->restore();
        //     $disease->hasManySessions()->withTrashed()->restore();
        // });

        static::deleting(function($resource) {
            foreach (static::$relations_to_sessions as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }

            foreach (static::$relations_to_vaccine_disease as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_sessions as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }

            foreach (static::$relations_to_vaccine_disease as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }
        });
    }

    protected $fillable = [
        'name', 'description', 'is_active'
    ];

    public function hasManyVaccineDisease ()
    {
        return $this->hasMany('App\VaccineDisease', 'vaccine_id', 'id');
    }

    public function hasManySessions()
    {
        return $this->hasMany('App\Session', 'disease_id', 'id');
    }

    public function belongsToManyActiveVaccines () {
        return $this->belongsToMany('App\Vaccine', 'vaccine_disease', 'disease_id', 'vaccine_id')->where('is_active', 1)->withPivot('id', 'vaccine_id', 'disease_id', 'created_at', 'updated_at', 'deleted_at');
    }
    // lấy dữ liệu bảng n-n vaccines dc active
}
