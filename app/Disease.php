<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Disease extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description', 'is_active'
    ];

    public function hasManyVaccineDisease ()
    {
        return $this->hasMany('App\VaccineDisease', 'vaccine_id', 'id');
    }

    public function belongsToManyActiveVaccines () {
        return $this->belongsToMany('App\Vaccine', 'vaccine_disease', 'disease_id', 'vaccine_id')->where('is_active', 1)->withPivot('id', 'vaccine_id', 'disease_id', 'created_at', 'updated_at', 'deleted_at');
    }
    // lấy dữ liệu bảng n-n vaccines dc active
}
