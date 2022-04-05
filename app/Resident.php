<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static $relations_to_injections = ['hasManyInjections'];
    protected static $relations_to_objects = ['hasManyObjects'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($resident) {
        //     $resident->hasManyInjections()->delete();
        //     $resident->hasManyObjects()->delete();
        // });

        // static::restoring(function($resident) {
        //     $resident->hasManyInjections()->withTrashed()->restore();
        //     $resident->hasManyObjects()->withTrashed()->restore();
        // });

        static::deleting(function($resource) {
            foreach (static::$relations_to_injections as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }

            foreach (static::$relations_to_objects as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_injections as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }

            foreach (static::$relations_to_objects as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }
        });
    }

    protected $fillable = [
        'name', 'date_of_birth', 'phone', 'identity_card', 'gender', 'health_insurance_card', 'nationality_id', 'ethnic_id ', 'ward_id', 'address', 'job', 'work_place', 'description', 'status_id'
    ];

    public function belongsToRole () {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function belongsToWard () {
        return $this->belongsTo('App\Ward', 'ward_id', 'id');
    }

    public function belongsToNationality () {
        return $this->belongsTo('App\Nationality', 'nationality_id', 'id');
    }

    public function belongsToEthnic () {
        return $this->hasMany('App\Ethnic', 'ethnic_id', 'id');
    }

    public function hasManyInjections () {
        return $this->hasMany('App\Injection', 'resident_id', 'id');
    }

    public function hasManyObjects () {
        return $this->hasMany('App\InjectionObject', 'resident_id', 'id');
    }
}
