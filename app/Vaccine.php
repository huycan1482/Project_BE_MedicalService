<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vaccine extends Model
{
    use SoftDeletes;

    protected $table = "vaccines";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description', 'is_active'
    ];

    protected static $relations_to_vaccine_disease = ['hasManyVaccineDisease'];
    protected static $relations_to_vaccine_producer = ['hasManyVaccineProducer'];
    protected static $relations_to_session_vaccine = ['hasManySessionVaccine'];
    protected static $relations_to_packs = ['hasManyPacks'];

    protected static function boot() {
        parent::boot();
    
        // static::deleting(function($vaccine) {
        //     $vaccine->hasManyVaccineDisease()->delete();
        //     $vaccine->hasManyVaccineProducer()->delete();
        //     $vaccine->hasManySessionVaccine()->delete();
        //     $vaccine->hasManyPacks()->delete();
        // });

        // static::restoring(function($vaccine) {
        //     $vaccine->hasManyVaccineDisease()->withTrashed()->restore();
        //     $vaccine->hasManyVaccineProducer()->withTrashed()->restore();
        //     $vaccine->hasManySessionVaccine()->withTrashed()->restore();
        //     $vaccine->hasManyPacks()->withTrashed()->restore();
        // });

        static::deleting(function($resource) {
            foreach (static::$relations_to_vaccine_disease as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }

            foreach (static::$relations_to_vaccine_producer as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }

            foreach (static::$relations_to_session_vaccine as $relation) {
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
            foreach (static::$relations_to_vaccine_disease as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }

            foreach (static::$relations_to_vaccine_producer as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->withTrashed()->restore();
                }
            }

            foreach (static::$relations_to_session_vaccine as $relation) {
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

    public function hasManyVaccineDisease () {
        return $this->hasMany('App\VaccineDisease', 'vaccine_id', 'id');
    }

    public function hasManyVaccineProducer () {
        return $this->hasMany('App\VaccineProducer', 'vaccine_id', 'id');
    }

    public function hasManySessionVaccine (){
        return $this->hasMany('App\SessionVaccine', 'vaccine_id', 'id');
    }

    public function hasManyPacks () {
        return $this->hasMany('App\Pack', 'vaccine_id', 'id');
    }

    public function belongsToManyDiseases () {
        return $this->belongsToMany('App\Disease', 'vaccine_disease', 'vaccine_id', 'disease_id')->withPivot('id', 'vaccine_id', 'disease_id', 'created_at', 'updated_at', 'deleted_at');
    } 
    // lấy dữ liệu bảng n-n diseases

    public function belongsToManyProducers () {
        return $this->belongsToMany('App\Producer', 'vaccine_producer', 'vaccine_id', 'producer_id')->withPivot('id', 'vaccine_id', 'producer_id', 'created_at', 'updated_at', 'deleted_at');
    }
    // lấy dữ liệu bảng n-n producers

    public function belongsToManyActiveDiseases () {
        return $this->belongsToMany('App\Disease', 'vaccine_disease', 'vaccine_id', 'disease_id')->where('is_active', 1)->withPivot('id', 'vaccine_id', 'disease_id', 'created_at', 'updated_at', 'deleted_at');
    }
    // lấy dữ liệu bảng n-n diseases dc active

    public function belongsToManyActiveProducers () {
        return $this->belongsToMany('App\Producer', 'vaccine_producer', 'vaccine_id', 'producer_id')->where('is_active', 1)->withPivot('id', 'vaccine_id', 'producer_id', 'created_at', 'updated_at', 'deleted_at');
    }
    // lấy dữ liệu bảng n-n producers dc active

    // public static function getDiseasesName($vaccine_id) {
    //     $arr_name = Disease::select('diseases.name')
    //     ->join('vaccine_disease', 'vaccine_disease.disease_id', '=', 'diseases.id')
    //     ->where('vaccine_disease.vaccine_id', $vaccine_id)
    //     ->get()->toArray();

    //     $str_name = "";
    //     foreach ($arr_name as $key => $item) {
    //         if ($key == 0)
    //             $str_name .= $item['name'];
    //         else 
    //             $str_name .= ', '.$item['name'];
    //     }

    //     return $str_name;
    // }
}
