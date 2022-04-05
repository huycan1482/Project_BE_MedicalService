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

    protected static $relations_to_roles = ['hasManyRoles'];
    protected static $relations_to_users = ['hasManyUsers'];
    protected static $relations_to_residents = ['hasManyResidents'];
    protected static $relations_to_sessions = ['hasManySessions'];

    protected static function boot() {
        parent::boot();

        static::deleting(function($resource) {
            foreach (static::$relations_to_roles as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }

            foreach (static::$relations_to_users as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }

            foreach (static::$relations_to_residents as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }

            foreach (static::$relations_to_sessions as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_roles as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }

            foreach (static::$relations_to_users as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }

            foreach (static::$relations_to_residents as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }

            foreach (static::$relations_to_sessions as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }
        });
    
        // static::deleting(function($ward) {
        //     $ward->hasManyRoles()->delete();
        //     $ward->hasManyUsers()->delete();
        //     $ward->hasManyResidents()->delete();
        //     $ward->hasManySessions()->delete();
        // });

        // static::restoring(function($ward) {
        //     $ward->hasManyRoles()->withTrashed()->restore();
        //     $ward->hasManyUsers()->withTrashed()->restore();
        //     $ward->hasManyResidents()->withTrashed()->restore();
        //     $ward->hasManySessions()->withTrashed()->restore();
        // });
    }

    public function belongsToDistrict () {
        return $this->belongsTo('App\District', 'district_id', 'id');
    }

    public function belongsToDistrictTrashed () {
        return $this->belongsTo('App\District', 'district_id', 'id')->onlyTrashed();
    }

    public function hasManyRoles () {
        return $this->hasMany('App\Role', 'ward_id', 'id');
    }

    public function hasManyUsers () {
        return $this->hasMany('App\User', 'ward_id', 'id');
    }
    public function hasManyResidents () {
        return $this->hasMany('App\Resident', 'ward_id', 'id');
    }

    public function hasManySessions () {
        return $this->hasMany('App\Session', 'ward_id', 'id');
    }
}
