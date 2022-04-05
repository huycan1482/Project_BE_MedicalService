<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pack extends Model
{
    use SoftDeletes;

    protected $table = "packs";

    protected $dates = ['deleted_at'];

    protected static $relations_to_injections = ['hasManyInjections'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($pack) {
        //     $pack->hasManyInjections()->delete();
        // });

        // static::restoring(function($pack) {
        //     $pack->hasManyInjections()->withTrashed()->restore();
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
        'name', 'expired', 'vaccine_id', 'producer_id', 'is_active'
    ];

    public function belongsToVaccine () {
        return $this->belongsTo('App\Vaccine', 'vaccine_id', 'id');
    }

    public function belongsToVaccineTrashed () {
        return $this->belongsTo('App\Vaccine', 'vaccine_id', 'id')->withTrashed();
    }

    public function belongsToProducers () {
        return $this->belongsTo('App\Producer', 'producer_id', 'id');
    }

    public function hasManyInjections () {
        return $this->hasMany('App\Injection', 'pack_id', 'id');
    }
}
