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


    public function hasManyVaccineDisease (){
        return $this->hasMany('App\VaccineDisease', 'vaccine_id', 'id');
    }

    public function hasManyVaccineProducer () {
        return $this->hasMany('App\VaccineProducer', 'vaccine_id', 'id');
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
