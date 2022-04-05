<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producer extends Model
{
    use SoftDeletes;

    protected $table = "producers";

    protected $dates = ['deleted_at'];

    protected static $relations_to_vaccine_producer = ['hasManyVaccineProducer'];
    protected static $relations_to_packs = ['hasManyPacks'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($producer) {
        //     $producer->hasManyVaccineProducer()->delete();
        //     $producer->hasManyPacks()->delete();
        // });

        // static::restoring(function($producer) {
        //     $producer->hasManyVaccineProducer()->withTrashed()->restore();
        //     $producer->hasManyPacks()->withTrashed()->restore();
        // });

        static::deleting(function($resource) {
            foreach (static::$relations_to_vaccine_producer as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }

            foreach (static::$relations_to_packs as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_vaccine_producer as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }

            foreach (static::$relations_to_packs as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }
        });
    }

    protected $fillable = [
        'name', 'description', 'is_active'
    ];

    public function hasManyVaccineProducer ()
    {
        return $this->hasMany('App\VaccineProducer', 'producer_id', 'id');
    }

    public function hasManyPacks ()
    {
        return $this->hasMany('App\Pack', 'producer_id', 'id');
    }
}
