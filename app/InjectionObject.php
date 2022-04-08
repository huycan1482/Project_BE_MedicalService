<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InjectionObject extends Model
{
    use SoftDeletes;

    protected $table = "objects";

    protected $dates = ['deleted_at'];

    protected static $relations_to_injections = ['hasManyInjections'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($object) {
        //     $object->hasManyInjections()->delete();
        // });

        // static::restoring(function($object) {
        //     $object->hasManyInjections()->withTrashed()->restore();
        // });

        static::deleting(function($resource) {
            foreach (static::$relations_to_injections as $relation) {
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
        });
    }

    protected $fillable = [
        'session_id', 'resident_id', 'description', 'status_id'
    ];

    public function belongsToResident () {
        return $this->belongsTo('App\Resident', 'resident_id', 'id');
    }

    public function belongsToResidentTrashed () {
        return $this->belongsTo('App\Resident', 'resident_id', 'id')->withTrashed();
    }

    public function belongsToSession () {
        return $this->belongsTo('App\Session', 'session_id', 'id');
    }

    public function hasManyInjections () {
        return $this->hasMany('App\Injection', 'object_id', 'id');
    }

    public function hasOneInjection ($object_id) {
        $resident = \App\Resident::find($object_id);
        return $resident;
    }
}
