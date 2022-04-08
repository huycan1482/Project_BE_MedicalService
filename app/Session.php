<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;

    protected $table = 'sessions';

    protected $dates = ['deleted_at'];

    protected static $relations_to_session_vaccine = ['hasManySessionVaccine'];
    protected static $relations_to_objects = ['hasManyObjects'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($role) {
        //     $role->hasManySessionVaccine()->delete();
        //     $role->hasManyObjects()->delete();
        // });

        // static::restoring(function($role) {
        //     $role->hasManySessionVaccine()->withTrashed()->restore();
        //     $role->hasManyObjects()->withTrashed()->restore();
        // });

        static::deleting(function($resource) {
            foreach (static::$relations_to_session_vaccine as $relation) {
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
            foreach (static::$relations_to_session_vaccine as $relation) {
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
        'start_at', 'end_at', 'disease_id', 'address', 'ward_id', 'status_id'
    ];

    public function belongsToDisease () {
        return $this->belongsTo('App\Disease', 'disease_id', 'id');
    }

    public function belongsToDiseaseTrashed () {
        return $this->belongsTo('App\Disease', 'disease_id', 'id')->withTrashed();
    }

    public function belongsToWard () {
        return $this->belongsTo('App\Ward', 'ward_id', 'id');
    }

    public function belongsToWardWithTrashed () {
        return $this->belongsTo('App\Ward', 'ward_id', 'id')->withTrashed();
    }

    public function hasManySessionVaccine () {
        return $this->hasMany('App\SessionVaccine', 'session_id', 'id');
    }

    public function hasManyObjects () {
        return $this->hasMany('App\InjectionObject', 'session_id', 'id');
    }

    public function belongsToManyVaccines () {
        return $this->belongsToMany('App\Vaccine', 'session_vaccine', 'session_id', 'vaccine_id')->withPivot('id', 'session_id', 'vaccine_id', 'created_at', 'updated_at', 'deleted_at');
    }
    // lấy dữ liệu bảng n-n vaccines

    public function belongsToManyActiveVaccines () {
        return $this->belongsToMany('App\Vaccine', 'session_vaccine', 'session_id', 'vaccine_id')->where('is_active', 1)->withPivot('id', 'session_id', 'vaccine_id', 'created_at', 'updated_at', 'deleted_at');
    }
    // lấy dữ liệu bảng n-n vaccines

    public function hasManyObject () {
        return $this->hasMany('App\InjectionObject', 'session_id', 'id');
    }

    

    
}
